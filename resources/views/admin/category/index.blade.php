@extends('layouts.app')
{{-- For Title --}}
@section('title')  Category @endsection
{{-- Main Content --}}
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Category List</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{url('home')}}">Home</a>
            </li>
            <li>
                <a>Category</a>
            </li>
            <li class="active">
                <strong>Category List</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">
        <a class="btn btn-info btn-outline" data-toggle="modal" data-target="#myModal6" style="margin-top:40px;">Add Category</a>
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
                    <h5>Category List</h5>
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
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $key=> $category)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{$category->name}}</td>
                                    <td id="{{$category->id}}">
                                        @if($category->status == 'Active')
                                        <span class="btn badge badge-info">{{$category->status}}</span>
                                        @elseif ($category->status == 'Permanent')
                                        <span class="btn badge badge-primary">{{$category->status}}</span>
                                        @else
                                        <span class="btn badge badge-danger">{{$category->status}}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-xs">
                                            <a onclick="StatusUpdate({{$category->id}})" class="btn btn-warning"><i class="fa fa-ban"></i></a>
                                            <a onclick="ChartModel({{$category->id}})" class="btn btn-success"><i class="fa fa-edit"></i></a>
                                            <a href="{{url('category/delete',$category->id)}}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
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
                <h4 class="modal-title">Add Category</h4>
            </div>
            <div class="modal-body">
                <form action="{{route('category.store')}}" method="POST" id="form" enctype="multipart/form-data">
                    {{csrf_field()}}
                        <div class="form-group">
                            <label for="">Name</label>
                            <input type="text" class="form-control" name="name" value="{{old('name')}}">
                        </div>
                        <div class="form-group">
                            <label for="">Image</label>
                            <input type="file" class="form-control" name="image">
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
                <h4 class="modal-title">Update Category</h4>
            </div>
            <div class="modal-body">
                <form  method="POST" action="{{route('category.update')}}" enctype="multipart/form-data">
                    {{csrf_field()}}
                        <div class="form-group">
                            <label for="">Name</label>
                            <input type="text" id="categoryname" class="form-control" name="name">
                            <input type="hidden" id="category_id" class="form-control" name="category_id">
                        </div>
                        <div class="form-group">
                            <label for="">Image</label>
                            <input type="file" class="form-control" id="image" name="image">
                        </div>
                        <div class="form-group">
                            <label for=""></label>
                            <input type="submit" class="btn btn-info  btn-block" value="Update">
                        </div>
                </form>
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
    function StatusUpdate(chart_id){
        // alert(chart_id);
        // return false;
        $.ajax({
            url:'{{url("category/status")}}',
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

    function ChartModel(id){
        $.ajax({
            url:'{{url("category/modal")}}',
            data:    {
                "_token"    :"{{csrf_token()}}",
                id:id,
            },
            type: "POST",
            success: function(data){
                    $("#ModalUpdate").modal('show');
                    $("#categoryname").val(data.name);
                    $("#category_id").val(data.id);
            },
            error: function(error){
                toastr.error('Some Thing Went Wrong','ERROR !')
            }
        });
    }

    // function UpdateChart(){

    //     var formdata = $('#form_update').serialize();
    //     console.log(formdata);
    //     $.ajax({
    //         type : "POST",
    //         url:'{{url("category/update")}}',
    //         data: formdata,
    //         success: function(data){
    //             toastr.success('Account Update');
    //         },
    //         error: function (error){
    //             toastr.error('Some Thing Went Wrong','ERROR !')
    //         }
    //     });
    // }
</script>
@endsection
