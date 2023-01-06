@extends('layout.masterAdmin')
@section('content')
<div id="page-wrapper">
    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Sản phẩm
                    <small>Danh sách</small>
                </h1>
            </div>
        </div>
        @if (Session::has('thongbao'))
        <div class="row">
            <div class="alert alert-warning">{{Session::get('thongbao')}}</div>
        </div>
        @endif
            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                <thead>
                    <tr align="center">
                        <th>ID</th>
                        <th>Tên sản phẩm</th>
                        <th>Loại sản phẩm</th>
                        <th>Giá gốc</th>
                        <th>Giá khuyến mãi</th>
                        <th>ĐVT</th>
                        <th>Trạng thái</th>
                        <th>Hình</th>
                        <th>Mô tả</th>
                        <th>Delete</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $pro)
                    <tr class="odd gradeX" align="center">
                        <td>{{$pro->id}}</td>
                        <td>{{$pro->name}}</td>
                        <td>{{$pro->productType->name}}</td>
                        <td>{{$pro->unit_price}}</td>
                        <td>{{$pro->promotion_price}}</td>
                        <td>{{$pro->unit}}</td>
                        <td>{{$pro->new == 1? "Sản phẩm mới": ""}}</td>
                        <td><img src="resources/frontend/image/product/{{$pro->image}}" width="150" alt="{{$pro->name}}"></td>
                        <td style="max-width: 150px;">{{$pro->description}}</td>
                        <td class="center"><i class="fa fa-trash-o  fa-fw"></i><a href="{{route('xoasanpham',$pro->id)}}"> Delete</a></td>
                        <td class="center"><i class="fa fa-pencil fa-fw"></i> <a href="{{route('editsanpham',$pro->id)}}">Edit</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{$products->links()}}
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>

@endsection
