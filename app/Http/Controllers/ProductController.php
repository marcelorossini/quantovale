<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;

class ProductController extends Controller
{
	public function index($id)
		{
				$product = DB::table('products')
											->select('*')
											->where('id',$id)
											->first();
				return view('product.index',['product' => $product]);
		}

	public function create($keyword)
		{

		}
}
