<?php

namespace App\Http\Controllers;
use App\Shop;
use App\Category;

#ユーザークラスを読み込み
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class ShopController extends Controller
{
    #ログイン機能(index,showメソッド以外の機能はログインしていないと使えない)
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index()
    {
        #ユーザークラスを取得
        $user=Auth::user();
        $shops = Shop::all();
        return view('index', ['shops' => $shops, 'user' => $user]);
    }

    public function show($id)
    {
        $shop = Shop::find($id);
        $user = \Auth::user();
        if ($user) {
            $login_user_id = $user->id;
        } else {
            $login_user_id = "";
        }

        return view('show', ['shop' => $shop,'login_user_id'=>$login_user_id]);
    }

    public function create()
    {
        $shop = new Shop;
        $categories = Category::all()->pluck('name', 'id');
        return view('new', ['shop' => $shop, 'categories' => $categories]);
    }

    public function store(Request $request)
    {
        $shop = new Shop;
        $user= \Auth::user();

        $shop->name = request('name');
        $shop->address = request('address');
        $shop->category_id = request('category_id');
        $shop->user_id = $user->id;
        $shop->save();
        return redirect()->route('shop.detail', ['id' => $shop->id]);
    }
    
    public function edit($id)
    {
        $shop = Shop::find($id);
        $categories = Category::all()->pluck('name', 'id');
        return view('edit', ['shop' => $shop, 'categories' => $categories]);
    }

    public function update(Request $request, $id, Shop $shop)
    {
        $shop = Shop::find($id);
        $shop->name = request('name');
        $shop->address = request('address');
        $shop->category_id = request('category_id');
        $shop->save();
        return redirect()->route('shop.detail', ['id' => $shop->id]);
    }

    public function destroy($id)
    {
        $shop = Shop::find($id);
        $shop->delete();
        return redirect('/shops');
    }
}
