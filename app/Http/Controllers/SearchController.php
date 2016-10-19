<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;

use App\Input as InputTable;
use App\Product;
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

			return $this->result($buscape, $keyword);
		}

	public function result($ids, $keyword) {
			$products = DB::table('products')
			              ->select('*')
										->whereIn('id',$ids)
										->get();
			return view('search.product', ['products' => $products,'keyword' => $keyword]);
	}

	public function buscape($keyword)
		{
			/*
			$url = file_get_contents('http://sandbox.buscape.com.br/service/findProductList/554163674d2f57624d676f3d/BR/?keyword='.urlencode($keyword).'&results=100');
			$xml = new \SimpleXMLElement($url);
			*/
			$opts = array('http'=>array('header' => "User-Agent:MyAgent/1.0\r\n"));
			$context = stream_context_create($opts);
			$json = file_get_contents('http://sandbox.buscape.com.br/service/findProductList/554163674d2f57624d676f3d/BR/?keyword='.urlencode($keyword).'&results=100&format=json',false,$context);
			$obj = json_decode($json);

			$products = [];
			dd('http://sandbox.buscape.com.br/service/findProductList/554163674d2f57624d676f3d/BR/?keyword='.urlencode($keyword).'&results=100&format=json');
			if ($obj->totalresultsreturned > 0) {
					foreach($obj->product as $item)
					{
							if (Category::find($item->product->categoryid) == null) {
									$category = new Category();
									$category->id = $item->product->categoryid;
									$category->name = '53w53';
									$category->save();
							}

							$provider_cod = Product::where('provider_cod',$item->product->id)->get(['id']);

							$product_id = 0;
							if ($provider_cod->toArray() == null) {
									$product = new Product();
									$product->id_provider  = 1;
									$product->provider_cod = $item->product->id;
									$product->name         = $item->product->productname;
					 				$product->short_name   = $item->product->productshortname;
					 				$product->id_category  = $item->product->categoryid;
					 				$product->created_at   = date("Y-m-d H:i:s");
					 				$product->save();
									$product_id = $product->id;
							} else {
									$product_id = $provider_cod->toArray()[0]['id'];
							}
							$products[] = $product_id;
					}
			}

			return $products;
			/*
			$item->product->id

										 //$item->product->pricemin,
										 //$product->product->pricemax,

			$products[] = [$product->product->id,
										 $product->product->productname,
										 $product->product->productshortname,
										 //$product->product->pricemin,
										 //$product->product->pricemax,
										 $product->product->categoryid];
			$xml->product->count()
			$xml->product[0]->attributes()->id
			$xml->product[0]->productName
			$xml->product[0]->productShortName
			$xml->product[0]->priceMin
			$xml->product[0]->priceMax
			$xml->product[0]->attributes()->categoryId
			$xml->category->name
			*/

			/*for ($i = 0; $i <= $xml->product->count(); $i++) {
				$product = new Product();
				$product->name = $xml->product[$i]->productName;
				$product->short_name = $xml->product[$i]->productShortName;
				$product->id_category = $xml->product[$i]->attributes()->categoryId;
				$product->created_at = date("Y-m-d H:i:s");
				$product->save();
			}

			for ($i = 0; $i <=10; $i++) {
					$products[] = ["productId" => $xml->product[$i]->attributes()->id,
										 			"productName" => $xml->product[$i]->productName,
										 			"productShortName" => $xml->product[$i]->productShortName,
										 			"priceMin" => $xml->product[$i]->priceMin,
										 			"priceMax" => $xml->product[$i]->priceMax,
										 			"categoryId" => $xml->product[$i]->attributes()->categoryId,
										 			"categoryName" => $xml->category->name
					];
			}
*/
//			dd($products);

		}
}