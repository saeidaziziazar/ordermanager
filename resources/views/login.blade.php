@extends('homepage')

@section('content')
    <div class="content">
        <h3>ورود به سیستم</h3>
        @if(count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
                </ul>
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        {!! Form::open(['action' => 'LoginController@login', 'method' => 'POST', 'autocomplete' => 'off', 'id' => 'login']) !!}
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-append">
                      <span class="input-group-text">نام کاربری<span>
                    </div>
                    {!! Form::text('username', '', ['class' => 'form-control']); !!}
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-append">
                      <span class="input-group-text">رمز عبور<span>
                    </div>
                    {!! Form::password('password', ['class' => 'form-control']); !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::submit('ورود', ['class' => 'btn btn-primary']); !!}
            </div>
        {!! Form::close() !!}
    </div>
@endsection