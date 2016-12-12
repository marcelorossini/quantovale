<!DOCTYPE html>
<html lang="en">
<head>

  @include('layouts.headg')

  <!-- Facebook -->
  <meta property="og:type"          content="website" />
  <meta property="og:title"         content="Vendo meu {{ $tabProduct->name }} por R$ {{ $nValor[2] }}" />
  <meta property="og:description"   content="{{ $tabProduct->name }}" />
  <meta property="og:image"         content="{{ route('getProductImage',[$tabProduct->id,'bcp_600x600.jpg']) }}"/>
</head>
<body id="main" class="">
@include('facebook.helpers')
@include('layouts.header')

<main class="grey lighten-4 valign-wrapper">
  <div class="container">
    <div class="row valign-wrapper" style="padding-top: 1em;">
      <div class="col s3 m4 l1">
        <img src="{{ $aFacebook['picture_480'] }}" alt="" class="circle responsive-img" style="border: 1px solid #bdbdbd;"> <!-- notice the "circle" class -->
        <div style="margin-top: -30px"><i class="mdi mdi-facebook-box color-facebook"></i></div>
      </div>
      <div class="col s9 m8 l11">
        <div class="flow-text" style="font-size: 2.5em;">
          {{ $tabUsuario->name }} está vendendo:
        </div>
      </div>
    </div>

    <div class="card-panel">
      <div class="row">
        <!-- Imagem do produto -->
        <div class="col s12 m6 offset-m3 l3 center" id="produto_img">
          <img style="width: 100%;" src="{{ route('getProductImage',[$tabProduct->id,'bcp_600x600.jpg']) }}">
          *Imagem meramente ilustrativa
        </div>
        <!-- Dados do produto -->
        <div class="col s12 m12 l9">
          <h4>{{ $tabProduct->name }}</h4>
          @foreach ($aTags as $tag)
          <div class="chip">
            {{ $tag }}
          </div>
          @endforeach
          <div class="flow-text">
            <ul class="">
              @foreach ($aFiltres as $sFilter)
              <li class="">{{ $sFilter[0] }}: {{ $sFilter[1] }}</li>
              @endforeach
            </ul>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col s12 m4 l4">
        <div class="card divValores">
          <div class="red darken-1 valign-wrapper" style="height: 80px">
            <div class="flow-text center white-text center" style="width: 100%; font-size: 2.3em;">R$ {{ $nValor[0] }}</div>
          </div>
          <div class="card-action">
            <a href="#" class="black-text">Lojas Físicas</a>
          </div>
        </div>
      </div>

      <div class="col s12 m4 l4">
        <div class="card divValores">
          <div class="orange darken-1 valign-wrapper" style="height: 80px">
            <div class="flow-text center white-text center" style="width: 100%; font-size: 2.3em;">R$ {{ $nValor[1] }}</div>
          </div>
          <div class="card-action">
            <a href="#" class="black-text">Lojas virtuais</a>
          </div>
        </div>
      </div>

      <div class="col s12 m4 l4">
        <div class="card divValores">
          <div class="green accent-4 valign-wrapper" style="height: 80px">
            <div class="flow-text center white-text center" style="width: 100%; font-size: 2.3em;">R$ {{ $nValor[2] }}</div>
          </div>
          <div class="card-action">
            <a href="#" class="black-text">Valor de {{ strtok($tabUsuario->name,' ') }}</a>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col s12 m12 l4 offset-l8 right-align">
        <div class="fb-send" data-href="http://quantovale.tk/product/share/13"></div>
        <!--<a href="{{ $aFacebook['profile'] }}" class="waves-effect waves-light btn indigo" style="width: 100%;"><i class="mdi mdi-facebook"></i> ENVIE UMA MENSAGEM PARA {{ strtoupper(strtok($tabUsuario->name,' ')) }}</a>-->
      </div>
    </div>
    <!--
          <div class="col s12 m4 l3">
            <div class="card">
              <div>
                <div class="col l4 indigo valign-wrapper">
                  <div class="flow-text center white-text center" style="width: 100%; font-size: 2.3em;"><i class="mdi mdi-facebook"></i></div>
                </div>
                <div class="col l8 valign-wrapper">
                  <a href="{{ $aFacebook['profile'] }}" class="black-text">ENVIE UMA MENSAGEM PARA {{ strtoupper(strtok($tabUsuario->name,' ')) }}</a>
                </div>
              </div>
            </div>
          </div>
    -->
  </main>

  <!-- Corrige o tamanho do grafico-->
  <script>
  $(document).ready(function(){
    $('.divValores').matchHeight();
  });
  </script>

  @include('layouts.footer')

</body>
</html>
