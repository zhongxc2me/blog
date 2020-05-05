@extends('layouts.default')
@section('content')
    <form action="{{route('FindPasswordUpdate')}}" method="post">
        @csrf
        <input type="hidden" name="token" value="{{$user['email_token']}}">
        <div class="card">
            <div class="card-header">
                重置密码
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="">邮箱</label>
                    <input type="email" disabled class="form-control" name="email" value="{{$user['email']}}">
                    <small id="emailHelpId" class="form-text text-muted">请输入注册时填写的邮箱</small>
                </div>
                <div class="form-group">
                    <label for="">密码</label>
                    <input type="password" name="password" class="form-control">
                    <small id="helpId" class="text-muted">Help text</small>
                </div>
                <div class="form-group">
                    <label for="">确认密码</label>
                    <input type="password" name="password_confirmation" class="form-control">
                    <small id="helpId" class="text-muted">Help text</small>
                </div>
            </div>
            <div class="card-footer text-muted">
                <button type="submit" class="btn btn-success">重置密码</button>
            </div>
        </div>
    </form>
@endsection
