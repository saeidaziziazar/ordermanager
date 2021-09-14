<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content-type="application/pdf">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Printing</title>
    <style>
        body {
            direction: rtl;
            font-family:  'B Homa';
            font-size: 75%;
            font-weight: 400;
        }

        .container {
            position: absolute;
            top: 0%;
            right:50%;
            transform: translate(50%,0%);
            width: 70%;
        }

        table {
            width: 100%;
            border: 1px solid black;
            border-collapse: collapse;
            text-align: center;
        }

        tr, thead {
            page-break-inside: initial;
        }

        td, th {
            page-break-inside: avoid;
            border: 1px solid black;
            border-collapse: collapse;
            padding: 6px;
        }

        .flex {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
        }

        .manager {
            display: none;
            float: left;
            margin-top: 40px; 
        }

        @media print {
            .container {
                position: fixed;
                top: 0%;
                right:50%;
                transform: translate(50%,0%);
                width: 90%;
            }

            .return {
                display: none;
            }

            .manager {
                display: block;
                float: left;
                margin-top: 40px; 
            }
        }

    </style>
</head>
<body>
    <div class="container">
    <a class="return" href="{{ url('orders') }}">بازگشت</a>
    <div class="flex">
        <h3>
            مدیر محترم باربری  {{ $orders[0]->transportation->name }} آقای {{ $orders[0]->transportation->manager }} 
        </h3>
        <h3>تاریخ :{{ $date }}</h3>
    </div>
    <p style="margin:30px 0 20px 0">
        لطفا جهت ارسال کامیون برای حواله های مشروحه
            ({{ $orders[0]->owner->name . ' | ' . 'کد ملی :' . $orders[0]->owner->national_id . ' | ' . 'کد پستی :' . $orders[0]->owner->zip_code }})
        اقدام نمایید
    </p>

    <table>
        <thead>
            <th width="8%">ش.ح</th>
            <th width="45%">مشتری</th>
            <th width="18%">شماره تماس</th>
            <th width="10%">تناژ</th>
            <th>توضیحات</th>
        </thead>

        <tbody>
            @foreach($orders as $order)
                <tr>
                    <td rowspan="2"><p style="text-decoration: underline;">{{ $order->order_num }}</p></td>
                    <td>
                        {{ $order->costumer->first_name . ' ' . $order->costumer->last_name . ' | ' }}{{ $order->costumer->national_code }}
                    </td>
                    <td style="direction: ltr">{{ substr($order->costumer->cell_phone_num,0,4) . ' ' . substr($order->costumer->cell_phone_num,4,3) . ' ' . substr($order->costumer->cell_phone_num,7,4) }}</td>
                    <td>{{ number_format($order->amount) }}</td>
                    <td>{{ $order->description }}</td>
                </tr>
                <tr>
                    <td style="text-align:right" colspan="4">
                        {{ $order->costumer->address . ' |' }} 
                        <p style="direction:ltr;display:inline-block;margin:0">
                            {{ substr($order->costumer->zip_code,0,5) . ' ' . substr($order->costumer->zip_code,5,5) }}
                        </p>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3 class="manager">مدیر بازرگانی : حسن امام</h3>

    </div>

    <script>
        window.onload = function () { window.print() };
        window.onafterprint = function() { history.back() };
    </script>
</body>
</html>
