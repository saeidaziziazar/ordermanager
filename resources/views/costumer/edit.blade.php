@extends('homepage')

@section('content')
    <div class="content">
        <h5>ویرایش مشتری</h5>
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

        {!! Form::open(['action' => ['CostumerController@update', $costumer->id], 'method' => 'POST', 'autocomplete' => 'off']) !!}
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-append">
                      <span class="input-group-text">نام</span>
                    </div>
                    {!! Form::text('firstname', $costumer->first_name, ['class' => 'form-control']); !!}
                </div>
            </div>
            
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-append">
                      <span class="input-group-text">نام خانوادگی</span>
                    </div>
                    {!! Form::text('lastname', $costumer->last_name, ['class' => 'form-control']); !!}
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-append">
                      <span class="input-group-text">کد یا شناسه ملی</span>
                    </div>
                    {!! Form::text('nationalcode', $costumer->national_code, ['class' => 'form-control']); !!}
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-append">
                      <span class="input-group-text">شماره همراه<span>
                    </div>
                    {!! Form::text('cellphonenum', $costumer->cell_phone_num, ['class' => 'form-control']); !!}
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-append">
                      <span class="input-group-text">شماره تلفن<span>
                    </div>
                    {!! Form::text('phonenum', $costumer->phone_num, ['class' => 'form-control']); !!}
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-append">
                      <span class="input-group-text">کد پستی<span>
                    </div>
                    {!! Form::text('zipcode', $costumer->zip_code, ['class' => 'form-control']); !!}
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-append">
                      <span class="input-group-text">آدرس<span>
                    </div>
                    {!! Form::text('address', $costumer->address, ['class' => 'form-control']); !!}
                </div>
            </div>
                {!! Form::hidden('_method', 'PUT') !!}
                {!! Form::submit('ذخیره', ['class' => 'btn btn-primary']); !!}
            </div>
        {!! Form::close() !!}
    </div>
@endsection