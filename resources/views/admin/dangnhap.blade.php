@extends('layout.masterAdmin')
@section('content')
<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Vui Lòng Đăng Nhập</h3>
                        @if (Session::has('matb'))
                            @if (Session::get('matb'=='0'))
                                <div class="alert alert-danger">{{Session::get('noidung')}}</div>
                            @endif
                        @endif
                    </div>
                    <div class="panel-body">
                        <form role="form" action="{{route('dangnhap')}}" method="POST">
                            @csrf
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="E-mail" name="email" type="email" autofocus>
                                    @if ($errors->has('email'))
                                        <label style="color:red">{{$errors->first('email')}}</label>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password" value="">
                                    @if ($errors->has('email'))
                                        <label style="color:red">{{$errors->first('password')}}</label>
                                    @endif
                                </div>
                                <button type="submit" class="btn btn-lg btn-success btn-block">Login</button>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection
