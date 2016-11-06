<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;

class ProductController extends Controller
{
	public function index($id)
		{
				// Dados produto
				$tabProduct = DB::table('products as p')
											->select('p.*')
											->where('p.id',$id)
											->first();

				// Marca
				$tabMarca = "";
				if (isset($tabProduct->id_category)){
						$tabMarca = DB::table('manufacturers as m')
						            ->select('m.name')
												->where('m.provider_category',$tabProduct->id_category)
												->whereRaw('find_in_set(m.name,replace(?," ",","))',$tabProduct->name)
												->first();
						$tabMarca = $tabMarca->name;
				}
				// Tags
				$tags[] = $tabMarca;
				if (isset($tabProduct->id_category)){
						$auxCategoria = $tabProduct->id_category;
						while ($auxCategoria!=null) {
								$tabCategory = DB::table('categories as c')
															->select('c.name','c.id_parent')
															->where('c.provider_category',$auxCategoria)
															->first();
								$tags[] = $tabCategory->name;
								$auxCategoria = $tabCategory->id_parent;
						}
				}

				// Calcula valor produto
				$valor = CalcValProduct($id);

				return view('product.index',['product' => $tabProduct,'marca' => $tabMarca,'valor' => $valor,'tags' => $tags]);
		}

	public function create($keyword)
		{

		}
}
