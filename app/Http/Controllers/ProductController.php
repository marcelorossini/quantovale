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

				// Chart
				$tabProductHist = $this->products_hist($id);
				// Calcula valor produto
				$valor = CalcValProduct($id);

				// Filtros
				$aFilters = $this->filters((isset($tabProduct->id_category) ? $tabProduct->id_category : 0));
				// Imagem
				/*
				$aImages = Storage::files('product/images/'.$id.'/');
				if (count($aImages)>0) {
						$sUrlImage = $aImages[0];
						$sUrlImage = pathinfo($sUrlImage,PATHINFO_BASENAME);
				}
				*/
				$sUrlImage = Route("getProductImage",[$id,"bcp_600x600.jpg"]);

				return view('product.index',['aProduct' => $tabProduct,'marca' => $tabMarca,'nValorNovo' => $valor,'aTags' => $tags,'image' => $sUrlImage,'aChart' => $tabProductHist,'aFilters' => $aFilters]);
		}

	// Retorna dados para uso no grafico
	public function products_hist($id)
		{
				$tabProductHist = DB::table('products_hist')
		                      ->select('date','price_min','price_max')
		                      ->where('id_product',$id)
		                      ->get();

				foreach($tabProductHist as $aProductItem)	{
			  		$aLabels[] = date('d/m/y',strtotime(str_replace('-','/', $aProductItem->date)));
						$aMenorPreço[] = $aProductItem->price_min;
						$aMaiorPReco[] = $aProductItem->price_max;
				}

				return [$aLabels,$aMenorPreço,$aMaiorPReco];
		}

	public function filters($nCategory) {
		$tabCategoriesFilters = DB::table('categories_filters')
											        ->select('*')
											        ->where('id_category',$nCategory)
											        ->orWhere('id_category',0)
											        ->orderBy('order')
        											->get();
		return $tabCategoriesFilters;
	}
}
