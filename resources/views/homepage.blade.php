<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('bootstrap/dist/css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/print.css') }}">
    <link rel="stylesheet" href="{{ asset('dynatable/dynatable.css') }}">
    <link rel="stylesheet" href="{{ asset('datepicker/persianDatepicker-default.css') }}">
    <link rel="stylesheet" href="{{ asset('select2/dist/css/select2.min.css') }}">
    <script src="{{ asset('jquery/dist/jquery.js') }}"></script>
    <script src="{{ asset('bootstrap/dist/js/bootstrap.js') }}"></script>
    <script src="{{ asset('dynatable/dynatable.js') }}"></script>
    <script src="{{ asset('select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('table2excel/jquery.table2excel.js') }}"></script>
    <script src="{{ asset('highcharts/highcharts.js') }}"></script>
    <style>
        .highcharts-figure, .highcharts-data-table table {
            min-width: 360px; 
            max-width: 800px;
            margin: 1em auto;
        }

        .highcharts-data-table table {
            font-family: Verdana, sans-serif;
            border-collapse: collapse;
            border: 1px solid #EBEBEB;
            margin: 10px auto;
            text-align: center;
            width: 100%;
            max-width: 500px;
        }
        .highcharts-data-table caption {
            padding: 1em 0;
            font-size: 1.2em;
            color: #555;
        }
        .highcharts-data-table th {
            font-weight: 600;
            padding: 0.5em;
        }
        .highcharts-data-table td, .highcharts-data-table th, .highcharts-data-table caption {
            padding: 0.5em;
        }
        .highcharts-data-table thead tr, .highcharts-data-table tr:nth-child(even) {
            background: #f8f8f8;
        }
        .highcharts-data-table tr:hover {
            background: #f1f7ff;
        }

        .highcharts-legend-item text tspan {
            font-size: 16px;
            font-weight: normal;
            font-family: "Shabnam FD", "Samim", "B Yekan";
        }
        .highcharts-credits {
            display: none;
        }
        .highcharts-label text tspan {
            font-weight: normal;
            font-family: "Shabnam FD", "Samim", "B Yekan";
        }
        .highcharts-root {
            font-weight: normal !important;
            font-family: "Shabnam FD", "Samim", "B Yekan" !important;
            font-size: 18px !important;
        }
        .highcharts-title {
            font-family: "Shabnam FD", "Samim", "B Yekan" !important;
        }
        .tooltip {
            width: 200px;
        }
    </style>
    <title>Document</title>
</head>
<body>
    @yield('contextmenu')
    <header>
        <h3 class="title"><a href="{{ url('/') }}">سیستم مدیریت حواله های باربری</a></h3>
        @if (Auth::check())
            <div class="user_info">
                <ul>
                    <li>
                        <h6><a href="{{ url('/acount') }}">{{ Auth::user()->name }}</a></h6>
                    </li>
                    @can('all', App\User::class)
                        <li>
                            <a href="{{ url('users') }}">
                                <img src="{{ asset('icons/users.svg') }}" alt="">
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('users/create') }}">
                                <img src="{{ asset('icons/adduser.svg') }}" alt="">
                            </a>
                        </li>
                    @endcan
                    <li>
                        <a href="{{ url('logout') }}">
                            <img src="{{ asset('icons/logout.svg') }}" alt="">
                        </a>
                    </li>
                </ul>
            </div>

            <!-- financial year select box -->
            <?php 
                $years = App\Year::orderBy('id', 'desc')->get();
                
                foreach($years as $year) {
                    $formatted_year[$year->id] = $year->name;
                }

                if (Auth::user()->year) {
                    $defult = Auth::user()->year->id;
                } else {
                    $defult = App\Year::where('defult', '1')->first()->id;
                }

            ?>
            <div class="financial_year">
                <h6>سال مالی</h6>

                {!! Form::open(['action' => 'YearController@changeUserYear', 'method' => 'POST']) !!}
                    {!! Form::select('year', $formatted_year, $defult, ['class' => 'form-control', 'style' => 'width:fit-content;margin:0 10px 0 10px', 'onChange' => 'this.form.submit()']); !!}
                {!! Form::close() !!}
            </div>
        @endif
    </header>
    <nav>

        @if (Auth::check())
        <ul>
            @can('create', App\Order::class)
                <li><a href="{{ url('orders/create') }}">حواله جدید</a></li>
            @endcan
            @can('viewAny', App\Order::class)
                <li><a href="{{ url('orders') }}">لیست حواله ها</a></li>
            @endif
            @can('viewAny', App\Order::class)
                <li><a href="{{ url('orders/generalreport') }}">گزارش کلی تفکیکی </a></li>
            @endif
            @can('create', App\Costumer::class)
                <li><a href="{{ url('costumers/create') }}"> مشتری جدید</a></li>
            @endcan
            @can('viewAny', App\Costumer::class)
                <li><a href="{{ url('costumers') }}">لیست مشتری ها</a></li>
            @endcan
            @can('create', App\Transportation::class)
                <li><a href="{{ url('transportations/create') }}">باربری جدید</a></li>
            @endcan
            @can('viewAny', App\Transportation::class)
                <li><a href="{{ url('transportations') }}">لیست باربری ها</a></li>
            @endcan
            @can('create', App\Owner::class)
                <li><a href="{{ url('owners/create') }}">مالک جدید</a></li>
            @endcan
            @can('viewAny', App\Owner::class)
                <li><a href="{{ url('owners') }}">لیست مالکین</a></li>
            @endcan
        </ul>
        @endif
    </nav>
    <article>
        @yield('title')
        @yield('content')
        <figure class="highcharts-figure">
            <div id="container"></div>
        </figure>
    </article>
    <footer></footer>

    @yield('scripts')

    <script>
        setTimeout(function(){
            $('.alert').remove();
        }, 5000);

        // Highcharts.chart('container', {
        //     chart: {
        //         type: 'line'
        //     },

        //     title: {
        //         text: 'باربری'
        //     },

        //     yAxis: {
        //         title: {
        //             text: 'وزن'
        //         }
        //     },

        //     xAxis: {
        //         categories: ['فرودین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان']
        //     },

        //     legend: {
        //         layout: 'vertical',
        //         align: 'right',
        //         verticalAlign: 'middle',
        //     },

        //     plotOptions: {
        //         line: {
        //             dataLabels: {
        //                 enabled: true
        //             },
        //             enableMouseTracking: false,
        //         }
        //     },

        //     series: [{
        //         name: 'سبزدشت',
        //         data: [95, 200, 30, 20, 175, 190, 100, 120]
        //     }, {
        //         name: 'بهران شفق',
        //         data: [85, 100, 200, 100, 25, 40, 170, 120]
        //     }],
        // });

        Highcharts.chart('container', {
    chart: {
        type: 'areaspline',
    },
    title: {
        text: 'Average fruit consumption during one week'
    },
    legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle',
            },

    xAxis: {
        categories: ['فرودین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', '07/24']
    },
    yAxis: {
        title: {
            text: 'Fruit units'
        }
    },
    credits: {
        enabled: false
    },
    tooltip: {
        // className: 'tooltip'
    },
    plotOptions: {
        areaspline: {
            fillOpacity: 0.5,
            dataLabels: {
                enabled: true
            },
        },
        enableMouseTracking: false,
    },
    series: [{
                name: 'سبزدشت',
                data: [95, 200, 30, 20, 175, 190, 100, 120]
            }, {
                name: 'بهران شفق',
                data: [75, 100, 200, 100, 25, 40, 170, 115]
            }],
});
    </script>
</body>
</html>