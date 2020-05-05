@extends('layouts.default')
@section('content')
    <form action="{{route('FindPasswordSend')}}" method="post">
        @csrf
        <div class="card">
            <div class="card-header">
                找回密码
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="">邮箱</label>
                    <input type="email" class="form-control" name="email">
                    <small id="emailHelpId" class="form-text text-muted">请输入注册时填写的邮箱</small>
                </div>
            </div>
            <div class="card-footer text-muted">
                <button type="submit" class="btn btn-success">发送</button>
            </div>
        </div>
    </form>
@endsection
