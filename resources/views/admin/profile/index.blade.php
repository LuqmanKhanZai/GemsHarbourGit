@extends('layouts.app')

{{-- For Title --}}
@section('title')  Profile @endsection

{{-- Main Content --}}
@section('content')

{{-- <div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Profile Details</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{url('home')}}">Home</a>
            </li>
            <li>
                <a>Profile Details</a>
            </li>
            <li class="active">
                <strong>Profile Details</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">
        <a href="" class="btn btn-info btn-outline" data-toggle="modal" data-target="#myModal6" style="margin-top:40px;">Add Seller</a>
    </div>
</div> --}}

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-6 col-md-offset-3">
            <div class="ibox">
                <div class="ibox-content">
                    <h3>Update Profile Form</h3>
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" value="{{$user->name}}">
                    </div>
                    <div class="form-group">
                        <label>UserName</label>
                        <input type="text" name="username" class="form-control" value="{{$user->username}}">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" name="email" class="form-control" value="{{$user->email}}">
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="text" name="password" class="form-control" value="{{$user->p_text}}">
                    </div>
                    <div class="form-group">
                        <label>Image</label>
                        <input type="file" name="image" class="form-control">
                    </div>

                    <button class="btn btn-primary btn-block">Update</button>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
    function StatusUpdate(id){
        $.ajax({
            url:'{{url("store/status")}}',
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

    // function SupplierModal(id){
    //     // alert(id);
    //     // return false;
    //     $.ajax({
    //         url:'{{url("seller/modal")}}',
    //         data:    {
    //             "_token"    :"{{csrf_token()}}",
    //             id:id,
    //         },
    //         type: "POST",
    //         success: function(data){
    //             $("#ModalUpdate").modal('show');
    //             $("#name").val(data.name);
    //             $("#id").val(data.id);
    //             $("#email").val(data.email);
    //             $("#username").val(data.username);
    //             $("#password").val(data.p_text);
    //         },
    //         error: function(error){
    //             toastr.error('Some Thing Went Wrong','ERROR !')
    //         }
    //     });
    // }

    // function UpdateSeller(){

    //     var formdata = $('#form_update').serialize();
    //     $.ajax({
    //         type : "POST",
    //         url:'{{url("seller/update")}}',
    //         data: formdata,
    //         success: function(data){
    //             toastr.success('Seller Account Updated');
    //         },
    //         error: function (error){
    //             toastr.error('Some Thing Went Wrong','ERROR !')
    //         }
    //     });
    // }
</script>

@endsection
