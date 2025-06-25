<?php

namespace App\Http\Controllers;

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
    // Ambil data dari form (addons, notes, quantity)
    $addons = $request->input('addons', []);
    $notes = $request->input('notes', '');
    $quantity = $request->input('quantity', 1);

    // Harga dasar item
    $basePrice = 6.00;
    $addonsTotal = 0;

    // Harga per add-on
    $addonPrices = [
        'Extra Chicken' => 2.00,
        'Spicy Sauce' => 1.00,
        'Cheese' => 1.50,
    ];

    // Hitung total harga berdasarkan addons
    foreach ($addons as $addon) {
        $addonsTotal += $addonPrices[$addon] ?? 0;
    }

    $totalPrice = ($basePrice + $addonsTotal) * $quantity;

    // Ambil cart dari session
    $cart = session()->get('cart', []);

    // Cek apakah item dengan nama dan addons yang sama sudah ada di keranjang
    $found = false;
    foreach ($cart as &$item) {
        if ($item['name'] === $name && $item['addons'] == $addons && $item['notes'] == $notes) {
            // Jika addons dan notes sama, tambahkan quantity
            $item['quantity'] += $quantity;
            $found = true;
            break;
        }
    }

    // Jika belum ada, tambahkan item baru ke cart
    if (!$found) {
        $cart[] = [
            'name' => $name,
            'price' => $basePrice + $addonsTotal,
            'quantity' => $quantity,
            'addons' => $addons,  // Menyimpan addons
            'notes' => $notes,    // Menyimpan notes
        ];
    }

    // Simpan cart di session
    session()->put('cart', $cart);

    return redirect()->route('cart.index');  // Redirect ke halaman keranjang
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
