@extends('layout.masterAdmin')
@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Người dùng
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
            <div class="col-lg-7" style="padding-bottom:120px">
                <form action="{{route('themuser')}}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Họ và Tên</label>
                        <input class="form-control" name="fullname" placeholder="Nhập tên họ tên người dùng" />
                        @if ($errors->has('fullname'))
                            <span class="text-danger">{{$errors->first('fullname')}}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input class="form-control" name="email" placeholder="Nhập email người dùng" />
                        @if ($errors->has('email'))
                            <span class="text-danger">{{$errors->first('email')}}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input class="form-control" type="password" name="pass1" placeholder="Nhập password" />
                        @if ($errors->has('pass1'))
                        <span class="text-danger">{{$errors->first('pass1')}}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Nhập lại Password</label>
                        <input class="form-control" type="password" name="pass2" placeholder="Nhập lại password" />
                        @if ($errors->has('pass2'))
                        <span class="text-danger">{{$errors->first('pass2')}}</span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label>Số điện thoại</label>
                        <input class="form-control" name="phone" placeholder="Nhập số điện thoại người dùng" />
                        @if ($errors->has('phone'))
                        <span class="text-danger">{{$errors->first('phone')}}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Địa chỉ</label>
                        <input class="form-control" name="address" placeholder="Nhập Địa chỉ người dùng" />
                        @if ($errors->has('address'))
                        <span class="text-danger">{{$errors->first('address')}}</span>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-default">Thêm Người dùng</button>
                    <button type="reset" class="btn btn-default">Reset</button>
                <form>
            </div>
    </div>
</div>
@endsection
