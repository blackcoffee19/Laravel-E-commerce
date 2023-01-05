@extends('layout.masterAdmin')
@section('content')
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Chi tiết đơn hàng
                        <small>Giỏ hàng</small>
                    </h1>
                </div>
                <!-- /.col-lg-12 -->
                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr align="center">
                            <th>ID Đơn hàng</th>
                            <th>ID Sản phẩm</th>
                            <th>Sản phẩm</th>
                            <th>Số lượng</th>
                            <th>Đơn giá</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bill_detail as $bill)
                        <tr class="odd gradeX" align="center">
                            <td>{{$bill->id_bill}}</td>
                            <td>{{$bill->id_product}}</td>
                            <td>{{$bill->product->name}}</td>
                            <td>{{$bill->quantity}}</td>
                            <td>{{$bill->unit_price}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <td colspan="4">Tổng tiền</td>
                        <td>{{$bill_t->total}}</td>
                    </tfoot>
                </table>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->

@endsection
