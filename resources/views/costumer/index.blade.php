@extends('homepage')

@section('contextmenu')
    <div class="menu">
        <ul class="menu-options">
            @can('view', $costumers[0])
                <li class="menu-option" id="order">ایجاد حواله</li>
            @endcan
            @can('update', $costumers[0])
                <li class="menu-option" id="edit">ویرایش</li>
            @endcan
            @can('delete', $costumers[0])
                <li class="menu-option" id="delete">حذف</li>
            @endcan
        </ul>
    </div>
@endsection

@section('content')
    <div class="content">
        <h5>لیست مشتری ها</h5>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('fail'))
            <div class="alert alert-danger">{{ session('fail') }}</div>
        @endif

        {!! Form::open(['method' => 'POST', 'id' => 'printForm']) !!}

        <table id="table" class="table table-sm table-bordered" style="margin-top:30px;text-align:center;font-size:85%">
            <thead class="thead-light">
                <tr>
                    <th style="display:none"></th>
                    <th>
                        <input type="checkbox" id="checkAll" onclick="checkAllCheckBox(event)">
                    </th>
                    <th scope="col">نام مشتری</th>
                    <th scope="col">توضیحات</th>
                    <th scope="col">کد ملی</th>
                    <th scope="col">شماره تماس</th>
                    <!-- <th scope="col">کدپستی</th>
                    <th scope="col">آدرس</th> -->
                </tr>
            </thead>
            <tbody>
                    @foreach($costumers as $costumer)
                        <tr>
                            <td>{{ $costumer->id }}</td>
                            <td>
                                {!! Form::checkbox('costumers[]', $costumer->id) !!}
                            </td>
                            <td>{{ $costumer->first_name . ' ' . $costumer->last_name }}</td>
                            <td>{{ $costumer->description }}</td>
                            <td>{{ $costumer->national_code }}</td>
                            <td>{{ $costumer->phone_num }}</td>
                            <!-- <td>{{ $costumer->zip_code }}</td>
                            <td>{{ $costumer->address }}</td> -->
                        </tr>
                    @endforeach
                    <ul class="actions">
                         @can('delete', $costumers[0])
                            <li><a href="#" onclick="deleteCostumers(true)">حذف حواله ها</a></li>
                        @endcan
                    </ul>

                    <div style="display:flex">
                        <div id="search-status"></div>
                    </div>
            </tbody>
        </table>
        {!! Form::close() !!}
    </div>
@endsection

@section('scripts')
    <script>
        $('#table').dynatable({
            features: {
                perPageSelect: false,
            },
            dataset: {
                perPageDefault: 100,
            },
            inputs: {
                searchTarget: '#search-status',
            }
        });

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

        function deleteCostumers(multiple = false) {
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

            if (document.getElementById('order')) {
                document.getElementById('order').onclick = (event) => {
                    window.location.href = 'orders/create/' + item.firstChild.innerHTML;
                }
            }

            if (document.getElementById('edit')) {
                document.getElementById('edit').onclick = (event) => {
                    window.location.href = 'costumers/' + item.firstChild.innerHTML + '/edit';
                }
            }

            if (document.getElementById('delete')) {
                document.getElementById('delete').onclick = (event) => {
                    var number = item.children[2].innerHTML;
                    console.log(number);
                    var respond = confirm(('آیا از حذف کردن '.concat(number)).concat(' مطمئن هستید ؟ '));

                    if (respond) {
                        item.children[1].children[0].checked = true;
                        deleteCostumers(false);
                    } else {

                    }
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
@endsection