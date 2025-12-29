<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>

    @include('home.css')

    <style>
        .div_center{
            display: flex;
            justify-content: center;
            margin: 60px;
        }

        table{
            border: 2px solid black;
            text-align: center;
            width: 1000px;
        }

        th{
            background-color: black;
            color: white;
            padding: 10px;
        }

        td{
            border: 1px solid skyblue;
            padding: 10px;
        }

        .paid{ color: green; font-weight: bold; }
        .pending{ color: orange; font-weight: bold; }
    </style>
</head>

<body>

<div class="hero_area">
    @include('home.header')
</div>

<div class="div_center">
    <table>
        <tr>
            <th>Product</th>
            <th>Price</th>
            <th>Payment Method</th>
            <th>Payment Status</th>
            <th>Delivery Status</th>
            <th>Image</th>
        </tr>

        @foreach ($order as $item)
<tr>
    <td>{{ $item->product->title }}</td>

    <td>
        Rp {{ number_format((int) preg_replace('/\D/', '', $item->product->price), 0, ',', '.') }}
    </td>

    <td>{{ strtoupper($item->payment_method) }}</td>

    <td>
        {{ $item->payment_status ?? 'Success' }} 
    </td>

    <td>
        @if($item->status == 'in progress')
            <span style="color:orange; font-weight:bold">IN PROGRESS</span>
        @elseif($item->status == 'on the way')
            <span style="color:blue; font-weight:bold">ON THE WAY</span>
        @elseif($item->status == 'done')
            <span style="color:green; font-weight:bold">DONE</span>
        @else
            {{ $item->status }}
        @endif
    </td>

    <td>
        <img width="120" src="/product/{{ $item->product->image }}">
    </td>
</tr>
@endforeach

    </table>
</div>

@include('home.footer')

</body>
</html>
