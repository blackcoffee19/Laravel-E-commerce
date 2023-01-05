@extends('layout.masterAdmin')
@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Đơn hàng
                    <small>Sửa</small>
                </h1>
            </div>
            @if (Session::has("thongbao"))
                <div class="alert alert-warning">{{Session::get('thongbao')}}</div>
            @endif
            <!-- /.col-lg-12 -->
            <div class="col-lg-7" style="padding-bottom:120px">
                <form action="{{route('editdh',$bill->id)}}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>ID Đơn hàng</label>
                        <input class="form-control" name="id" value="{{$bill->id}}" readonly/>
                    </div>
                    <div class="form-group">
                        <label>ID Khách hàng</label>
                        <input class="form-control" name="id_customer" value="{{$bill->id_customer}}" readonly/>
                    </div>
                    <div class="form-group">
                        <label>Tên khách hàng</label>
                        <input class="form-control" name="customer_name" value="{{$bill->customer->name}}" readonly/>
                    </div>
                    <div class="form-group">
                        <label>Ngày order</label>
                        <input class="form-control" name="oder_date" value="{{$bill->date_order}}" readonly/>
                    </div>
                    <div class="form-group">
                        <label>Tổng tiền</label>
                        <input class="form-control" name="total" value="{{$bill->total}}" readonly/>
                    </div>
                    <div class="form-group">
                        <label>Hình thức thanh toán</label>
                        <input class="form-control" name="payment" value="{{$bill->payment}}" readonly/>
                    </div>
                    <div class="form-group">
                        <label>Ghi chú</label>
                        <textarea class="form-control" rows="3" readonly>{{$bill->note}}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="bill_status">Trạng thái đơn hàng</label>
                        <label class="radio-inline">
                            <input type="radio" name="bill_status" value="0" {{$bill->status == 0? "checked":""}}>Chưa giao hàng
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="bill_status" value="1" {{$bill->status == 1? "checked":""}}>Đã Giao hàng
                        </label>
                    </div>
                    <button type="submit" class="btn btn-default">Lưu thay đổi</button>
                    <button type="reset" class="btn btn-default">Reset</button>
                <form>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>

@endsection
