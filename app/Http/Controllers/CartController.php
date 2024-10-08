<?php

// CartController.php
namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    // CartController.php
    // CartController.php
    public function data()
    {
        $data = session()->get('cart');
        return response()->json([
            'data' => $data
        ]);
    }

    public function add($productId)
    {
        $cart = session()->get('cart');
        $product = Product::find($productId);

        if (!$product) {
            return redirect()->back()->with('error', 'Product not found!');
        }

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += 1;
        } else {
            $cart[$productId] = [
                'name' => $product->name,
                'photo' => $product->photo,
                'price' => $product->price,
                'quantity' => 1,
            ];
        }
        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Product added to cart!');
    }

    public function decrement($productId)
    {
        $cart = session()->get('cart');

        if (isset($cart[$productId])) {
            if ($cart[$productId]['quantity'] == 1) {
                unset($cart[$productId]);
            } else {
                $cart[$productId]['quantity'] -= 1;
            }
        }
        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Product success reduced!');
    }


    public function remove($productId)
    {
        $cart = session()->get('cart');

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
        }
        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Product removed from cart!');
    }
    // Validasi data yang diterima dari permintaan
    public function saveCart(Request $request)
    {
        \Log::info('Received cart data: ' . json_encode($request->all()));

        $cartItems = $request->cartItems;
        $userId = auth()->id();

        $dataToInsertOrUpdate = [];
        foreach ($cartItems as $item) {
            $dataToInsertOrUpdate[] = [
                'user_id' => $userId,
                'product_id' => $item['product_id'],
                'store_id' => $item['store_id'],
                'category_id' => $item['category_id'],
                'quantity' => $item['quantity'],
                'photo' => $item['photo'],
                'updated_at' => now(),
                'created_at' => now() // Or handle only `updated_at` depending on your use case
            ];
        }

        // Batch Insert (or Update if necessary)
        Cart::upsert($dataToInsertOrUpdate, ['user_id', 'product_id', 'store_id', 'category_id'], ['quantity', 'photo']);

        return redirect()->route('checkout.details')->with('success', 'Cart successfully added.');
    }

}
