<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function update(Request $request, $id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            if ($request->action == 'increment') {
                $cart[$id]['quantity']++;
            } elseif ($request->action == 'decrement') {
                $cart[$id]['quantity']--;
                if ($cart[$id]['quantity'] < 1) {
                    unset($cart[$id]); // kalau qty 0, hapus item
                }
            }
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Cart updated!');
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);
        unset($cart[$id]);
        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Item removed!');
    }

    public function clear()
    {
        session()->forget('cart');
        return redirect()->back()->with('success', 'Cart cleared!');
    }

    public function addToCart(Request $request, $name)
    {
        $food = \App\Models\Food::where('name', $name)->firstOrFail();
        $addons = $request->input('addons', []);
        sort($addons);
        $notes = $request->input('notes', '');
        $quantity = (int) $request->input('quantity', 1);

        // Ambil data add-ons dari DB berdasarkan food_id dan nama
        $addonData = DB::table('add_ons')
            ->where('food_id', $food->id)
            ->whereIn('name', $addons)
            ->get();

        $addonsTotal = $addonData->sum('price');

        $totalPrice = ($food->price + $addonsTotal) * $quantity;

        $cart = session()->get('cart', []);
        $found = false;

        foreach ($cart as &$item) {
            if (
                $item['name'] === $name &&
                $item['addons'] == $addons &&
                $item['notes'] === $notes
            ) {
                $item['quantity'] += $quantity;
                $found = true;
                break;
            }
        }

        if (!$found) {
            $cart[] = [
                'food_id' => $food->id,
                'name' => $name,
                'price' => $food->price + $addonsTotal,
                'quantity' => $quantity,
                'addons' => $addons,
                'notes' => $notes,
            ];
        }

        session()->put('cart', $cart);
        return redirect()->route('cart.index');
    }


    public function showCart()
    {
        // Ambil data keranjang dari session
        $cartItems = session()->get('cart', []);
        // Hitung total harga berdasarkan item di keranjang
        $totalPrice = collect($cartItems)->sum(fn($item) => $item['price'] * $item['quantity']);

        // Tampilkan view cart dengan data yang diambil
        return view('frontend.customer.cart', compact('cartItems', 'totalPrice'));
    }
}
