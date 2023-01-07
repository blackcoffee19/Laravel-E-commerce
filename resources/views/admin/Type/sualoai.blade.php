@extends('layout.masterAdmin')
@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Loại sản phẩm
                    <small>Sửa</small>
                </h1>
            </div>
        </div>
        @if (Session::has('loi'))
            <p class="alert alert-warning">{{Session::get('loi')}}</p>
        @endif
        @if (Session::has('thongbao'))
            <p class="alert alert-success">{{Session::get('thongbao')}}</p>
        @endif
        <!-- /.col-lg-12 -->
        <div class="col-lg-7" style="padding-bottom:120px">
            <form action="{{route('editloai')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id"value="{{$type->id}}">
                <div class="form-group">
                    <label>Tên loại</label>
                    <input class="form-control" name="name" value="{{$type->name}}" />
                    @if ($errors->has('name'))
                    <span class="text-danger">{{$errors->first('name')}}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label>Mô tả sản phẩm</label>
                    <textarea class="form-control" rows="3" name="des">{{$type->description}}</textarea>
                </div>
                <div class="form-group">
                    <label>Hình loại sản phẩm</label>
                    <input type="file" name="fImages">
                    <img src="resources/frontend/image/product/{{$type->image}}" width="150" alt="">
                </div>
                <button type="submit" class="btn btn-default">Sửa loại</button>
                <button type="reset" class="btn btn-default">Reset</button>
            <form>
        </div>


    </div>

</div>
@endsection
