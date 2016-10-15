<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Input;
use App\Product;

class HomeController extends Controller
{
	public function index()
		{
			return view('search/product',compact('teste'));
		}

	public function search($keyword)
		{
			//Grava pesquisa e usuário que pesquisou caso logado
			$input = new Input();
			$input->text = $keyword;
			$input->id_user = null;
			$input->created_at = date("Y-m-d H:i:s");
			$input->save();

			//Procura produto no buscapé
			$buscape = $this->buscape($keyword);
			return $buscape;
		}

	public function buscape($keyword)
		{
			/*
			$url = file_get_contents('http://sandbox.buscape.com.br/service/findProductList/554163674d2f57624d676f3d/BR/?keyword='.urlencode($keyword).'&results=100');
			$xml = new \SimpleXMLElement($url);
			*/

			$json = file_get_contents('http://sandbox.buscape.com.br/service/findProductList/554163674d2f57624d676f3d/BR/?keyword='.urlencode($keyword).'&results=100&format=json');
			$obj = json_decode($json);
			dd($obj);
			/*
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
			}*/

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

			dd($products);
			return 'Ok';
		}

}
