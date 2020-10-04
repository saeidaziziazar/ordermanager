@extends('homepage')

@section('content')
    <div class="content">
        <h5>ویرایش کاربر</h5>
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

        {!! Form::open(['action' => ['UserController@update', $user->id], 'method' => 'POST','autocomplete' => 'off']) !!}
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-append">
                      <span class="input-group-text">نام<span>
                    </div>
                    {!! Form::text('name', $user->name, ['class' => 'form-control']); !!}
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-append">
                      <span class="input-group-text">نام کاربری<span>
                    </div>
                    {!! Form::text('username', $user->username, ['class' => 'form-control', 'autocomplete' => 'off']); !!}
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-append">
                      <span class="input-group-text">رمز عبور<span>
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
                <div class="input-group">
                    <div class="input-group-append">
                      <span class="input-group-text">دسترسی ها<span>
                    </div>
                    <select name="permissions[]" class="custom-select" multiple size="8">
                        @foreach($permissions as $permission)
                            <option value="{{ $permission->id }}"
                                @if (in_array($permission->id, $user_permissions))
                                    selected
                                @endif
                            >{{ $permission->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-append">
                      <span class="input-group-text">باربری<span>
                    </div>
                    {!! Form::select('transport', $transportations, $user->transportation_id , ['class' => 'custom-select']); !!}
                </div>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-append">
                      <span class="input-group-text">وضعیت<span>
                    </div>
                    {!! Form::select('status', ['0' => 'غیر فعال', '1' => 'فعال'], $user->is_active, ['class' => 'custom-select']); !!}
                </div>
            </div>

            {!! Form::hidden('_method', 'PUT') !!}
            <div class="form-group">
                {!! Form::submit('ویرایش کاربر', ['class' => 'btn btn-primary']); !!}
            </div>
        {!! Form::close() !!}
    </div>
@endsection
