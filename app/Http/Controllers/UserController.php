<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;

class UserController extends Controller
{
  public function favorites()
  {
    $tabResults = DB::table('results as r')
                    ->join('products as p', 'p.id', '=', 'r.id_product')
                    ->select(DB::raw('p.id, p.name, r.id as id_result'))
                    ->where('id_user',\Auth::user()->id)
                    ->where('save',true)
                    ->orderBy('p.created_at')
                    ->get();

		return view('user.favorites',['aResults' => $tabResults]);
  }

  public function shared()
  {
    $tabResults = DB::table('results as r')
                    ->join('products as p', 'p.id', '=', 'r.id_product')
                    ->select(DB::raw('p.id, p.name, r.id as id_result, r.created_at'))
                    ->where('id_user',\Auth::user()->id)
                    ->orderBy('p.created_at')
                    ->get();

    return view('user.shared',['aResults' => $tabResults]);
  }
}
