@extends('homepage')

@section('content')
    <div class="content">
        <h5>معرفی مالک</h5>
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

        {!! Form::open(['action' => 'OwnerController@store', 'method' => 'POST', 'autocomplete' => 'off']) !!}
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
                      <span class="input-group-text">شناسه ملی<span>
                    </div>
                    {!! Form::text('nationalcode', '', ['class' => 'form-control']); !!}
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-append">
                      <span class="input-group-text">کد پستی<span>
                    </div>
                    {!! Form::text('zipcode', '', ['class' => 'form-control']); !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::submit('ایجاد مالک', ['class' => 'btn btn-primary']); !!}
            </div>
        {!! Form::close() !!}
    </div>
@endsection