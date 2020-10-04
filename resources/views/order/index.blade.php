@extends('homepage')

@section('contextmenu')
    <div class="menu">
        <ul class="menu-options">
            @can('view', \App\Order::class)
                <li class="menu-option" id="view">نمایش حواله</li>
            @endcan
            @can('update', \App\Order::class)
                <li class="menu-option" id="edit">ویرایش</li>
            @endcan
            @can('delete', \App\Order::class)
                <li class="menu-option" id="delete">حذف</li>
            @endcan
            @can('create', \App\Order::class)
                <li class="menu-option" id="certain">نمایش برای باربری</li>
                <li class="menu-option" id="temporary">عدم نمایش برای باربری</li>
            @endcan
            <li class="menu-option" id="print">چاپ</li>
            <li class="menu-option" id="confirm">تایید</li>
            <li class="menu-option" id="unconfirm">بازگشت از تایید</li>
        </ul>
    </div>
@endsection

@section('content')
    <div class="content" style="padding-bottom:40px">
        <h5>لیست حواله ها</h5>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('fail'))
            <div class="alert alert-danger">{{ session('fail') }}</div>
        @endif


        <ul class="actions">
            @can('view', \App\Order::class)
                <li><a href="#" onclick="printOrders()">چاپ حواله ها</a></li>
                <li><a href="#" onclick="CheckForViewed()">تایید حواله ها</a></li>
                <li><a href="#" onclick="returnViewed()">برگشت از تایید حواله ها</a></li>
            @endcan
             @can('delete', \App\Order::class)
                <li><a href="#" onclick="deleteOrders(true)">حذف حواله ها</a></li>
            @endcan
        </ul>

        <div style="display:flex">
            <input type="text" id="search-name" name="name" class="form-control" style="display:none">
            <select id="search-status" name="status" class="form-control" style="width:fit-content;margin:0 10px 0 10px">
                <option></option>
                <option value="0">ثبت شده</option>
                <option value="1">تایید شده</option>
            </select>
        </div>
                {!! Form::open(['action' => 'OrderController@index', 'method' => 'POST', 'autocomplete' => 'off', 'style' => 'border:1px solid lightgrey;padding:10px;border-radius:5px;margin-top:10px;']) !!}
                <div class="row" style="margin:0">
                    <div class="col-3" style="padding:0 5px 0 5px">
                        {!! Form::text('start', null, ['class' => 'form-control', 'id' => 'start', 'placeholder' => 'از تاریخ']) !!}
                    </div>
                    <div class="col-3" style="padding:0 5px 0 5px">
                        {!! Form::text('end', null, ['class' => 'form-control', 'id' => 'end', 'placeholder' => 'تا تاریخ']) !!}
                    </div>
                    <div class="col-2" style="padding:0 5px 0 5px">
                        <select name="transporter" placeholder="باربری" class="custom-select"
                        @if(Auth::user()->transportation_id)
                            disabled
                        @endif
                        >
                            <option value=""></option>
                            @foreach($trans as $tran)
                                <option value="{{ $tran->id }}"
                                    @if(Auth::user()->transportation_id === $tran->id)
                                        selected
                                    @endif
                                >{{ $tran->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-4" style="padding:0 5px 0 5px">
                        {!! Form::select('owner', $owners, null , ['class' => 'custom-select']); !!}
                    </div>
                    @if(Auth::user()->transportation_id)
                        <input type="hidden" name="transporter" value="{{ Auth::user()->transportation_id }}">
                    @endif
                </div>
                <div class="row" style="margin:0;padding:5px">
                    {!! Form::submit('اعمال فیلترها', ['class' => 'btn btn-primary']) !!}
                    <a href="{{ url('orders') }}" class="btn btn-danger" style="margin-right:5px">لغو فیلترها</a>
                    <a href="#" class="btn btn-success" style="margin-right:5px" onclick="tableToExcel()">خروجی اکسل</a>
                </div>
            {!! Form::close() !!}
        {!! Form::open(['method' => 'POST', 'id' => 'printForm']) !!}

        <table id="ordertable" class="table table-sm table-bordered" style="margin-top:30px;text-align:center;font-size:85%;">
            <thead class="thead-light">
                <tr>
                    <th class="noExl" style="display:none"></th>
                    <th class="noExl">
                        <input type="checkbox" id="checkAll" onclick="checkAllCheckBox(event)">
                    </th>
                    <th scope="col">ش ح</th>
                    <th scope="col">مالک حواله</th>
                    <th scope="col">تاریخ</th>
                    <th scope="col">مشتری</th>
                    <th scope="col">مقدار</th>
                    <th scope="col">باربری</th>
                    <th scope="col">توضیحات</th>
                    <th style="display:none" class="noExl">status</th>
                    <th style="display:none" class="noExl">certain</th>
                </tr>
            </thead>
            @if(!is_null($orders))
                <tbody>
                
                    @foreach($orders as $order)
                        <tr>
                            <td>{{ $order->id  }}</td>
                            <td>
                                {!! Form::checkbox('orders[]', $order->id) !!}
                            </td>
                            <td>{{ $order->order_num  }}</td>
                            <td>{{ $order->owner->name }}</td>
                            <td>{{ $order->date }}</td>
                            <td>{{ $order->costumer->first_name . ' ' . $order->costumer->last_name }}</td>
                            <td>{{ number_format($order->amount) }}</td>
                            <td>{{ $order->transportation->name }}</td>
                            <td>
                                @if(!is_null($order->description))
                                    <img src="{{ asset('icons/message.svg') }}" alt="" data-toggle="tooltip" data-placement="bottom" title="{{ $order->description }}">
                                @endif
                            </td>
                            <td>{{ $order->is_viewed }}</td>
                            <td>{{ $order->is_certain }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                @else
                    
                @endif
        </table>
    </div>
@endsection

@section('scripts')
    <script>
        $('#ordertable').dynatable({
            dataset: {
                perPageDefault: 100,
                perPageOptions: [10,25,50,100,500,1000],
            },
            inputs: {
                searchTarget: '#search-status',
                queries: $('#search-name, #search-status'),
                perPageTarget: '#search-status',
                perPagePlacement: 'after',
                perPageText: 'تعداد : ',
            },
        }).bind('dynatable:afterUpdate', changeTrBgColor);

        changeTrBgColor();

        function changeTrBgColor() {
            var trs = document.querySelectorAll('tr.table-row');
            trs.forEach((tr, index) => {
                if (tr.children[10].innerHTML === '0') {
                    tr.classList.add('alert-warning');
                }
                if (tr.children[9].innerHTML === '1') {
                    tr.classList.add('alert-success');
                }
                tr.children[0].classList.add('noExl');
                tr.children[1].classList.add('noExl');
                tr.children[9].classList.add('noExl');
                tr.children[10].classList.add('noExl');
            })
        }

        function tableToExcel() {
            $("#ordertable").table2excel({
                exclude:".noExl",
                name:"order",
                filename:"export",
                fileext:".xls",
                preserveColors:true,
            });
        }

        var menu = document.querySelector('.menu');

        function checkAllCheckBox(event) {
            if (event.target.checked) {
                document.querySelectorAll("input[type='checkbox']").forEach( item => {
                    item.checked = true;
                })
            } else {
                document.querySelectorAll("input[type='checkbox']").forEach( item => {
                    item.checked = false;
                })
            }
        }

        function certain() {
            var form = document.getElementById("printForm");

            form.action = form.action + '/certain';

            form.submit();
        }

        function temporary() {
            var form = document.getElementById("printForm");

            form.action = form.action + '/temporary';

            form.submit();
        }

        function CheckForViewed() {
            var form = document.getElementById("printForm");

            form.action = form.action + '/viewed';

            form.submit();
        }

        function returnViewed() {
            var form = document.getElementById("printForm");

            form.action = form.action + '/returnviewed';

            form.submit();
        }

        function printOrders() {
            var form = document.getElementById("printForm");

            form.action = form.action + '/report';

            form.submit();
        }

        function deleteOrders(multiple = false) {
            var form = document.getElementById("printForm");
            if (multiple) {
                var respond = confirm('آیا از حذف حواله های انتخاب شده مطمئن هستید ؟');
            }

            if (respond || multiple == false) {
                var input = document.createElement("INPUT");
                input.setAttribute('name', '_method');
                input.setAttribute('type', 'hidden');
                input.setAttribute('value', 'DELETE');
                form.appendChild(input);

                form.submit();
            } else {
                // do nothing
            }
        }

        function contextMenu(event) {
            event.preventDefault();

            document.querySelectorAll("input[type='checkbox']").forEach( item => {
                item.checked = false;
            })

            var item = event.path[1];

            menu.style.display = 'block';
            menu.style.left = event.pageX - 150 + 'px';
            menu.style.top = event.pageY + 'px';

            if (document.getElementById('view')) {
                document.getElementById('view').onclick = (event) => {
                    window.location.href = 'orders/' + item.firstChild.innerHTML;
                }
            }

            if (document.getElementById('edit')) {
                document.getElementById('edit').onclick = (event) => {
                    window.location.href = 'orders/' + item.firstChild.innerHTML + '/edit';
                }
            }

            if (document.getElementById('delete')) {
                document.getElementById('delete').onclick = (event) => {
                    var name = item.children[2].innerHTML;
                    var respond = confirm(('آیا از حذف کردن '.concat(name)).concat(' مطمئن هستید ؟ '));

                    if (respond) {
                        item.children[1].children[0].checked = true;
                        deleteOrders(false);
                    } else {

                    }
                }   
            }

            if (document.getElementById('certain')) {
                document.getElementById('certain').onclick = (event) => {
                    item.children[1].children[0].checked = true;

                    certain();
                }
            }

            if (document.getElementById('temporary')) {
                document.getElementById('temporary').onclick = (event) => {
                    item.children[1].children[0].checked = true;

                    temporary();
                }
            }

            if (document.getElementById('print')) {
                document.getElementById('print').onclick = (event) => {
                    item.children[1].children[0].checked = true;

                    printOrders();
                }
            }

            if (document.getElementById('confirm')) {
                document.getElementById('confirm').onclick = (event) => {
                    item.children[1].children[0].checked = true;

                    CheckForViewed();
                }
            }

            if (document.getElementById('unconfirm')) {
                document.getElementById('unconfirm').onclick = (event) => {
                    item.children[1].children[0].checked = true;
                    returnViewed();
                }
            }
        }

        menu.onmousedown = (event) => {
            event.stopPropagation();
        };

        window.onblur = () => {
            menu.style.display = 'none';
        };

        document.onmousedown = () => {
            menu.style.display = 'none';
        };

        document.onmousewheel = () => {
            menu.style.display = 'none';
        };

        document.onkeydown = (event) => {
            if (event.keyCode === 27) {
                menu.style.display = 'none';
            }
        }

    </script>
    <script src="{{ asset('datepicker/persianDatepicker.min.js') }}"></script>
    <script type="text/javascript">
        $("#start, #end").persianDatepicker({
            cellWidth: 30,
            cellHeight: 30,
            fontSize: 14,
            formatDate: "YYYY/0M/0D",
            calendarPosition: {
                x: 0,
                y: 0,
            },
        });
    </script>
@endsection