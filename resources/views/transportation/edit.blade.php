@extends('homepage')

@section('content')
    <div class="content">
        <h5>ویرایش باربری</h5>
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

        {!! Form::open(['action' => ['TransportationController@update', $trans->id], 'method' => 'POST', 'autocomplete' => 'off']) !!}
            <div class="form-group">    
                <div class="input-group">
                    <div class="input-group-append">
                      <span class="input-group-text">نام باربری<span>
                    </div>
                    {!! Form::text('name', $trans->name , ['class' => 'form-control']); !!}
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-append">
                      <span class="input-group-text">مدیر باربری<span>
                    </div>
                    {!! Form::text('manager', $trans->manager, ['class' => 'form-control']); !!}
                </div>
            </div>
            {!! Form::hidden('_method', 'PUT') !!}
            <div class="form-group">
                {!! Form::submit('ذخیره', ['class' => 'btn btn-primary']); !!}
            </div>
        {!! Form::close() !!}
    </div>
@endsection