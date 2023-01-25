@extends('layouts.app')

{{-- For Title --}}
@section('title')  Sellers List @endsection

{{-- Main Content --}}
@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Sellers List</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{url('home')}}">Home</a>
            </li>
            <li>
                <a>Sellers</a>
            </li>
            <li class="active">
                <strong>Sellers List</strong>
            </li>
        </ol>
    </div>
    <!-- <div class="col-lg-2">
        <a href="" class="btn btn-info btn-outline" data-toggle="modal" data-target="#myModal6" style="margin-top:40px;">Add Seller</a>
    </div> -->
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Sellers List</h5>
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
                                    <th>Name</th>
                                    <th>User Name</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sellers as $key=> $seller)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{$seller->name}}</td>
                                    <td>{{$seller->username}}</td>
                                    <td>{{$seller->email}}</td>
                                    <td id="{{$seller->id}}">
                                        @if($seller->status == 'Active')
                                        <span class="btn badge badge-info">{{$seller->status}}</span>
                                        @else
                                        <span class="btn badge badge-danger">{{$seller->status}}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-xs">
                                            <a onclick="SellerDetails({{$seller}})" data-toggle="modal" data-target="#SellerDetails" class="btn btn-info"><i class="fa fa-eye"></i></a>
                                            <a onclick="StatusUpdate({{$seller->id}})" class="btn btn-warning"><i class="fa fa-ban"></i></a>
                                            <a onclick="SupplierModal({{$seller->id}})" class="btn btn-success"><i class="fa fa-edit"></i></a>
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

<div class="modal inmodal fade" id="myModal6" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Add Seller</h4>
            </div>
            <div class="modal-body">
                <form action="{{route('seller.store')}}" method="POST" id="form">
                    {{csrf_field()}}
                        <div class="form-group">
                            <label for="">Name</label>
                            <input type="text" class="form-control" name="name" value="{{old('name')}}">
                        </div>
                        <div class="form-group">
                            <label for="">User Name</label>
                            <input type="text" class="form-control" name="username" value="{{old('username')}}">
                        </div>
                        <div class="form-group">
                            <label for="">Email</label>
                            <input type="email" class="form-control" name="email" value="{{old('email')}}">
                        </div>
                        <div class="form-group">
                            <label for="">Password</label>
                            <input type="password" class="form-control" name="password" value="{{old('password')}}">
                        </div>

                        <div class="form-group">
                            <label for="">Confirm Password</label>
                            <input type="password" class="form-control" name="password_confirmation" value="{{old('password_confirmation')}}">
                        </div>
                        <div class="form-group">
                            <label for=""></label>
                            <input type="submit" class="btn btn-info  btn-block" name="submit" value="Save">
                        </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal inmodal fade" id="ModalUpdate" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Update Seller Account</h4>
            </div>
            <div class="modal-body">
                <form  id="form_update" method="POST">
                    {{csrf_field()}}
                        <div class="form-group">
                            <label for="">Name</label>
                            <input type="text" id="name" class="form-control" name="name">
                            <input type="hidden" id="id" class="form-control" name="id">
                        </div>
                        <div class="form-group">
                            <label for="">Email</label>
                            <input type="text" class="form-control" id="email" name="email">
                        </div>
                        <div class="form-group">
                            <label for="">Username</label>
                            <input type="text" class="form-control" id="username" name="username">
                        </div>

                        <div class="form-group">
                            <label for="">Password</label>
                            <input type="text" class="form-control" id="password" name="password">
                        </div>
                        <div class="form-group">
                            <label for=""></label>
                            <input type="button" onclick="UpdateSeller()" class="btn btn-info  btn-block" value="Update">
                        </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal inmodal fade" id="SellerDetails" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <div class="modal-body">
                <div class="col-lg-12">
                    <h5>Seller Details</h5>
                    <div class="contact-box">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="profile-image">
                                    <img src="" id="userImage" class="img-circle circle-border m-b-md" alt="profile">
                                </div>
                                <div class="profile-info">
                                    <div class="">
                                        <div>
                                            <h2 class="no-margins" id="sellername"></h2>
                                            <h4 id="sellerusername"></h4>
                                            <small id="selleremail"></small>
                                            <h5 id="sellercontact"></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="ibox">
                                    <div class="ibox-content">
                                        <h3>Shipping Address</h3>
                                        <p>Address : <strong id="seller_address"></strong></p>
                                        <p>City/Town : <strong id="seller_city"></strong></p>
                                        <p>State/Province : <strong id="seller_state"></strong></p>
                                        <p>Country : <strong id="seller_country"></strong></p>
                                        <p>Zip Code : <strong id="seller_zipcode"> </strong></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="ibox">
                                    <div class="ibox-content">
                                        <h3>Store Information</h3>
                                        <div class="row">
                                            <div class="profile-image" style="text-align: center;">
                                                <img src="" id="storeImage" class="img-circle circle-border m-b-md" alt="profile">
                                            </div>
                                        </div>
                                        <p>Store Name <strong id="store_name"></strong></p>
                                        <p>Email : <strong id="store_email"></strong></p>
                                        <p>Phone No : <strong id="store_phone"></strong></p>
                                        <p>Country : <strong id="store_country"></strong></p>
                                        <p>City :<strong id="store_city"> </strong></p>
                                        <p>State :<strong id="store_state"> </strong></p>
                                        <p>Address :<strong id="store_address"> </strong></p>
                                        <p>Website :<strong id="store_website"> </strong></p>
                                    </div>
                                </div>
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
    function StatusUpdate(id){
        // alert(id);
        // return false;
        $.ajax({
            url:'{{url("seller/status")}}',
            data: {
                "_token"    :"{{csrf_token()}}",
                id:id,
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
                document.getElementById(id).innerHTML=html;

                toastr.success("Status Update");
            },

            error: function(error){
                toastr.error('Some Thing Went Wrong','ERROR !')
            }
        });
    }

    function SupplierModal(id){
        // alert(id);
        // return false;
        $.ajax({
            url:'{{url("seller/modal")}}',
            data:    {
                "_token"    :"{{csrf_token()}}",
                id:id,
            },
            type: "POST",
            success: function(data){
                $("#ModalUpdate").modal('show');
                $("#name").val(data.name);
                $("#id").val(data.id);
                $("#email").val(data.email);
                $("#username").val(data.username);
                $("#password").val(data.p_text);
            },
            error: function(error){
                toastr.error('Some Thing Went Wrong','ERROR !')
            }
        });
    }

    function UpdateSeller(){

        var formdata = $('#form_update').serialize();
        $.ajax({
            type : "POST",
            url:'{{url("seller/update")}}',
            data: formdata,
            success: function(data){
                  $("#ModalUpdate").modal('hide');
                setTimeout(function(){// wait for 5 secs(2)
                    location.reload(); // then reload the page.(3)
                }, 100);
                toastr.success('Seller Account Updated');
            },
            error: function (error){
                toastr.error('Some Thing Went Wrong','ERROR !')
            }
        });
    }

    function SellerDetails(seller){
        console.log(seller);
        console.log(seller.name);


        document.getElementById('userImage').src = seller.url;
        document.getElementById('sellername').innerHTML = seller.name;
        document.getElementById('sellerusername').innerHTML = seller.username;
        document.getElementById('selleremail').innerHTML = seller.email;
        document.getElementById('sellercontact').innerHTML = seller.contact;
        document.getElementById('seller_address').innerHTML = seller.address;
        document.getElementById('seller_state').innerHTML = seller.state;
        document.getElementById('seller_city').innerHTML = seller.city;
        document.getElementById('seller_country').innerHTML = seller.country;
        document.getElementById('seller_zipcode').innerHTML = seller.zipcode;

        document.getElementById('storeImage').src = seller.store.url;
        document.getElementById('store_name').innerHTML = seller.store.name;
        document.getElementById('store_email').innerHTML = seller.store.email;
        document.getElementById('store_phone').innerHTML = seller.store.phone;
        document.getElementById('store_country').innerHTML = seller.store.country;
        document.getElementById('store_city').innerHTML = seller.store.city;
        document.getElementById('store_state').innerHTML = seller.store.state;
        document.getElementById('store_address').innerHTML = seller.store.address;
        document.getElementById('store_website').innerHTML = seller.store.website;
    }
</script>

@endsection
