@extends('layouts.app')



{{-- For Title --}}

@section('title')  Product @endsection



{{-- Main Content --}}

@section('content')



<div class="row wrapper border-bottom white-bg page-heading">

    <div class="col-lg-10">

        <h2>Product List</h2>

        <ol class="breadcrumb">

            <li>

                <a href="{{url('home')}}">Home</a>

            </li>

            <li>

                <a>Product</a>

            </li>

            <li class="active">

                <strong>Product List</strong>

            </li>

        </ol>



    </div>

    <div class="col-lg-2">

        <a class="btn btn-info btn-outline" href="{{route('product.create')}}" style="margin-top:40px;">Add Product</a>

    </div>

</div>

<div class="row">

    <div class="col-md-4 col-md-offset-4">

        @if ($errors->any())

            <div class="alert alert-danger alert-dismissible" style="margin-top:40px;">

                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>

                    @foreach ($errors->all() as $error)

                        <p style="text-align: center;"><strong >{{ $error }}</strong></p>

                    @endforeach

            </div>

        @endif

    </div>

</div>



<div class="wrapper wrapper-content animated fadeInRight">

    <div class="row">

        <div class="col-lg-12">

            <div class="ibox float-e-margins">

                <div class="ibox-title">

                    <h5>Product List</h5>

                    <div class="ibox-tools">

                        <a class="collapse-link">

                            <i class="fa fa-chevron-up"></i>

                        </a>



                        <a class="close-link">

                            <i class="fa fa-times"></i>

                        </a>

                    </div>

                </div>

                <div class="ibox-content">



                    <div class="table-responsive">

                        <table class="table table-striped table-bordered table-hover dataTables-example" >

                            <thead>

                                <tr>

                                    <th>#</th>

                                    <th>User Name</th>

                                    <th>Category</th>

                                    <th>Store</th>

                                    <th>Product Name</th>

                                    <th>Status</th>

                                    <th>Action</th>

                                </tr>

                            </thead>

                            <tbody>

                                @foreach ($products as $key=> $product)

                                <tr>

                                    <td>{{ $key + 1 }}</td>

                                    <td>{{$product->user->username}}</td>

                                    <td>{{$product->category->name}}</td>

                                    <td>{{$product->store->name}}</td>

                                    <td>{{$product->title}}</td>

                                    <td id="{{$product->id}}">

                                        @if($product->status == 'Active')

                                        <span class="btn badge badge-info">{{$product->status}}</span>

                                        @elseif ($product->status == 'Permanent')

                                        <span class="btn badge badge-primary">{{$product->status}}</span>

                                        @else

                                        <span class="btn badge badge-danger">{{$product->status}}</span>

                                        @endif

                                    </td>

                                    <td>

                                        <div class="btn-group btn-group-xs">

                                            <a onclick="ProductShow({{$product}})" data-toggle="modal" data-target="#ProductShow" class="btn btn-info"><i class="fa fa-eye"></i></a>

                                            <a onclick="StatusUpdate({{$product->id}})" class="btn btn-warning"><i class="fa fa-ban"></i></a>

                                            <a href="{{route('product.edit',$product->id)}}" class="btn btn-success"><i class="fa fa-edit"></i></a>

                                            <a href="{{url('product/delete',$product->id)}}" class="btn btn-danger"><i class="fa fa-trash"></i></a>

                                        </div>

                                    </td>

                                </tr>

                                @endforeach

                            </tbody>



                        </table>

                    </div>



                </div>

            </div>

        </div>

    </div>

</div>



<div class="modal inmodal fade" id="ProductShow" tabindex="-1" role="dialog"  aria-hidden="true">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">



            <div class="modal-body">

                <div class="col-lg-12">

                    <h5>Product Details</h5>

                    <div class="contact-box">



                        <div class="row">

                            <div class="col-md-12">

                                <table class="table table-striped table-bordered">

                                        <tr>

                                            <th>Username</th>

                                            <th>Category</th>

                                            <th>Store</th>

                                            <th>Product Name</th>

                                        </tr>

                                        <tr>

                                            <td id="username"></td>

                                            <td id="category"></td>

                                            <td id="store"></td>

                                            <td id="productname"></td>

                                        </tr>

                                </table>

                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-8">

                                <div class="ibox">

                                    <div class="ibox-content">

                                        <h3>Description</h3>

                                        <p class="small" id="description"></p>

                                        <!-- <p>Description : <strong id="description"></strong></p> -->

                                        <p>Dimention : <strong id="dimension"></strong></p>

                                        <p>Dimention X : <strong id="dimension_x"></strong></p>

                                        <p>Dimention Y : <strong id="dimension_y"></strong></p>

                                        <p>Weight : <strong id="weight"></strong></p>

                                        <p>Check If this gemstone is lab-tested and Certified to genuine :<strong id="certified"> </strong></p>

                                        <p>I Clarity :<strong id="clarity_i"> </strong></p>

                                        <p>If internally Flawless :<strong id="clarity_if"> </strong></p>

                                        <p>SI Clarity :<strong id="clarity_si"></strong></p>

                                        <p>VS Clarity :<strong id="clarity_vs"> </strong></p>

                                        <p>VVS Clarity :<strong id="clarity_vvs"> </strong></p>

                                        <p>Gemstone not treated in anyway :<strong id="no_treatment">  </strong></p>

                                        <p>Listing Type : <strong id="listing_type"></strong></p>

                                        <p>Duration : <strong id="duration"></strong></p>

                                        <p>Item Type : <strong id="item_type"></strong></p>

                                    </div>

                                </div>

                            </div>

                            <div class="col-md-4">

                                <!-- <div class="row" id="ProductImages">



                                </div> -->

                                <div class="ibox">

                                    <div class="ibox-content">

                                        <h3>Product Images</h3>

                                        <div class="user-friends" id="ProductImages">

                                        </div>

                                    </div>

                                </div>



                                <div class="ibox">

                                    <div class="ibox-content">

                                        <h3>Product Details</h3>



                                        <p>Strating Price : <strong id="starting_price"></strong></p>

                                        <p>Reserve Price : <strong id="reserve_price"></strong></p>

                                        <p>Now Price : <strong id="now_price"></strong></p>

                                        <p>RRP Price : <strong id="rrp_price"></strong></p>

                                        <p>Offer : <strong id="offer"></strong></p>

                                        <p>Start Date : <strong id="start_date"></strong></p>

                                        <p>Shipping Details : <strong id="shipping_details"></strong></p>

                                        <p>Shipping Price : <strong id="shipping_price"></strong></p>

                                        <p>Shipping Cost : <strong id="shipping_cost"></strong></p>

                                    </div>

                                </div>



                                <!-- <div class="ibox">

                                    <div class="ibox-content">

                                        <h3>Product Images</h3>

                                        <div class="user-friends">



                                            <a href=""><img alt="image" class="img-circle" src="{{ asset('admin_file/img/a1.jpg') }}"></a>

                                            <a href=""><img alt="image" class="img-circle" src="{{ asset('admin_file/img/a2.jpg') }}"></a>

                                            <a href=""><img alt="image" class="img-circle" src="{{ asset('admin_file/img/a3.jpg') }}"></a>

                                            <a href=""><img alt="image" class="img-circle" src="{{ asset('admin_file/img/a4.jpg') }}"></a>

                                            <a href=""><img alt="image" class="img-circle" src="{{ asset('admin_file/img/a5.jpg') }}"></a>

                                            <a href=""><img alt="image" class="img-circle" src="{{ asset('admin_file/img/a6.jpg') }}"></a>

                                        </div>

                                    </div>

                                </div> -->



                            </div>

                        </div>



                    </div>

                </div>

            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>

            </div>

        </div>

    </div>

</div>





@endsection



@section('script')



<script>



    function ProductShow(product){

        console.log(product);

        //   document.getElementById('id').innerHTML = product.id;

        document.getElementById('productname').innerHTML = product.title;

        document.getElementById('category').innerHTML = product.category.name;

        document.getElementById('store').innerHTML = product.store.name;

        document.getElementById('username').innerHTML = product.user.username;

        // p tag

        document.getElementById('description').innerHTML = product.description;

        document.getElementById('dimension').innerHTML = product.dimension;

        document.getElementById('dimension_x').innerHTML = product.dimension_x;

        document.getElementById('dimension_y').innerHTML = product.dimension_y;

        document.getElementById('weight').innerHTML = product.weight;

        document.getElementById('certified').innerHTML = product.certified;

        document.getElementById('clarity_i').innerHTML = product.clarity_i;

        document.getElementById('clarity_if').innerHTML = product.clarity_if;

        document.getElementById('clarity_si').innerHTML = product.clarity_si;

        document.getElementById('clarity_vs').innerHTML = product.clarity_vs;

        document.getElementById('clarity_vvs').innerHTML = product.clarity_vvs;

        document.getElementById('no_treatment').innerHTML = product.no_treatment;

        document.getElementById('listing_type').innerHTML = product.listing_type;

        document.getElementById('duration').innerHTML = product.duration;

        document.getElementById('item_type').innerHTML = product.item_type;

        // Images

        // console.log(product.images);

        // var htm = '<h4>Product Images</h4>';

        var htm = '';

        var counter = 1;

        for(let i=0;i<product.images.length;i++){

              htm +=`<a href=""><img alt="image" class="img-circle" src=https://gemsharbor.mdotts.com/portal/public/`+product.images[i].url+`></a>`;



            // htm +=`<div class="col-md-6" style="width:100%;"><img class="img-circle m-t-xs img-responsive" src=`+product.images[i].url+` id="imageUrl"></div>`;

            // htm +=`<div class="col-md-6" style="width:100%;">`+product.images[i].url+`</div>`;

            counter++;

        }

        document.getElementById('ProductImages').innerHTML = htm;



        // Below Image TExt

        document.getElementById('starting_price').innerHTML = product.starting_price;

        document.getElementById('reserve_price').innerHTML = product.reserve_price;

        document.getElementById('now_price').innerHTML = product.now_price;

        document.getElementById('rrp_price').innerHTML = product.rrp_price;

        document.getElementById('offer').innerHTML = product.offer;

        document.getElementById('start_date').innerHTML = product.start_date;

        document.getElementById('shipping_details').innerHTML = product.shipping_details;

        document.getElementById('shipping_price').innerHTML = product.shipping_price;

        document.getElementById('shipping_cost').innerHTML = product.shipping_cost;







    }



    function StatusUpdate(chart_id){

        // alert(chart_id);

        // return false;

        $.ajax({

            url:'{{url("product/status")}}',

            data: {

                "_token"    :"{{csrf_token()}}",

                chart_id:chart_id,

            },

            type: "POST",

            success: function(data){

                var val = data.status

                var html = '';

                if(val == "Active"){

                    html = "<span class='btn badge badge-info'>Active</span>";

                }else{

                    html = "<span class='btn badge badge-danger'>Disabled</span>";

                }

                document.getElementById(chart_id).innerHTML=html;



                toastr.success("Status Update");

            },



            error: function(error){

                toastr.error('Some Thing Went Wrong','ERROR !')

            }

        });

    }

</script>

@endsection

