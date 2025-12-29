<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;

class AdminController extends Controller
{
    /* ================= DASHBOARD ================= */
    public function index()
    {
        $user = User::where('usertype', 'user')->count();
        $product = Product::count();
        $order = Order::count();
        $delivered = Order::where('status', 'done')->count();

        return view('admin.index', compact('user', 'product', 'order', 'delivered'));
    }

    /* ================= CATEGORY ================= */
    public function view_category()
    {
        $data = Category::all();
        return view('admin.category', compact('data'));
    }

    public function add_category(Request $request)
    {
        $category = new Category();
        $category->category_name = $request->category;
        $category->save();

        return redirect()->back();
    }

    public function delete_category($id)
    {
        Category::find($id)->delete();
        return redirect()->back();
    }

    public function edit_category($id)
    {
        $data = Category::find($id);
        return view('admin.edit_category', compact('data'));
    }

    public function update_category(Request $request, $id)
    {
        $data = Category::find($id);
        $data->category_name = $request->category;
        $data->save();

        return redirect('/view_category');
    }

    /* ================= PRODUCT ================= */
    public function add_product()
    {
        $category = Category::all();
        return view('admin.add_product', compact('category'));
    }

    public function upload_product(Request $request)
    {
        $data = new Product();
        $data->title = $request->title;
        $data->description = $request->description;
        $data->price = $request->price;
        $data->quantity = $request->qty;
        $data->category = $request->category;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagename = time().'.'.$image->getClientOriginalExtension();
            $image->move('product', $imagename);
            $data->image = $imagename;
        }

        $data->save();
        return redirect()->back()->with('success', 'Product uploaded successfully');
    }

    public function view_product()
    {
        $product = Product::paginate(3);
        return view('admin.view_product', compact('product'));
    }

    public function delete_product($id)
    {
        $data = Product::find($id);
        if ($data->image && file_exists(public_path('product/'.$data->image))) {
            unlink(public_path('product/'.$data->image));
        }
        $data->delete();

        return redirect()->back();
    }

    public function update_product($id)
    {
        $data = Product::find($id);
        $category = Category::all();
        return view('admin.update_page', compact('data', 'category'));
    }

    public function edit_product(Request $request, $id)
    {
        $data = Product::find($id);
        $data->title = $request->title;
        $data->description = $request->description;
        $data->price = $request->price;
        $data->category = $request->category;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagename = time().'.'.$image->getClientOriginalExtension();
            $image->move('product', $imagename);
            $data->image = $imagename;
        }

        $data->save();
        return redirect('/view_product');
    }

    public function product_search(Request $request)
    {
        $search = $request->search;
        $product = Product::where('title', 'LIKE', '%'.$search.'%')->paginate(3);
        return view('admin.view_product', compact('product'));
    }

    /* ================= ORDER ================= */
    public function view_orders()
    {
        $data = Order::all();
        return view('admin.order', compact('data'));
    }

    public function in_progress($id)
    {
        $order = Order::find($id);
        $order->status = 'in progress';
        $order->save();

        return redirect()->back();
    }

    public function on_the_way($id)
    {
        $order = Order::find($id);
        $order->status = 'on the way';
        $order->save();

        return redirect()->back();
    }

    public function delivered($id)
    {
        $order = Order::find($id);
        $order->status = 'done';
        $order->save();

        return redirect()->back();
    }

    public function payment_pending($id)
{
    $data = Order::find($id);
    $data->payment_status = "pending";
    $data->save();

    return redirect()->back();
}

    public function payment_paid($id)
{
    $data = Order::find($id);
    $data->payment_status = "paid";
    $data->save();

    return redirect()->back();
}
}
