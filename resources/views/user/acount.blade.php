@extends('homepage')

@section('content')
    <div class="content">
        <h5>ویرایش اطلاعات</h5>
        @if(count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
                </ul>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        {!! Form::open(['action' => 'UserController@acount', 'method' => 'POST','autocomplete' => 'off']) !!}            
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-append">
                      <span class="input-group-text"> رمز عبور قبلی<span>
                    </div>
                    {!! Form::password('oldpassword', ['class' => 'form-control', 'autocomplete' => 'new-password']); !!}
                </div>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-append">
                      <span class="input-group-text">رمز عبور جدید<span>
                    </div>
                    {!! Form::password('password', ['class' => 'form-control', 'autocomplete' => 'new-password']); !!}
                </div>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-append">
                      <span class="input-group-text">تکرار رمز عبور<span>
                    </div>
                    {!! Form::password('password_confirmation', ['class' => 'form-control', 'autocomplete' => 'new-password']); !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::submit('تغییر رمز عبور', ['class' => 'btn btn-primary']); !!}
            </div>
        {!! Form::close() !!}
    </div>
@endsection
