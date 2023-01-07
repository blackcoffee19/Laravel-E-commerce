@extends('layout.masterAdmin')
@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">User
                    <small>Danh sách</small>
                </h1>
            </div>
        </div>
        @if (Session::has('thongbao'))
            <p class="alert alert-warning">{{Session::get('thongbao')}}</p>
        @endif
        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
            <thead>
                <tr align="center">
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Email</th>
                    <th>Địa chỉ</th>
                    <th>Số điện thoại</th>
                    <th>Delete</th>
                    <th>Edit</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $usr)
                <tr class="odd gradeX" align="center">
                    <td>{{$usr->id}}</td>
                    <td>{{$usr->full_name}}</td>
                    <td>{{$usr->email}}</td>
                    <td>{{$usr->address}}</td>
                    <td>{{$usr->phone}}</td>
                    <td class="center"><i class="fa fa-trash-o  fa-fw"></i><a href="{{route('xoauser',$usr->id)}}" onclick="return confirm('Bạn có chắc xóa {{$usr->full_name}}?')"> Delete</a></td>
                    <td class="center"><i class="fa fa-pencil fa-fw"></i> <a href="{{route('edituser',$usr->id)}}">Edit</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

@endsection
