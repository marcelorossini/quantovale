<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Category;
use App\Manufacture;

use DB;

class CategoryController extends Controller
{
		public function index()
			{
				return view('home.index',['keyword' => '']);
			}

		public function update()
			{
				set_time_limit(86400);
				$opts = array('http'=>array('header' => "User-Agent:MyAgent/1.0\r\n"));
				$context = stream_context_create($opts);

				for ($i = 12000; $i <= 15000; $i++) {
						$json = file_get_contents('http://sandbox.buscape.com.br/service/findCategoryList/3949646a646c52444374413d/BR/?categoryId='.$i.'&format=json',false,$context);
						$obj = json_decode($json);
						//dd($obj);

						if (isset($obj->category) && $obj->category->name != "Início") {
								$category_cod = DB::table('categories')
														    	->select('provider_category')
															    ->where('provider_category',$obj->category->id)
															    ->first();

								if ($category_cod == null) {
										$categorytable = new Category();
										$categorytable->id_provider = 1;
										$categorytable->provider_category = $obj->category->id;
										$categorytable->name = $obj->category->name;
										$categorytable->id_parent = $obj->category->parentcategoryid;
										$categorytable->save();

										$category = $obj->category->id;
								} else {
										$category = $category_cod->provider_category;
								}

								if (isset($obj->category->filters[0]->filter->name)) {
										$filtros = $obj->category->filters[0]->filter;
										if ($filtros->name == "Marca" && isset($filtros->value)) {
												foreach($filtros->value as $marca) {
														$manufacture_cod = DB::table('manufacturers')
																				         ->select('provider_manufacture')
																					       ->where('provider_manufacture',$marca->value->id)
																					       ->first();

													 	if ($manufacture_cod == null) {
																$manufacturetable = new Manufacture();
																$manufacturetable->id_provider = 1;
																$manufacturetable->provider_category = $category;
																$manufacturetable->provider_manufacture = $marca->value->id;
																$manufacturetable->name = $marca->value->value;
																$manufacturetable->save();
														}
												}
										}
								}
								echo '<br><br>';
						}
						//dd($obj->{'name'});
						//$obj->category->filters[0]->filter->name
						//isset($obj->category)
				}

				return '';
			}
}
