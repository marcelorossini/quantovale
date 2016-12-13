<?php

use Illuminate\Support\Facades\DB;

function CalcValProduct($id) {
  $aProducVal = DB::table('products_hist')
  ->select('price_min','price_max')
  ->where('id_product',$id)
  ->first();

  $nValor = 0;
  if (isset($aProducVal->price_min) && $aProducVal->price_min > 0) {
    $nValor = $aProducVal->price_min;
  } elseif (isset($aProducVal->price_max) && $aProducVal->price_max > 0) {
    $nValor = $aProducVal->price_max;
  }

  return $nValor;
}

function Mes($nMes) {
  if ($nMes == 1) {
    $sMes = "Janeiro";
  } elseif ($nMes == 2) {
    $sMes = "Fevereiro";
  } elseif ($nMes == 3) {
    $sMes = "Março";
  } elseif ($nMes == 4) {
    $sMes = "Abril";
  } elseif ($nMes == 5) {
    $sMes = "Maio";
  } elseif ($nMes == 6) {
    $sMes = "Junho";
  } elseif ($nMes == 7) {
    $sMes = "Julho";
  } elseif ($nMes == 8) {
    $sMes = "Agosto";
  } elseif ($nMes == 9) {
    $sMes = "Setembro";
  } elseif ($nMes == 10) {
    $sMes = "Outubro";
  } elseif ($nMes == 11) {
    $sMes = "Novembro";
  } elseif ($nMes == 12) {
    $sMes = "Dezembro";
  } else {
    $sMes = "Erro";
  }

  return $sMes;
}
// Marca produto
function marcaProduct($idProduct) {
  // Dados produto
  $tabProduct = DB::table('products as p')
  ->select('p.*')
  ->where('p.id',$idProduct)
  ->first();

  // Marca
  $tabMarca = '';
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

  return $tabMarca;
}

// Calcula o valor do produto
function calculaResult($idResult) {
  $tabResult = \App\Result::find($idResult);

  // Filtros selecionados
  $aResult = unserialize($tabResult->result);
  // Valor atual do produto
  $tabProduct = \DB::table('products as p')
  ->join('products_hist as ph', 'p.id', '=', 'ph.id_product')
  ->join('categories as c', 'c.provider_category', '=', 'p.id_category')
  ->select(DB::raw('coalesce(ph.price_min,ph.price_max) as valor, c.id as id_category'))
  ->where('p.id',$tabResult->id_product)
  ->where('ph.date','<=',date('Y-m-d',strtotime($tabResult->created_at)))
  ->where(function($q) {
    $q->where('ph.price_min','<>',0)->orWhere('ph.price_max','<>',0);
  })
  ->orderBy('ph.date','desc')
  ->first();
  //			->valor;

  $nValor = $tabProduct->valor;
  $nCategory = $tabProduct->id_category;
  // Busca a porcertagem de desvalorização
  $aPorcentage = [];
  if (!is_null($nAuxPer = DB::table('percentage_list')->select('percent')->where('id_product',$tabResult->id_product)->orderBy('date','desc')->first())) {
    $aPorcentage[] = $nAuxPer->percent;
  } elseif (!is_null($nAuxPer = DB::table('percentage_list')->select('percent')->where('id_category',$nCategory)->orderBy('date','desc')->first())) {
    $aPorcentage[] = $nAuxPer->percent;
  } else {
    $aPorcentage[] = 10;
  }

  // Cálcula os dados de acordo com o filtro
  while ($sKey = key($aResult)) {
    $sValue = trim(current($aResult));
    $sType = explode('_',$sKey)[0];
    $id_filter = explode('_',$sKey)[1];

    if (strlen($sValue)>0) {
      $nAuxPer = DB::table('percentage_list')->select('percent')->where('id_filter',$id_filter)->orderBy('date','desc')->first();
      $sDefault = DB::table('categories_filters')->select('default')->where('id',$id_filter)->first();

      if (isset($nAuxPer->percent)) {
        $nAuxPer = $nAuxPer->percent;
      }
      if ($sType == 'date') {
        // Usa a função strtotime() e pega o timestamp das duas datas:
        $dDataCompra = strtotime(str_replace('/', '-',$sValue));
        $dDataAtual = strtotime($tabResult->created_at);
        // Calcula a diferença de dias
        $nDiferenca = (int)floor( ($dDataAtual - $dDataCompra) / (60 * 60 * 24)); // 225 dias
        // Quanto mais velho, menos vale
        $aPorcentage[] = $nDiferenca*$nAuxPer;

      } elseif ($sType == 'range') {
        //$nAuxPer = (10-intval($sValue));
        $nAuxPer = $nAuxPer-($nAuxPer*((intval($sValue)*10)/100));
        $aPorcentage[] = $nAuxPer;

      } elseif ($sType == 'check') {
        $bCalcula = ( $sValue=="on" ? true : false );
        if ( !empty($sDefault) ) {
          $bCalcula = !$bCalcula;
        }
        if ( $bCalcula ) {
          $aPorcentage[] = $nAuxPer;
        }

      } elseif ($sType == 'select') {

      }
    }
    next($aResult);
  }

  $nPorcentage = array_sum($aPorcentage);
  $nValor = $nValor*(100-$nPorcentage)/100;
  return $nValor;
}

function facebook($idUser) {
  $tabSocialAccount = \DB::table('social_accounts as sa')
  ->select('*')
  ->where('sa.user_id',$idUser)
  ->where('sa.provider','facebook')
  ->first();
  $aDados = null;
  if (!is_null($tabSocialAccount)) {
    $aDados = [
      'id' => $tabSocialAccount->provider_user_id,
      'profile' => 'https://www.facebook.com/app_scoped_user_id/'.$tabSocialAccount->provider_user_id.'/',
      'picture' => 'https://graph.facebook.com/v2.8/'.$tabSocialAccount->provider_user_id.'/picture?width=1920',
      'picture_480' => 'https://graph.facebook.com/v2.8/'.$tabSocialAccount->provider_user_id.'/picture?width=480',

    ];
  }

  return $aDados;
}

function facebookIdUser($idUser) {
  $profile_url = 'https://www.facebook.com/app_scoped_user_id/'.$idUser;
  function get_web_page( $url )
  {
    $user_agent='Mozilla/5.0 (Windows NT 6.1; rv:8.0) Gecko/20100101 Firefox/8.0';
    $options = array(
      CURLOPT_CUSTOMREQUEST  =>"GET",        //set request type post or get
      CURLOPT_POST           =>false,        //set to GET
      CURLOPT_USERAGENT      => $user_agent, //set user agent
      CURLOPT_COOKIEFILE     =>"cookie.txt", //set cookie file
      CURLOPT_COOKIEJAR      =>"cookie.txt", //set cookie jar
      CURLOPT_RETURNTRANSFER => true,     // return web page
      CURLOPT_HEADER         => false,    // don't return headers
      CURLOPT_FOLLOWLOCATION => true,     // follow redirects
      CURLOPT_ENCODING       => "",       // handle all encodings
      CURLOPT_AUTOREFERER    => true,     // set referer on redirect
      CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
      CURLOPT_TIMEOUT        => 120,      // timeout on response
      CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
    );
    $ch      = curl_init( $url );
    curl_setopt_array( $ch, $options );
    $content = curl_exec( $ch );
    $err     = curl_errno( $ch );
    $errmsg  = curl_error( $ch );
    $header  = curl_getinfo( $ch );
    curl_close( $ch );
    $header['errno']   = $err;
    $header['errmsg']  = $errmsg;
    $header['content'] = $content;
    return $header;
  }

  /*Getting user id */
  $url = 'http://findmyfbid.com';
  $data = array('url' => $profile_url );
  // use key 'http' even if you send the request to https://...
  $options = array(
    'http' => array(
      'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
      'method'  => 'POST',
      'content' => http_build_query($data),
    ),
  );
  $context  = stream_context_create($options);
  $result = file_get_contents($url, false, $context);
  function getData($data)
  {
    $dom = new DOMDocument;
    $dom -> loadHTML( $data );
    $divs = $dom -> getElementsByTagName('code');
    foreach ( $divs as $div )
    {
      return $div -> nodeValue;

    }
  }
  $uid = getData($result);  // User ID
  return $uid;
}

function dbAtualizaBuscape() {
  // Remove limite da memoria
  Ini_set ('memory_limit', '-1');

  // Tabela de manutenção
  $tabMaintenance = DB::table('maintenance')->select('*')->where('name','atualiza:buscape')->where('date',date('Y-m-d'))->first();

  // Se manutenção já feita, não executa
  if ( count($tabMaintenance)>0 && $tabMaintenance->completed == true ) {
    return '';
  }

  // Verifica se o produto já está com o preço cadastrado no dia
  $tabCategories = DB::table('categories')
  ->select('provider_category')
  ->where('id_provider',1)
  ->where('provider_category','>=', ( count($tabMaintenance)>0 ? $tabMaintenance->auxliar : 0 ) )
  ->orderBy('provider_category')
  ->get();

  // Verifica se existe ou cria uma nova manutenção
  $idMaintenance = 0;
  if ( count($tabMaintenance)>0 ) {
    $idMaintenance = $tabMaintenance->id;
  } else {
    $tabMaintenance = new \App\Maintenance;
    $tabMaintenance->name = 'atualiza:buscape';
    $tabMaintenance->date = date('Y-m-d');
    $tabMaintenance->save();
    $idMaintenance = $tabMaintenance->id;
  }

  //$bar = $this->output->createProgressBar(count($tabCategories));

  foreach ($tabCategories as $aCategory) {
    //$this->performTask($aCategory);

    // Contador de oáginas
    $totalpages = 1;
    // E inicia a brincadeira
    for ($pages = 1; $pages <= $totalpages; $pages++) {
      try {
        // Busca produtos
        $opts = [
          'http'=>['header' => "User-Agent:MyAgent/1.0\r\n",
          'timeout'=> 30
        ]
      ];
      $context = stream_context_create($opts);
      $json = file_get_contents('http://sandbox.buscape.com.br/service/findProductList/buscape/3949646a646c52444374413d/BR/?sourceId=35648701&categoryId='.urlencode($aCategory->provider_category).'&results=100&format=json'.($pages>1?'&page='.$pages:''),false,$context);
      $obj = json_decode($json);

      // Quantidade de páginas
      if (isset($obj->totalpages)) {
        $totalpages = $obj->totalpages;
      }

      // Se houver resultados
      if ($obj->totalresultsreturned > 0) {
        foreach($obj->product as $aProduct) {
          // Código do produto do buscapé
          $nProviderCod = \App\Product::where('provider_cod',$aProduct->product->id)->get();
          // Código do produto no sistema
          $idProduct = 0;
          if (count($nProviderCod) == 0) {
            if ( date('Y-m-d',strtotime($product->created_at)) == date('Y-m-d') ) {
              continue;
            }
            $product = new \App\Product();
            $product->id_provider  = 1;
            $product->provider_cod = $aProduct->product->id;
            $product->name         = ( isset($aProduct->product->productname) ? $aProduct->product->productname : '' );
            $product->short_name   = ( isset($aProduct->product->productshortname) ? $aProduct->product->productshortname : '' );
            $product->id_category  = $aProduct->product->categoryid;
            $product->created_at   = date("Y-m-d H:i:s");
            $product->save();
            $idProduct = $product->id;
            // Se já existir
          } else {
            $idProduct = $nProviderCod->toArray()[0]['id'];
            $product = \App\Product::find($idProduct);
            $product->created_at = date("Y-m-d H:i:s");
            $product->save();
          }

          // Verifica se o produto já está com o preço cadastrado no dia
          $tabProductHist = DB::table('products_hist')
          ->select('id')
          ->where('id_product',$idProduct)
          ->where('price_min',( isset($aProduct->product->pricemin) ? $aProduct->product->pricemin : 0 ))
          ->where('price_max',( isset($aProduct->product->pricemax) ? $aProduct->product->pricemax : 0 ))
          ->first();

          // Grava o valor no produto
          if ($tabProductHist == null) {
            $productHist = new \App\ProductHist();
            $productHist->id_product = $idProduct;
            $productHist->date       = date("Y-m-d");
            $productHist->price_min = ( isset($aProduct->product->pricemin) ? $aProduct->product->pricemin : 0 );
            $productHist->price_max = ( isset($aProduct->product->pricemax) ? $aProduct->product->pricemax : 0 );
            $productHist->save();
          }

          // Grava imagem
          if (isset($aProduct->product->thumbnail->url) && count(Storage::files('product/images/'.$idProduct.'/')) == 0) {
            // Url da thumbnail
            $sUrl = $aProduct->product->thumbnail->url;

            // Procura thumbnail com melhor resolução
            for ($nRes = 6;$nRes >=0;$nRes--) {
              // Variável da imagem
              $bImagem = null;

              $cRes = (string)($nRes*100).'x'.(string)($nRes*100);
              try {
                $sUrl = str_replace(["100x100","200x200","300x300","400x400","500x500"],$cRes,$sUrl);
                $bImagem = file_get_contents($sUrl);

              } catch (\Exception $e) {
              }
              if (!is_null($bImagem)) {
                break;
              }
            }

            // Grava na pasta
            $cNomArq = 'bcp_'.$cRes.'.jpg';
            Storage::disk('local')->put('product/images/'.$idProduct.'/'.$cNomArq,$bImagem);
          }
        }
      }
    } catch (\Exception $e) {
      Storage::disk('local')->put('logs/log'.date("YmdHis").'.txt',$e);
    }
    $tabMaintenance = \App\Maintenance::find($idMaintenance);
    $tabMaintenance->auxliar = $aCategory->provider_category;
    $tabMaintenance->save();
    //$bar->advance();
  }
}

$tabMaintenance = \App\Maintenance::find($idMaintenance);
$tabMaintenance->completed = true;
$tabMaintenance->save();
//$bar->finish();
return '';
}
