<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <link href="{{ asset("/css/materialize.css") }}" rel="stylesheet">
  <link href="{{ asset("/css/app.css") }}" rel="stylesheet">

  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="//cdn.materialdesignicons.com/1.7.22/css/materialdesignicons.min.css" rel="stylesheet">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="{{ asset("/js/materialize.js") }}"></script>

  <script src="{{ asset("/js/pickadate.js-3.5.6/lib/picker.js") }}"></script>
  <script src="{{ asset("/js/pickadate.js-3.5.6/lib/picker.date.js") }}"></script>
  <script src="{{ asset("/js/pickadate.js-3.5.6/lib/legacy.js") }}"></script>

  <!--
  <script src="{{ asset("/js/requirejs/require.js") }}"></script>
  <script src="{{ asset("/js/chart.js/chart.js") }}"></script>
  -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.6/Chart.js"></script>



</head>
<body id="main">
  <nav class="nav-extended orange lighten-1">
    <div class="row" style="padding: 0; margin: 0;">
      <div class="col s12 m12 l8 offset-l2">
        <div class="nav-wrapper">
          <div class="row" style="padding: 0; margin: 0;">
            <div class="col s11 m11 l11" style="padding: 0; margin: 0;">
              <ul class="tabs tabs-fixed-width tabs-transparent" style="margin-top: 8px">
                <li class="tab"><a class="active" href="#test1">PRODUTOS</a></li>
                <li class="tab disabled"><a href="#test2">CARROS</a></li>
                <li class="tab disabled"><a href="#test3">IMÓVEIS</a></li>
              </ul>
            </div>
            <div class="col s1 m1 l1" style="padding: 0; margin: 0;">
              <ul class="right">
                <li><a href="#"><i class="material-icons">more_vert</i></a></li>
              </ul>
            </div>
          </div>
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
  </nav>

  <main>
    <div class="container">
      @yield('content')
    </div>
  </main>

  <footer class="page-footer grey darken-3">
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
        © 2014 Copyright Text
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
