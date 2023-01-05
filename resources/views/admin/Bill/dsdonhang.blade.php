@extends('layout.masterAdmin')
@section('content')
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Đơn hàng
                        <small>Danh sách</small>
                    </h1>
                </div>
                <!-- /.col-lg-12 -->
                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr align="center">
                            <th>ID</th>
                            <th>ID Khách hàng</th>
                            <th>Tên Khách hàng</th>
                            <th>Ngày order</th>
                            <th>Tổng tiền</th>
                            <th>Hình thức TT</th>
                            <th>Ghi chú</th>
                            <th>Trạng thái</th>
                            <th>Edit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bills as $bill)
                        <tr class="odd gradeX" align="center">
                            <td><a href="{{route('chitietdonhang',$bill->id)}}">{{$bill->id}}</a></td>
                            <td>{{$bill->id_customer}}</td>
                            <td>{{$bill->customer->name}}</td>
                            <td>{{$bill->date_order}}</td>
                            <td>{{$bill->total}}</td>
                            <td>{{$bill->payment}}</td>
                            <td>{{$bill->note}}</td>
                            <td>{{$bill->status == 0? "Chưa giao hàng" : "Đã giao hàng"}}</td>
                            <td class="center"><i class="fa fa-pencil fa-fw"></i> <a href="{{route('editdh',$bill->id)}}">Edit</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->

@endsection
