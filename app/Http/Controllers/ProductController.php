<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Storage;

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
				if (isset($tabProduct->id_category)){
						$tabMarca = DB::table('manufacturers as m')
						            ->select('m.name')
												->where('m.provider_category',$tabProduct->id_category)
												->whereRaw('find_in_set(m.name,replace(?," ",","))',$tabProduct->name)
												->first();
						if (isset($tabMarca)) {
								$tabMarca = $tabMarca->name;
						}
				}

				// Tags
				if (isset($tabMarca) && !is_null($tabMarca)) {
						$tags[] = $tabMarca;
				}
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

				// Imagem
				$aImages = Storage::files('product/images/'.$id.'/');
				if (count($aImages)>0) {
						$sUrlImage = $aImages[0];
						$sUrlImage = pathinfo($sUrlImage,PATHINFO_BASENAME);
				}
				$sUrlImage = Route("getProductImage",[$id,$sUrlImage]);

				return view('product.index',['product' => $tabProduct,'marca' => $tabMarca,'valor' => $valor,'tags' => $tags,'image' => $sUrlImage]);
		}

	public function create($keyword)
		{

		}
}
