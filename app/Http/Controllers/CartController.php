<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use Illuminate\Http\Request;
use App\Http\Services\CartService;
use App\Models\Category;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index(Request $request)
    {
        $result = $this->cartService->create($request);
        if ($result === false) {
            return redirect()->back();
        }

        return redirect('/carts');
    }

    public function show()
    {
        $products = $this->cartService->getProduct();
        $categories = Category::where('parent_id', 0)->with('children')->get();
        return view('carts.list', [
            'title' => 'Giỏ Hàng',
            'products' => $products,
            'categories' => $categories,
            'carts' => Session::get('carts')
        ]);
    }

    public function update(StoreOrderRequest $request)
    {

        $this->cartService->update($request);
        // Lưu thông tin khách hàng vào session
        $request->session()->put('name', $request->input('name'));
        $request->session()->put('phone', $request->input('phone'));
        $request->session()->put('address', $request->input('address'));
        $request->session()->put('email', $request->input('email'));
        $request->session()->put('content', $request->input('content'));

        return redirect('/carts');
    }

    public function remove($id = 0)
    {
        $this->cartService->remove($id);

        return redirect('/carts');
    }

    public function addCart(StoreOrderRequest $request)
    {
        $this->cartService->addCart($request);

        return redirect()->back();
    }
}