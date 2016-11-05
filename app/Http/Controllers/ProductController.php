<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;

class ProductController extends Controller
{
	public function index($id)
		{
				// Dados produto
				$product = DB::table('products as p')
											->select('p.*')
											->where('p.id',$id)
											->first();

				// Marca
				$marca = "";
				if (isset($product->id_category)){
						$marca = DB::table('manufacturers as m')
						            ->select('m.name')
												->where('m.provider_category',$product->id_category)
												->whereRaw('find_in_set(m.name,replace(?," ",","))',$product->name)
												->first();
						$marca = $marca->name;
				}

				// Calcula valor produto
				$valor = CalcValProduct($id);

				return view('product.index',['product' => $product,'marca' => $marca,'valor' => $valor]);
		}

	public function create($keyword)
		{

		}
}
