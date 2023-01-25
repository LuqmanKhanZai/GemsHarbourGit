@extends('layouts.app')

{{-- For Title --}}
@section('title')  Stores List @endsection

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
        <h2>Stores List</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{url('home')}}">Home</a>
            </li>
            <li>
                <a>Stores</a>
            </li>
            <li class="active">
                <strong>Stores List</strong>
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
                    <h5>Stores List</h5>
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
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <!-- <th>Address</th>
                                    <th>Country</th>
                                    <th>City</th>
                                    <th>State</th>
                                    <th>Website</th> -->
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($stores as $key=> $store)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{$store->user->username}}</td>
                                    <td>{{$store->name}}</td>
                                    <td>{{$store->email}}</td>
                                    <td>{{$store->phone}}</td>
                                  <!--   <td>{{$store->address}}</td>
                                    <td>{{$store->country}}</td>
                                    <td>{{$store->city}}</td>
                                    <td>{{$store->state}}</td>
                                    <td>{{$store->website}}</td> -->
                                    <td id="{{$store->id}}">
                                        @if($store->status == 'Active')
                                        <span class="btn badge badge-info">{{$store->status}}</span>
                                        @else
                                        <span class="btn badge badge-danger">{{$store->status}}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-xs">
                                            <a onclick="StoreDetails({{$store}})" data-toggle="modal" data-target="#StoreDetails" class="btn btn-info"><i class="fa fa-eye"></i></a>
                                            <a onclick="StatusUpdate({{$store->id}},{{$store->user_id}})" class="btn btn-warning"><i class="fa fa-ban"></i></a>
                                            <!--<a onclick="SupplierModal_({{$store->id}})" class="btn btn-success"><i class="fa fa-edit"></i></a>-->
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


<div class="modal inmodal fade" id="StoreDetails" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <div class="modal-body">
                <div class="col-lg-12">
                    <h5>Store Details</h5>
                    <div class="contact-box">

                        <div class="row">
                            <div class="col-md-12">
                                <h3>User Information</h3>
                                <div class="profile-image">
                                    <img src="" id="userImage" class="img-circle circle-border m-b-md" alt="profile">
                                </div>
                                <div class="profile-info">
                                    <div class="">
                                        <div>
                                            <h2 class="no-margins" id="username"></h2>
                                            <h4 id="userusername"></h4>
                                            <small id="useremail"></small>
                                            <h5 id="usercontact"></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
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
    function StatusUpdate(id,user_id){
        $.ajax({
            url:'{{url("store/status")}}',
            data: {
                "_token"    :"{{csrf_token()}}",
                id:id,
                user_id:user_id,
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

    function StoreDetails(store){
        console.log(store);
        console.log(store.name);

        document.getElementById('userImage').src = '{{asset("")}}' + store.user.url;
        document.getElementById('username').innerHTML = store.user.name;
        document.getElementById('userusername').innerHTML = store.user.username;
        document.getElementById('useremail').innerHTML = store.user.email;
        document.getElementById('usercontact').innerHTML = store.user.contact;

        document.getElementById('storeImage').src = '{{asset("")}}' +store.url;
        document.getElementById('store_name').innerHTML = store.name;
        document.getElementById('store_email').innerHTML = store.email;
        document.getElementById('store_phone').innerHTML = store.phone;
        document.getElementById('store_country').innerHTML = store.country;
        document.getElementById('store_city').innerHTML = store.city;
        document.getElementById('store_state').innerHTML = store.state;
        document.getElementById('store_address').innerHTML = store.address;
        document.getElementById('store_website').innerHTML = store.website;
    }
</script>

@endsection
