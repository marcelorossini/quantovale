<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Facebook -->
  <meta property="og:type"          content="website" />
  <meta property="og:title"         content="Vendo meu {{ $tabProduct->name }} por R$ {{ $nValor }}" />
  <meta property="og:description"   content="{{ $tabProduct->name }}" />
  <meta property="og:image"         content="{{ route('getProductImage',[$tabProduct->id,'bcp_600x600.jpg']) }}"/>

  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <!-- App -->
  <link href="{{ asset("/css/materialize.css") }}" rel="stylesheet">
  <link href="{{ asset("/css/app.css") }}" rel="stylesheet">

  <!-- Fontes -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

  <!-- Icones -->
  <link href="//cdn.materialdesignicons.com/1.7.22/css/materialdesignicons.min.css" rel="stylesheet">

  <!-- Jquery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="{{ asset("/js/materialize.js") }}"></script>
  <script src="{{ asset("/js/helpers.js") }}"></script>

  <!-- Ajax -->
  <script src="{{ asset("/js/ajax/jquery.form.js") }}"></script>

  <!-- Tamanho dos cards -->
  <script src="{{ asset("/js/matchHeight/jquery.matchHeight.js") }}"></script>

  <!-- App -->
  <link href="{{ asset("/css/materialdesignicons.min.css") }}" media="all" rel="stylesheet" type="text/css"/>
</head>
<body id="main" class="">
  <nav class="purple lighten-2">
    <div class="nav-wrapper">
      <a href="#" class="brand-logo">Logo</a>
      <ul id="nav-mobile" class="right hide-on-med-and-down">
        <li><a href="sass.html">Sass</a></li>
        <li><a href="badges.html">Components</a></li>
        <li><a href="collapsible.html">JavaScript</a></li>
      </ul>
    </div>
  </nav>
<!--
+"avatar_original": "https://graph.facebook.com/v2.8/100011445248152/picture?width=1920"
+"profileUrl": "https://www.facebook.com/app_scoped_user_id/1184180524968634/"
 -->
  <main class="grey lighten-4 valign-wrapper">
    <div class="container">

        <div class="card-panel">


          <div class="row valign-wrapper">
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

          <hr>

          <div class="row">
              <!-- Imagem do produto -->
              <div class="col s12 m6 offset-m3 l3" id="produto_img">
                <img style="width: 100%;" src="{{ route('getProductImage',[$tabProduct->id,'bcp_600x600.jpg']) }}">
              </div>
              <!-- Dados do produto -->
              <div class="col s12 m12 l9">
              <h4>{{ $tabProduct->name }}</h4>
              <ul class="">
              @foreach ($aFiltres as $sFilter)
                <li class="">{{ $sFilter[0] }}: {{ $sFilter[1] }}</li>
              @endforeach
              </ul>

              <div class="flow-text" style="min-height: 140px">

              </div>

              <div class="flow-text" style="font-size: 2em;">Valor: R$ {{ $nValor }}</div>
          </div>
        </div>

      </div>
    </div>
  </main>

  <footer class="grey darken-3">
    <div class="container">
      <div class="row">
        <div class="col l6 s12">
          <h5 class="white-text">Footer Content</h5>
          <p class="grey-text text-lighten-4">You can use rows and columns here to organize your footer content.</p>
        </div>
        <div class="col l4 offset-l2 s12">
          <h5 class="white-text">Links</h5>
          <ul>
            <li><a class="grey-text text-lighten-3" href="#!">Link 1</a></li>
            <li><a class="grey-text text-lighten-3" href="#!">Link 2</a></li>
          </ul>
        </div>
      </div>
    </div>
    <div class="footer-copyright">
      <div class="container">
        © {{ date('Y') }} gm.desenvolv
        <a class="grey-text text-lighten-4 right" href="#!">More Links</a>
      </div>
    </div>
  </footer>
</body>
</html>
