@extends('layout.masterAdmin')
@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Khách hàng
                    <small>Sửa</small>
                </h1>
            </div>
            @if (Session::has("thongbao"))
                <div class="alert alert-success">{{Session::get('thongbao')}}</div>
            @endif
            <div class="col-lg-7" style="padding-bottom:120px">
                <form action="{{route('editkhachhang')}}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>ID Khách hàng</label>
                        <input class="form-control" name="id" value="{{$customer->id}}" readonly/>
                    </div>
                    <div class="form-group">
                        <label>Tên khách hàng</label>
                        <input class="form-control" name="cusname" value="{{$customer->name}}" readonly/>
                    </div>
                    <div class="form-group">
                        <label>Giới tính</label>
                        <input class="form-control" name="gender" value="{{$customer->gender}}" readonly/>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input class="form-control" name="email" value="{{$customer->email}}" readonly/>
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <input class="form-control" name="address" value="{{$customer->address}}" />
                        @if ($errors->has('address'))
                        <span class="text-danger">{{$errors->first('address')}}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Số điện thoại</label>
                        <input class="form-control" name="phone" value="{{$customer->phone_number}}" />
                        @if ($errors->has('phone'))
                        <span class="text-danger">{{$errors->first('phone')}}</span>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-default">Lưu thay đổi</button>
                    <button type="reset" class="btn btn-default">Reset</button>
                <form>
            </div>
        </div>

    </div>

</div>

@endsection
