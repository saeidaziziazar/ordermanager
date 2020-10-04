@extends('homepage')

@section('content')
    <div class="content">
        <h5>ویرایش مالک</h5>
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

        {!! Form::open(['action' => ['OwnerController@update', $owner->id], 'method' => 'POST', 'autocomplete' => 'off']) !!}
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-append">
                      <span class="input-group-text">نام<span>
                    </div>
                    {!! Form::text('name', $owner->name, ['class' => 'form-control']); !!}
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-append">
                      <span class="input-group-text">شناسه ملی<span>
                    </div>
                    {!! Form::text('nationalcode', $owner->national_id, ['class' => 'form-control']); !!}
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-append">
                      <span class="input-group-text">کد پستی<span>
                    </div>
                    {!! Form::text('zipcode', $owner->zip_code, ['class' => 'form-control']); !!}
                </div>
            </div>
            {!! Form::hidden('_method', 'PUT') !!}
            <div class="form-group">
                {!! Form::submit('ذخیره', ['class' => 'btn btn-primary']); !!}
            </div>
        {!! Form::close() !!}
    </div>
@endsection