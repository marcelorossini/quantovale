<!DOCTYPE html>
<html lang="en">
<head>

  @include('layouts.headg')

</head>
<body>
  <main class="grey lighten-4">
    <div class="row">
      <div class="col s12 m8 offset-m2 l6 offset-l3">
        @yield('content')
      </div>
    </div>
  </main>
</body>
</html>
