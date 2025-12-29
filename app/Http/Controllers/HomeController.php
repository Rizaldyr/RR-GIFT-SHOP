<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

use App\Models\Product;

use App\Models\User;

use App\Models\Cart;

use Illuminate\Support\Facades\Auth;



class HomeController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function home()
    {
        $product = Product::all();

        if(Auth::id())
        {
            $user = Auth::user();

            $userid = $user->id;

            $count = Cart::where('user_id', $userid)->count();
        }

        else
        {
            $count = '';
        }

        return view('home.index', compact ('product', 'count'));
    }

    public function login_home()
    {
        $product = Product::all();

       if(Auth::id())
        {
            $user = Auth::user();

            $userid = $user->id;

            $count = Cart::where('user_id', $userid)->count();
        }

        else
        {
            $count = '';
        }

        return view('home.index', compact ('product', 'count'));
    }

    public function product_details($id)
    {
        $data = Product::find($id);
        if(Auth::id())
        {
            $user = Auth::user();

            $userid = $user->id;

            $count = Cart::where('user_id', $userid)->count();
        }

        else
        {
            $count = '';
        }
        return view('home.product_details', compact('data', 'count'));
    }

    public function add_cart($id)
    {
        $product_id = $id;
        $user = Auth::user();
        $user_id = $user->id;
        $data = new Cart;
        $data->user_id = $user_id;
        $data->product_id = $product_id;

        $data->save();

        return redirect()->back();
        
    }

    public function mycart()
    {
        if(Auth::id())
        {
            $user = Auth::user();
            $userid = $user->id;
            $count = Cart::where('user_id', $userid)->count();
            $cart = Cart::where('user_id', $userid)->get();
        }
        return view ('home.mycart', compact('count', 'cart'));
    }

    public function confirm_order(Request $request)
{
    $userid = Auth::user()->id;
    $cart = Cart::where('user_id', $userid)->get();

    foreach ($cart as $carts)
    {
        $order = new Order();
        $order->name = $request->name;
        $order->rec_adress = $request->address;
        $order->phone = $request->phone;
        $order->user_id = $userid;
        $order->product_id = $carts->product_id;

        // 🔵 OPSI 2 (COD)
        $order->payment_method = 'COD';
        $order->payment_status = 'Pending';

        $order->save();
        $carts->delete();
    }

    return redirect('/myorders')->with('message', 'Order COD berhasil dibuat');
}

    public function myorders()
{
    $user = Auth::user()->id;
    $count = Cart::where('user_id', $user)->count();
    $order = Order::where('user_id', $user)->get();

    return view('home.order', compact('count', 'order'));
}


     public function delete_cart($id)
    {
        $cart = Cart::find($id);

        if ($cart) {
            $cart->delete();
            return redirect()->back()->with('success', 'Item removed from cart.');
        } else {
            return redirect()->back()->with('error', 'Item not found.');
        }
    }

    public function shop()
    {
        $product = Product::all();

        if(Auth::id())
        {
            $user = Auth::user();

            $userid = $user->id;

            $count = Cart::where('user_id', $userid)->count();
        }

        else
        {
            $count = '';
        }

        return view('home.shop', compact ('product', 'count'));
    }

    public function why()
    {

        if(Auth::id())
        {
            $user = Auth::user();

            $userid = $user->id;

            $count = Cart::where('user_id', $userid)->count();
        }

        else
        {
            $count = '';
        }

        return view('home.why', compact ( 'count'));
    }

     public function contact()
    {

        if(Auth::id())
        {
            $user = Auth::user();

            $userid = $user->id;

            $count = Cart::where('user_id', $userid)->count();
        }

        else
        {
            $count = '';
        }

        return view('home.contact', compact ( 'count'));
    }

     public function testimonial()
    {

        if(Auth::id())
        {
            $user = Auth::user();

            $userid = $user->id;

            $count = Cart::where('user_id', $userid)->count();
        }

        else
        {
            $count = '';
        }

        return view('home.testimonial', compact ( 'count'));
    }
    
public function confirmOrderQris(Request $request)
{
    $userid = Auth::user()->id;
    $cart = Cart::where('user_id', $userid)->get();

    foreach ($cart as $carts)
    {
        $order = new Order();
        $order->name = $request->name;
        $order->rec_adress = $request->address;
        $order->phone = $request->phone;
        $order->user_id = $userid;
        $order->product_id = $carts->product_id;

        // 🟢 OPSI 2 (QRIS)
        $order->payment_method = 'QRIS';
        $order->payment_status = 'Paid'; // atau 'Pending'

        $order->save();
        $carts->delete();
    }

    return redirect('/myorders')->with('message', 'Pembayaran QRIS berhasil');
}


}


