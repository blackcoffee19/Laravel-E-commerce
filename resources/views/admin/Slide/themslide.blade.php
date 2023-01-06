@extends('layout.masterAdmin')
@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Slide
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
            <form action="{{route('themslide')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label>Link Slide</label>
                    <input class="form-control" name="link" placeholder="Nhập link slide" />
                </div>
                <div class="form-group">
                    <label>Hình Slide</label>
                    <input type="file" name="fImages">
                </div>
                <button type="submit" class="btn btn-default">Thêm Slide</button>
                <button type="reset" class="btn btn-default">Reset</button>
            <form>
        </div>

        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
@endsection
