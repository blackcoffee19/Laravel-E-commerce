@extends('layout.masterAdmin')
@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Loại sản phẩm
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
                    <th>Tên loại</th>
                    <th>Mô tả</th>
                    <th>Hình</th>
                    <th>Edit</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($types as $type)
                <tr class="odd gradeX" align="center">
                    <td>{{$type->id}}</td>
                    <td>{{$type->name}}</td>
                    <td style="width: 450px;">{{$type->description}}</td>
                    <td><img src="resources/frontend/image/product/{{$type->image}}" width="150" alt="{{$type->name}}"></td>
                    <td class="center"><i class="fa fa-pencil fa-fw"></i> <a href="{{route('editloai',$type->id)}}">Edit</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- /.container-fluid -->
</div>
@endsection
