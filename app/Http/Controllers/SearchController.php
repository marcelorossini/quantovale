<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Storage;

use App\Input as InputTable;
use App\Product;
use App\ProductHist;
use App\Category;

class SearchController extends Controller
{
	public function index($keyword)
	{
		//Grava pesquisa e usuário que pesquisou caso logado
		$input = new InputTable();
		$input->text = $keyword;
		$input->id_user = null;
		$input->created_at = date("Y-m-d H:i:s");
		$input->save();

		//Procura produto no buscapé
		$buscape = $this->buscape($keyword);
		return $this->result_page($buscape, $keyword);
	}

	public function result_page($ids, $keyword) {
		if (count($ids)>0) {
			$tabProducts = DB::table('products')->select('*')->whereIn('id',$ids)->get();
		} else {
			$tabProducts = DB::table('products')->select('*')->where('name', 'like', '%'.$keyword.'%')->get();
		}
		return view('search.product', ['products' => $tabProducts,'keyword' => $keyword]);
	}

	public function buscape($keyword)
	{
		// Array para produtos
		$aProducts = [];
		/*
		// Contador de oáginas
		$totalpages = 1;
		// E inicia a brincadeira
		for ($pages = 1; $pages <= $totalpages; $pages++) {
			try {
				// Busca produtos
				$opts = array('http'=>array('header' => "User-Agent:MyAgent/1.0\r\n"));
				$context = stream_context_create($opts);
				$json = file_get_contents('http://sandbox.buscape.com.br/service/findProductList/buscape/3949646a646c52444374413d/BR/?sourceId=35648701&keyword='.urlencode($keyword).'&results=100&format=json'.($pages>1?'&page='.$pages:''),false,$context);
				$obj = json_decode($json);

				// Quantidade de páginas
				if (isset($obj->totalpages)) {
					$totalpages = $obj->totalpages;
				}

				// Se houver resultados
				if ($obj->totalresultsreturned > 0) {
					foreach($obj->product as $item) {
						// Código do produto do buscapé
						$provider_cod = Product::where('provider_cod',$item->product->id)->get(['id']);
						//dd($item);
						// Código do produto no sistema
						$product_id = 0;
						if ($provider_cod->toArray() == null) {
							$product = new Product();
							$product->id_provider  = 1;
							$product->provider_cod = $item->product->id;
							$product->name         = $item->product->productname;

							$product->short_name   = '';
							if (isset($item->product->productshortname)) {
								$product->short_name   = $item->product->productshortname;
							}
							$product->id_category  = $item->product->categoryid;
							$product->created_at   = date("Y-m-d H:i:s");
							$product->save();
							$product_id = $product->id;
							// Se já existir
						} else {
							$product_id = $provider_cod->toArray()[0]['id'];
						}

						// Verifica se o produto já está com o preço cadastrado no dia
						$tabProductHist = DB::table('products_hist')
						->select('id')
						->where('id_product',$product_id)
						->where('date',date("Y-m-d"))
						->first();

						// Grava o valor no produto
						if ($tabProductHist == null) {
							$product_hist = new ProductHist();
							$product_hist->id_product = $product_id;
							$product_hist->date       = date("Y-m-d");

							$product_hist->price_min = 0;
							if (isset($item->product->pricemin)) {
								$product_hist->price_min = $item->product->pricemin;
							}
							$product_hist->price_max = 0;
							if (isset($item->product->pricemax)) {
								$product_hist->price_max = $item->product->pricemax;
							}

							$product_hist->save();
						}

						// Grava imagem
						if (isset($item->product->thumbnail->url) && count(Storage::files('product/images/'.$product_id.'/')) == 0) {
							// Url da thumbnail
							$sUrl = $item->product->thumbnail->url;

							// Procura thumbnail com melhor resolução
							for ($nRes = 6;$nRes >=0;$nRes--) {
								$cRes = (string)($nRes*100).'x'.(string)($nRes*100);
								try {
									$sUrl = str_replace(["100x100","200x200","300x300","400x400","500x500"],$cRes,$sUrl);
									$sTeste = file_get_contents($sUrl);

								} catch (\Exception $e) {
								}
								if (!is_null($sTeste)) {
									break;
								}
							}

							// Grava na pasta
							$cNomArq = 'bcp_'.$cRes.'.jpg';
							Storage::disk('local')->put('product/images/'.$product_id.'/'.$cNomArq,$sTeste);
						}

						// Adiciona o produto no array
						$aProducts[] = $product_id;
					}
				}
			} catch (\Exception $e) {

			}
		}
		*/
		return $aProducts;
	}
}
