<!DOCTYPE html>
<html>
  <head> 
   @include ('admin.css')

   <style type="text/css">

    table
    {
        border: 2px solid skyblue;
        text-align: center;
        color: white;
    }

    th
    {
        background-color: skyblue;
        padding: 10px;
        font-size: 18px;
        font-weight: bold;
        text-align: center;
    }

    td
    {
        color: white;
        padding: 10px;
        border: 1px solid skyblue;
    }

    .table_center
    {
        display: flex;
        justify-content: center;
        align-items: center;
    }

   </style>
  </head>
  <body>
    @include ('admin.header')
    </header>
    @include ('admin.sidebar')
      <!-- Sidebar Navigation end-->
      <div class="page-content">
        <div class="page-header">
          <div class="container-fluid">
        
        <div class="table_center">
          <table>
    <tr>
        <th>Costumer name</th>
        <th>Address</th>
        <th>Phone</th>
        <th>Product title</th>
        <th>Price</th>
        <th>Image</th>
        <th>Status</th>
        <th>Change Status</th>
        <th>Payment Status</th>
        <th>Change Payment</th>
    </tr>

    @foreach ( $data as $data )
    <tr>
        <td>{{$data->name}}</td>
        <td>{{$data->rec_adress}}</td>
        <td>{{$data->phone}}</td>
        <td>{{$data->product->title}}</td>
        <td>{{$data->product->price}}</td>
        <td>
            <img width="150" src="product/{{ $data->product->image }}">
        </td>

        <td>
            @if($data->status == 'in progress')
                <span style ="color:red">{{ $data->status }}</span>
            @elseif($data->status == 'On the way')
                <span style="color:skyblue">{{ $data->status }}</span>
            @else
                <span style="color:yellow">{{ $data->status }}</span>
            @endif
        </td>
        <td>
            <a class="btn btn-primary" href="{{ url('on_the_way',$data->id) }}">On The Way</a>
            <a class="btn btn-success" href="{{ url('delivered',$data->id) }}">Delivered</a>
        </td>

        <td>
            @if($data->payment_status == 'pending')
                <span style="color:red">{{ $data->payment_status }}</span>
            @else
                <span style="color:lightgreen">{{ $data->payment_status }}</span>
            @endif
        </td>
        <td>
            <a class="btn btn-warning" href="{{ url('payment_pending',$data->id) }}">Pending</a>
            <a class="btn btn-info" href="{{ url('payment_paid',$data->id) }}">Paid</a>
        </td>
    </tr>
    @endforeach

          </table>
        </div>
          
          </div>
        </footer>
      </div>
    </div>
    <!-- JavaScript files-->
    <script src="{{ asset('/admincss/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('/admincss/vendor/popper.js/umd/popper.min.js') }}"> </script>
    <script src="{{ asset('/admincss/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/admincss/vendor/jquery.cookie/jquery.cookie.js') }}"> </script>
    <script src="{{ asset('/admincss/vendor/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('/admincss/vendor/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('/admincss/js/charts-home.js') }}"></script>
    <script src="{{ asset('/admincss/js/front.js') }}"></script>
  </body>
</html>