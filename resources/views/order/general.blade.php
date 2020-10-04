@extends('homepage')

@section('content')
    <script src="{{ asset('datepicker/persianDatepicker.min.js') }}"></script>
    <div class="content">
        <h5 class="no-print">گزارش تفکیکی</h5>
        {!! Form::open(['action' => 'OrderController@generalReport', 'method' => 'POST', 'autocomplete' => 'off', 'style' => 'border:1px solid lightgrey;padding:10px;border-radius:5px;margin:20px 0 20px 0']) !!}
            <div class="row" style="margin:0">
                <div class="col-2" style="padding:0 5px 0 5px">
                    {!! Form::text('start', null, ['class' => 'form-control', 'id' => 'start', 'placeholder' => 'از تاریخ', 'style' => 'height:29px;border:1px solid #aaa;font-size:90%']) !!}
                </div>
                <div class="col-2" style="padding:0 5px 0 5px">
                    {!! Form::text('end', null, ['class' => 'form-control', 'id' => 'end', 'placeholder' => 'تا تاریخ', 'style' => 'height:29px;border:1px solid #aaa;font-size:90%']) !!}
                </div>
                <div class="col-5" style="padding:0 5px 0 5px">
                    {!! Form::select('costumer', $costumers, null , ['class' => ' form-control', 'id' => 'costumer']); !!}
                </div>
                @if(!Auth::user()->transportation_id)
                    <div class="col-3">
                        {!! Form::checkbox('temporary', 'checked', ['id' => 'temporary']) !!}
                        {!! Form::label('temporary', 'حواله های موقت',['style' => 'font-size:90%']) !!}
                    </div>
                @endif
            </div>
            <div class="row" style="margin:0;padding:5px">
                @if(Auth::user()->transportation_id)
                    {!! Form::hidden('transportation', Auth::user()->transportation_id) !!}
                @endif
                {!! Form::submit('گزارش گیری', ['class' => 'btn btn-success']) !!}
                <button style="margin-right:10px" class="btn btn-primary" onclick="window.print(); return false">چاپ</button>
            </div>
        {!! Form::close() !!}

        <div id="printarea">
            <h5 style="margin:15px 0 15px 0">گزارش کلی حواله ها به تفکیک باربری و مالک از تاریخ {{ $start }} تا {{ $end }}</h5>
            <h5 style="margin:15px 0 25px 0">{{ $costumer }}</h5>
            <table class="table table-bordered table-sm">
                <thead class="thead-light">
                    <tr>
                        <th>باربری</th>
                        <th width="45%">مالک حواله</th>
                        <th>تعداد</th>
                        <th width="18%">مقدار</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($data as $tra => $row)
                    <tr>
                        <td rowspan="{{ $rowspan }}">{{ $tra }}</td>
                        @foreach($row as $owner => $attr)
                        <tr>
                            <td>{{ $owner }}</td>
                            <td>{{ $attr[0] }}</td>
                            <td>{{ number_format($attr[1]) }}</td>
                        </tr>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        

        $(document).ready(function() {
            $('#costumer').select2({
                dir: "rtl",
            });

            $("#start, #end").persianDatepicker({
                cellWidth: 35,
                cellHeight: 35,
                fontSize: 14,
                formatDate: "YYYY/0M/0D",
                // selectedBefore: !0,
                calendarPosition: {
                    x: 0,
                    y: 0,
                },
            });
        });
    </script>
@endsection
