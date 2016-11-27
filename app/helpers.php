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
      if (strlen($sValue)>0) {
          $sType = explode('_',$sKey)[0];
          $id_filter = explode('_',$sKey)[1];

          $nAuxPer = DB::table('percentage_list')->select('percent')->where('id_filter',$id_filter)->orderBy('date','desc')->first();
          if (isset($nAuxPer->percent)) {
            $nAuxPer = $nAuxPer->percent;
          }
          if ($sType == 'date') {

          } elseif ($sType == 'range') {
            //$nAuxPer = (10-intval($sValue));
            $nAuxPer = $nAuxPer-($nAuxPer*((intval($sValue)*10)/100));
            $aPorcentage[] = $nAuxPer;

          } elseif ($sType == 'check') {
            $aPorcentage[] = $nAuxPer;

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
  $aDados = [];
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
