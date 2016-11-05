<!DOCTYPE html>
<html lang="en">
    <head>
      <!-- Tell the browser to be responsive to screen width -->
      <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

      <link href="{{ asset("/css/materialize.css") }}" rel="stylesheet">
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

      <script scr="{{ asset("/js/materialize.js") }}"></script>
    </head>
    <body>
      <nav>
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
      </nav>
      <br>
      <div class="container">
        @yield('content')
      </div>
    </body>
</html>
