@extends('layouts.app')

{{-- For Title --}}
@section('title')  Contacts List @endsection

{{-- Main Content --}}
@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Contacts List</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{url('home')}}">Home</a>
            </li>
            <li>
                <a>Contacts</a>
            </li>
            <li class="active">
                <strong>Contacts List</strong>
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
                    <h5>Contacts List</h5>
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
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th>Message</th>
                                    {{-- <th>Status</th> --}}
                                    {{-- <th>Action</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($contacts as $key=> $contact)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{$contact->firstname}}</td>
                                    <td>{{$contact->lastname}}</td>
                                    <td>{{$contact->email}}</td>
                                    <td>{{$contact->message}}</td>
                                    {{-- <td id="{{$contact->id}}">
                                        @if($contact->status == 'Active')
                                        <span class="btn badge badge-info">{{$contact->status}}</span>
                                        @else
                                        <span class="btn badge badge-danger">{{$contact->status}}</span>
                                        @endif
                                    </td> --}}
                                    {{-- <td>
                                        <div class="btn-group btn-group-xs">
                                            <a onclick="StoreDetails({{$contact}})" data-toggle="modal" data-target="#StoreDetails" class="btn btn-info"><i class="fa fa-eye"></i></a>
                                            <a onclick="StatusUpdate({{$contact->id}},{{$contact->user_id}})" class="btn btn-warning"><i class="fa fa-ban"></i></a>
                                        </div>
                                    </td> --}}
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




@endsection

@section('script')

@endsection
