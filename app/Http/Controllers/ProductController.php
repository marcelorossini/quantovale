<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Storage;

use App\User;
use App\Result;
use App\Product;
use App\Filter;

class ProductController extends Controller
{
	public function index($id)
		{
				// Dados produto
				$tabProduct = DB::table('products as p')
											->select(DB::raw('p.*,(select c.id from categories c where c.provider_category = p.id_category) id_catapp'))
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
				$valor = end($tabProductHist[1]);
				// Filtros
				$aFilters = $this->filters((isset($tabProduct->id_catapp) ? $tabProduct->id_catapp : null));
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
													->where(function($q) {
														$q->where('price_min','<>',0)->orWhere('price_max','<>',0);
													})
		                      ->get();

				foreach($tabProductHist as $aProductItem)	{
			  		$aLabels[] = date('d/m/y',strtotime(str_replace('-','/', $aProductItem->date)));
						$aMenorPreço[] = $aProductItem->price_min;
						$aMaiorPReco[] = $aProductItem->price_max;
				}

				return [$aLabels,$aMenorPreço,$aMaiorPReco];
		}

	// Cria os filtros na tela
	public function filters($nCategory) {
		$tabCategoriesFilters = DB::table('categories_filters')
											        ->select('*')
											        ->where('id_category',$nCategory)
											        ->orWhere('id_category',null)
											        ->orderBy('order')
        											->get();
		return $tabCategoriesFilters;
	}

	// Cria registro  na tabela de resultado
	public function result(Request $request, $idProduct) {
		$request = $request->all();
		unset($request['_token']);

		$idResults = new Result();
		$request = serialize($request);
		$idResults->result      = $request;
		if (\Auth::check())
		{
				$idResults->id_user = \Auth::user()->id;
		}
		$idResults->id_product  = $idProduct;
		$idResults->created_at  = date("Y-m-d H:i:s");
		$idResults->save();

		$aReturn = [
			'valor' => calculaResult($idResults->id),
			'result' => $idResults->id,
		];

		return json_encode($aReturn);
	}

	// Marca registro como salvo, para aparecer no menu de usuário
	public function resultSave($idProduct, $idResult) {
		$tabResult = Result::find($idResult);
		$tabResult->save = true;
		$tabResult->save();
		return true;
	}

	// Monta pagina de
	public function share($idResult) {
		// Dados do resultado
		$tabResult = Result::find($idResult);
		if (is_null($tabResult->id_user))  {
			abort(403, 'Unauthorized action.');
		}
		// Usuário
		$tabUsuario = User::find($tabResult->id_user);
		// Array com os filtros serializados
		$aResult = unserialize($tabResult->result);
		// Tabela de produtos
		$tabProduct = Product::find($tabResult->id_product);
		// Gera um array com os filtros e os valores
		$aFiltres = [];
		while ($sKey = key($aResult)) {
				$sValue = trim(current($aResult));
				if (strlen($sValue)>0) {
						$nFilter = explode('_',$sKey)[1];
						$aFiltres[] = [Filter::find($nFilter)->name,$sValue];
				}
				next($aResult);
		}
		// Calcula valor do produto
		$nValor = calculaResult($idResult);

		return view('product.share',['tabProduct' => $tabProduct,'aFiltres' => $aFiltres,'tabUsuario' => $tabUsuario,'nValor' => $nValor]);
	}
}
