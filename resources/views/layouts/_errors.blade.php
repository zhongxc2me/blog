{{--错误提示--}}
@if(count($errors)>0)
    <div class="alert alert-warning" role="alert">
        @foreach($errors->all() as $error)
            <li><strong>{{$error}}</strong></li>
        @endforeach
    </div>
@endif
