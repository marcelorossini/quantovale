<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Input;

$url = Input::get('url');
session(['facebookRedirect' => $url]);

class LoginController extends Controller
{
  use AuthenticatesUsers;

  public $redirectTo;

  public function __construct()
  {
    $this->middleware('guest', ['except' => 'logout']);
    $this->redirectTo = session('facebookRedirect');
  }
}
