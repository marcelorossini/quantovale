<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class HomeController extends Controller
{
	public function index()
		{
			return view('home/search/product',compact('teste'));
		}

	public function search($keyword)
		{			
			//$request->product Request $request
			$buscape = $this->buscape($keyword);
			return $buscape;
		}

	public function buscape($keyword)
		{
			//$keyword = 'Motorola Moto X primeira geração';
			$url = file_get_contents('http://sandbox.buscape.com.br/service/findProductList/554163674d2f57624d676f3d/BR/?categoryId=77&keyword='.urlencode($keyword));
			$xml = new \SimpleXMLElement($url);

			/*
			$xml->product[0]->productName
			$xml->product[0]->priceMin
			$xml->product[0]->priceMax
			$xml->product->count()
			*/

			dd($xml->product[0]->productName);

			return 'teste';
		}

}
