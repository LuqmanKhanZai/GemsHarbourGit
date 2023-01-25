@extends('layouts.app')

{{-- For Title --}}
@section('title')  Buyers List @endsection

{{-- Main Content --}}
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">

        <h2>Buyers List</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{url('home')}}">Home</a>
            </li>
            <li>
                <a>Buyers</a>
            </li>
            <li class="active">
                <strong>Buyers List</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">
        <a href="" class="btn btn-info btn-outline" data-toggle="modal" data-target="#myModal6" style="margin-top:40px;">Add Buyer</a>
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
                    <h5>Buyers List</h5>
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
                                @foreach ($buyers as $key=> $buyer)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{$buyer->name}}</td>
                                    <td>{{$buyer->username}}</td>
                                    <td>{{$buyer->email}}</td>
                                    <td id="{{$buyer->id}}">
                                        @if($buyer->status == 'Active')
                                        <span class="btn badge badge-info">{{$buyer->status}}</span>
                                        @else
                                        <span class="btn badge badge-danger">{{$buyer->status}}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-xs">
                                            <a onclick="BuyerDetails({{$buyer}})" data-toggle="modal" data-target="#BuyerDetails" class="btn btn-info"><i class="fa fa-eye"></i></a>
                                            <a onclick="StatusUpdate({{$buyer->id}})" class="btn btn-warning"><i class="fa fa-ban"></i></a>
                                            <a onclick="BuyerModal({{$buyer->id}})" class="btn btn-success"><i class="fa fa-edit"></i></a>
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
                <h4 class="modal-title">Add Buyer</h4>
            </div>
            <div class="modal-body">
                <form action="{{route('buyer.store')}}" id="form" method="POST">
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
                <h4 class="modal-title">Update Buyer</h4>
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
                            <input type="button" onclick="UpdateBuyer()" class="btn btn-info  btn-block" value="Update">
                        </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<div class="modal inmodal fade" id="BuyerDetails" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <div class="modal-body">
                <div class="col-lg-12">
                    <h5>Buyer Details</h5>
                    <div class="contact-box">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="profile-image">
                                    <img src="" id="userImage" class="img-circle circle-border m-b-md" alt="profile">
                                </div>
                                <div class="profile-info">
                                    <div class="">
                                        <div>
                                            <h2 class="no-margins" id="buyername"></h2>
                                            <h4 id="buyerusername"></h4>
                                            <small id="buyeremail"></small>
                                            <h5 id="buyercontact"></h5>
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
                                        <p>Address : <strong id="buyer_address"></strong></p>
                                        <p>City/Town : <strong id="buyer_city"></strong></p>
                                        <p>State/Province : <strong id="buyer_state"></strong></p>
                                        <p>Country : <strong id="buyer_country"></strong></p>
                                        <p>Zip Code :<strong id="buyer_zipcode"> </strong></p>
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
        $.ajax({
            url:'{{url("buyer/status")}}',
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

    function BuyerModal(id){
        // alert(id);
        // return false;
        $.ajax({
            url:'{{url("buyer/modal")}}',
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

    function UpdateBuyer(){

        var formdata = $('#form_update').serialize();
        $.ajax({
            type : "POST",
            url:'{{url("buyer/update")}}',
            data: formdata,
            success: function(data){
                $("#ModalUpdate").modal('hide');
                setTimeout(function(){// wait for 5 secs(2)
                    location.reload(); // then reload the page.(3)
                }, 100);
                toastr.success('Buyer Account Updated');
            },
            error: function (error){
                toastr.error('Some Thing Went Wrong','ERROR !')
            }
        });
    }

    function BuyerDetails(buyer){
        document.getElementById('userImage').src = buyer.url;
        document.getElementById('buyername').innerHTML = buyer.name;
        document.getElementById('buyerusername').innerHTML = buyer.username;
        document.getElementById('buyeremail').innerHTML = buyer.email;
        document.getElementById('buyercontact').innerHTML = buyer.contact;
        document.getElementById('buyer_address').innerHTML = buyer.address;
        document.getElementById('buyer_state').innerHTML = buyer.state;
        document.getElementById('buyer_city').innerHTML = buyer.city;
        document.getElementById('buyer_country').innerHTML = buyer.country;
        document.getElementById('buyer_zipcode').innerHTML = buyer.zipcode;
    }
</script>

@endsection
