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
	public function index($id, $nameProduct)
		{
				// Dados produto
				$tabProduct = DB::table('products as p')
											->select(DB::raw('p.*,(select c.id from categories c where c.provider_category = p.id_category) id_catapp'))
											->where('p.id',$id)
											->first();

				if ( $nameProduct=='____SEMNOME____' ) {
					return redirect()->route('getProduct',[$id,$tabProduct->name]);
				}
				// Tags
				$aTags = $this->tags($id, isset($tabProduct->id_category) ? $tabProduct->id_category : 0 );

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
				$aFacebook = ( \Auth::check() ? facebook(\Auth::user()->id) : null );

				return view('product.index',['aProduct' => $tabProduct,'nValorNovo' => $valor,'aTags' => $aTags,'image' => $sUrlImage,'aChart' => $tabProductHist,'aFilters' => $aFilters,'aFacebook' => $aFacebook]);
		}

		// Retorna dados para uso no grafico
		public function tags($id, $idCategory) {
			// Marca
			$tabMarca = marcaProduct($id);

			$aTags = [];
			if (isset($tabMarca) && !is_null($tabMarca)) {
					$aTags[] = $tabMarca;
			}
			$auxCategoria = $idCategory;
			while ($auxCategoria!=null) {
					$tabCategory = DB::table('categories as c')
												->select('c.name','c.id_parent')
												->where('c.provider_category',$auxCategoria)
												->first();
					$aTags[] = $tabCategory->name;
					$auxCategoria = $tabCategory->id_parent;
			}
			return $aTags;
		}

	// Retorna dados para uso no grafico
	public function products_hist($id) {
				$tabProductHist = DB::table('products_hist')
		                      ->select('date','price_min','price_max')
		                      ->where('id_product',$id)
													->where(function($q) {
														$q->where('price_min','<>',0)->orWhere('price_max','<>',0);
													})
		                      ->get();
				$aLabels = [];
				$aMenorPreço = [];
				$aMaiorPreco = [];
				foreach($tabProductHist as $aProductItem)	{
			  		$aLabels[] = date('d/m/y',strtotime(str_replace('-','/', $aProductItem->date)));
						$aMenorPreço[] = $aProductItem->price_min;
						$aMaiorPreco[] = $aProductItem->price_max;
						// Para o grafico não ficar com 1 ponto
						if ( count($tabProductHist)==1 ) {
							$aLabels[] = date('d/m/y',strtotime(str_replace('-','/', $aProductItem->date)));
							$aMenorPreço[] = $aProductItem->price_min;
							$aMaiorPreco[] = $aProductItem->price_max;
						}
				}

				return [$aLabels,$aMenorPreço,$aMaiorPreco];
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
	public function resultSave($idProduct, $idResult, $sTrueFalse) {
		$tabResult = Result::find($idResult);
		$tabResult->save = ($sTrueFalse == 'true' ? true : false );
		$tabResult->save();

		return '';
	}

	// Marca registro como compartilhado, para aparecer no menu de usuário
	public function resultShared($idProduct, $idResult) {
		$tabResult = Result::find($idResult);
		$tabResult->shared = true;
		$tabResult->save();

		return '';
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
		$aFacebook = facebook($tabResult->id_user);
		$aMessenger = messenger($tabResult->id_user);

		// Array com os filtros serializados
		$aResult = unserialize($tabResult->result);
		// Tabela de produtos
		$tabProduct = Product::find($tabResult->id_product);
		// Tags
		$aTags = $this->tags($tabResult->id_product, isset($tabProduct->id_category) ? $tabProduct->id_category : 0 );

		// Gera um array com os filtros e os valores
		$aFiltres = [];
		while ($sKey = key($aResult)) {
				$sValue = trim(current($aResult));
				if (strlen($sValue)>0) {
					  $sType = explode('_',$sKey)[0];
						$nFilter = explode('_',$sKey)[1];

						if ($sType == 'check') {
							$sValue = $sValue=='on' ? 'Sim' : 'Não';
						}
						$aFiltres[] = [Filter::find($nFilter)->name,$sValue];
				}
				next($aResult);
		}
		// Calcula valor produto
		$tabProductHist = $this->products_hist($tabResult->id_product);
		$nMaiorValor = number_format(end($tabProductHist[1]),2,",",".");
		$nMenorValor = number_format(end($tabProductHist[2]),2,",",".");
		$nValorUser = number_format(calculaResult($idResult),2,",",".");

		// Usuário não logado ou diferente do atual
		if ( !\Auth::check() || ( \Auth::check() && ( $tabResult->id_user != \Auth::user()->id ) ) ){
			$tabResult->views = $tabResult->views+1;
			$tabResult->save();
		}

		return view('product.share',['tabProduct' => $tabProduct,'aTags' => $aTags,'aFiltres' => $aFiltres,'tabUsuario' => $tabUsuario,'nValor' => [$nMenorValor,$nMaiorValor,$nValorUser], 'aFacebook' => $aFacebook, 'aMessenger' => $aMessenger]);
	}

	public function atualizaBuscape() {
 		dbAtualizaBuscape();
		return '';
	}
}
