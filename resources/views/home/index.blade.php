<!DOCTYPE html>
<html lang="en">
<head>
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

  <!-- Pickdate -->
  <script src="{{ asset("/js/pickadate.js-3.5.6/lib/picker.js") }}"></script>
  <script src="{{ asset("/js/pickadate.js-3.5.6/lib/picker.date.js") }}"></script>
  <script src="{{ asset("/js/pickadate.js-3.5.6/lib/legacy.js") }}"></script>

  <!-- Tamanho dos cards -->
  <script src="{{ asset("/js/matchHeight/jquery.matchHeight.js") }}"></script>

  <!-- App -->
  <link href="{{ asset("/css/materialdesignicons.min.css") }}" media="all" rel="stylesheet" type="text/css" />
  <!--
  <script src="{{ asset("/js/requirejs/require.js") }}"></script>
  <script src="{{ asset("/js/chart.js/chart.js") }}"></script>
-->
<!-- Grafico -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.6/Chart.js"></script>
</head>
<body id="main" class="grey lighten-4">

  @if (Agent::isMobile())  <!-- facebook(Auth::user()->name)['picture_480'] -->
  <ul id="slide-out" class="side-nav">
    <li><div class="userView">
      <div class="background red lighten-1">

      </div>
      @if (Auth::check())
      <a href="#!user"><img class="circle" src="{{ facebook(Auth::user()->id)['picture_480'] }}"></a>
      <a href="#!name"><span class="white-text name">{{ Auth::user()->name }}</span></a>
      <a href="#!email"><span class="white-text email">{{ Auth::user()->email }}</span></a>
      @endif
    </div></li>
    @if (Auth::check())
    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>
    <li><a href="{{ url('/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="material-icons"><i class="mdi mdi-logout-variant"></i></i> Logout</a></li>
    <!--
    <li><a href="#!"><i class="material-icons">cloud</i>First Link With Icon</a></li>
    <li><a href="#!">Second Link</a></li>
    <li><div class="divider"></div></li>
    <li><a class="subheader">Subheader</a></li>
    <li><a class="waves-effect" href="#!">Third Link With Waves</a></li>
  -->
    @else
    <li><a href="{{ route('login') }}"><i class="material-icons">cloud</i>Entrar</a></li>
    @endif
  </ul>
  <script>
  $(document).ready(function(){
    $("#btnNav").sideNav();
  });
  </script>

  <nav class="nav-extended red lighten-1">
    <div style="padding: 0; margin: 0;">
      <div class="col s12 m12 l8 offset-l2">
        <div class="nav-wrapper">
          <div class="row" style="padding: 0; margin: 0;">
            <div class="col s1 m1 l1" style="padding: 0; margin: 0;">
              <ul class="center">
                <li><a href="#" id="btnNav" data-activates="slide-out"><i class="material-icons">menu</i></a></li>
              </ul>
            </div>
            <div class="col s11 m11 l11" style="padding: 0; margin: 0;">
              <ul class="tabs tabs-fixed-width tabs-transparent" style="margin-top: 8px">
                <li class="tab"><a class="active" href="#test1">PRODUTOS</a></li>
                <li class="tab disabled"><a href="#test2">CARROS</a></li>
                <li class="tab disabled"><a href="#test3">IMÓVEIS</a></li>
              </ul>
            </div>
          </div>
          <div class="container">
            <form method="POST" action="{!! route('postSearch') !!}">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <div class="input-field">
                <input name="product" id="search" type="search" value="" required>
                <label for="search"><i class="material-icons">search</i></label>
                <i class="material-icons">close</i>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </nav>
  @else
  <nav class="nav red lighten-1">
    <div class="row">
      <div class="col s12 m12 l2">
      </div>
      <div class="col s12 m12 l2">
        <ul id="nav-mobile">
          <li><a href="sass.html">PRODUTOS</a></li>
          <li><a href="badges.html">CARROS</a></li>
          <li><a href="collapsible.html">IMÓVEIS</a></li>
        </ul>
      </div>

      <div class="col s12 m12 l6">
        <div class="nav-wrapper">
          <form method="POST" action="{!! route('postSearch') !!}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="input-field">
              <input name="product" id="search" type="search" value="" required>
              <label for="search"><i class="material-icons">search</i></label>
              <i class="material-icons">close</i>
            </div>
          </form>
        </div>
      </div>

      <div class="col s12 m12 l1 offset-l1">
        <ul id="nav-mobile">
          @if (Auth::check())  <!-- facebook(Auth::user()->name)['picture_480'] -->
          <li><a href="#"><img src="{{ facebook(Auth::user()->id)['picture_480'] }}" alt="" class="circle responsive-img"><br> {{ Auth::user()->name }}</a></li>
          @else
          <li><a href="{{ route('login') }}">Entre</a></li>
          @endif
        </ul>
      </div>
    </div>
  </nav>
  @endif

  <main>
    <div class="container">
      @yield('content')
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

  <script>
  $('select').material_select();

  $('.datepicker').pickadate({
    selectMonths: true, // Creates a dropdown to control month
    selectYears: 15 // Creates a dropdown of 15 years to control year
  });
  </script>
</body>
</html>
