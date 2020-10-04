@extends('homepage')

@section('content')
    <div class="content">
        <h5>معرفی کاربر</h5>
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

        {!! Form::open(['action' => 'UserController@store', 'method' => 'POST', 'autocomplete' => 'off']) !!}
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-append">
                      <span class="input-group-text">نام<span>
                    </div>
                    {!! Form::text('name', '', ['class' => 'form-control']); !!}
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-append">
                      <span class="input-group-text">نام کاربری<span>
                    </div>
                    {!! Form::text('username', '', ['class' => 'form-control','autocomplete' => 'off', 'id' => 'username',]); !!}
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-append">
                      <span class="input-group-text">رمز عبور<span>
                    </div>
                    {!! Form::password('password', ['class' => 'form-control','autocomplete' => 'new-password', 'id' => 'password']); !!}
                </div>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-append">
                      <span class="input-group-text">تکرار رمز عبور<span>
                    </div>
                    {!! Form::password('password_confirmation', ['class' => 'form-control']); !!}
                </div>
            </div>

            

            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-append">
                      <span class="input-group-text">دسترسی ها<span>
                    </div>
                    <select name="permissions[]" class="custom-select" multiple size="8">
                        @foreach($permissions as $permission)
                            <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-append">
                      <span class="input-group-text">متعلق به<span>
                    </div>
                    {!! Form::select('transport', $tarnsportations, null , ['class' => 'custom-select']); !!}
                </div>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-append">
                      <span class="input-group-text">وضعیت<span>
                    </div>
                    {!! Form::select('status', ['0' => 'فعال', '1' => 'غیرقعال'], null , ['class' => 'custom-select']); !!}
                </div>
            </div>
            
            <div class="form-group">
                {!! Form::submit('ایجاد کاربر', ['class' => 'btn btn-primary']); !!}
            </div>
        {!! Form::close() !!}
    </div>
@endsection