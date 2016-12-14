<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use DB;
use Storage;

use App\Input as InputTable;
use App\Product;
use App\ProductHist;
use App\Category;

class SearchController extends Controller
{
	public function index($keyword = null)
	{
		if (is_null($keyword)) {
			$keyword = Input::get('product');
		}
		//Grava pesquisa e usuário que pesquisou caso logado
		$input = new InputTable();
		$input->text = $keyword;
		$input->id_user = null;
		$input->created_at = date("Y-m-d H:i:s");
		$input->save();

		return $this->result_page($keyword);
	}

	public function result_page($keyword) {
		$tabCategory = DB::table('categories as c')
									->select('c.provider_category')
									->where('c.name', 'like', '%'.$keyword.'%')
									->get()->toArray();

		$tabProducts = DB::table('products as p')
		                 ->join('products_hist as ph', 'p.id', '=', 'ph.id_product')
		                 ->join('categories as c', 'p.id_category', '=', 'c.provider_category')
		                 ->select('p.*')
										 ->where(function($q) use ($keyword, $tabCategory) {
		 									 $q->where('p.name', 'like', '%'.$keyword.'%')->orWhereIn('p.id_category', ( count($tabCategory)>0 ? array_values($tabCategory) : 0 ) );
										 })
										 ->where('ph.price_min', '<>', 0)
										 ->groupBy('p.id')
										 ->limit(50)
										 ->get();

		return view('search.product', ['products' => $tabProducts,'keyword' => $keyword]);
	}
}
