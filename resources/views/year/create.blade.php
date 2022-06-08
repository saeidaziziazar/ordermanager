@extends('homepage')

@section('content')
    <script src="{{ asset('datepicker/persianDatepicker.min.js') }}"></script>
    <div class="content">
        <h5>سال مالی جدید</h5>
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

        {!! Form::open(['action' => 'YearController@store', 'method' => 'POST', 'autocomplete' => 'off']) !!}
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
                      <span class="input-group-text">تاریخ شروع<span>
                    </div>
                    {!! Form::text('startdate', '', ['class' => 'form-control', 'id' => 'date']); !!}
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-append">
                      <span class="input-group-text">تاریخ پایان<span>
                    </div>
                    {!! Form::text('enddate', '', ['class' => 'form-control', 'id' => 'date']); !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::submit('ایجاد سال مالی', ['class' => 'btn btn-primary']); !!}
            </div>
        {!! Form::close() !!}
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $('[id*="date"]').persianDatepicker({
            cellWidth: 35,
            cellHeight: 35,
            fontSize: 14,
            formatDate: "YYYY/0M/0D",
            selectedBefore: !0,
            calendarPosition: {
                x: 380,
                y: 0,
            },
        });
    </script>
@endsection