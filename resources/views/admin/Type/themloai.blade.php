@extends('layout.masterAdmin')
@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Loại sản phẩm
                    <small>Thêm mới</small>
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
                <form action="{{route('themloai')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>Tên loại</label>
                        <input class="form-control" name="name" placeholder="Nhập tên loại sản phẩm" />
                        @if ($errors->has('name'))
                        <span class="text-danger">{{$errors->first('name')}}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Mô tả loại sản phẩm</label>
                        <textarea class="form-control" rows="3" name="des"></textarea>
                        @if ($errors->has('des'))
                        <span class="text-danger">{{$errors->first('des')}}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Hình sản phẩm</label>
                        <input type="file" name="fImages">
                    </div>
                    <button type="submit" class="btn btn-default">Thêm loại</button>
                    <button type="reset" class="btn btn-default">Reset</button>
                <form>
            </div>
    </div>
</div>
@endsection
