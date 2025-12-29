<!DOCTYPE html>
<html>

<head>
  @include('home.css')

  <style type="text/css">

    .div_deg
    {
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 60px;
    }

    table
    {
        border: 2px solid black;
        text-align: center;
        width: 800px;
    }

    th
    {
        border: 2px solid black;
        text-align: center;
        color: white;
        font: 20px;
        font-weight: bold;
        background-color: black;
    }

    td
    {
        border: 1px solid skyblue;
    }

    .cart_value
    {
        text-align: center;
        margin-bottom: 70px;
        padding: 18px;
    }

    .order_deg
    {
        padding-right: 100px;
        margin-top: -50px;
    }

    label
    {
        display: inline-block;
        width: 150px;

    }

    .div_gap
    {
        padding: 10px;
    }


  </style>
</head>

<body>
  <div class="hero_area">
    <!-- header section strats -->
    @include('home.header')
    <!-- end header section -->
  </div>

<div class="div_deg">

    <div class="order_deg" style="display: flex; justify-content: center; align-items: center;">
        <form action="{{ url('confirm_order') }}" method="POST">
            @csrf
            <div class="div_gap">
                <label>NAMA</label>
                <input type="text" name="name" value="{{Auth::user()->name}}">
            </div>

            <div class="div_gap">
                <label>ALAMAT</label>
                <textarea name="address">{{Auth::user()->address}}</textarea>
            </div>

            <div class="div_gap">
                <label>NOMOR HP</label>
                <input type="text" name="phone" value="{{Auth::user()->phone}}">
            </div>

            <div class="div_gap">
                
                <input class="btn btn-primary" type="submit" value="Cash On Delivery">
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#qrisModal">QRIS</button>
            </div>
        </form>
    </div>
    
    <table>
        <tr>
            <th>Product title</th>
            <th>Price</th>
            <th>Image</th>
            <th>Remove</th>
        </tr>

        <?php

        $value=0;

        ?>

        @foreach ($cart as $cart)
        
        <tr>
            <td>{{$cart->product->title}}</td>
            <td>{{$cart->product->price}}</td>
            <td>
                <img width="150" src="/product/{{ $cart->product->image }}">
            </td>

            <td>
                <a class="btn btn-danger" href="{{ url('delete_cart', $cart->id) }}">Remove</a>
            </td>
        </tr>

        <?php
        $value = $value + (int) filter_var($cart->product->price, FILTER_SANITIZE_NUMBER_INT);
        ?>

        @endforeach
    </table>
</div>

    <div class="cart_value">
        <h3>Total: Rp {{ number_format($value,0,',','.') }}</h3>

    </div>
<!-- Modal QRIS -->
<div class="modal fade" id="qrisModal" tabindex="-1" role="dialog" aria-labelledby="qrisModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="qrisModalLabel">Pembayaran QRIS</h5>
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>

      <div class="modal-body text-center">

        <p>Silakan scan QRIS di bawah ini untuk melakukan pembayaran</p>

        <!-- QR Code -->
        <img src="/images/qris.jpg" width="200" alt="QRIS">

        <hr>

        <h5>Total Pembayaran</h5>
        <h4>Rp {{ number_format($value,0,',','.') }}</h4>

        <p class="text-muted">Pembayaran akan diverifikasi otomatis</p>

      </div>

      <div class="modal-footer">
        <form action="{{ url('confirm_order_qris') }}" method="POST">
            @csrf
            <input type="hidden" name="name" value="{{Auth::user()->name}}">
            <input type="hidden" name="address" value="{{Auth::user()->address}}">
            <input type="hidden" name="phone" value="{{Auth::user()->phone}}">

            <button type="submit" class="btn btn-primary">
                Saya Sudah Bayar
            </button>
        </form>

        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
      </div>

    </div>
  </div>
</div>
    @include('home.footer')
    <!-- footer section -->
    <footer class=" footer_section">

      <div class="container">
        <p>
          &copy; <span id="displayYear"></span> All Rights Reserved By
          <a href="https://html.design/">RR gift shop</a>
        </p>
      </div>
    </footer>
    <!-- footer section -->

  </section>

  <!-- end info section -->


  <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
  <script src="{{ asset('js/bootstrap.js') }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js">
  </script>
  <script src="{{ asset('js/custom.js') }}"></script>

</body>

</html>