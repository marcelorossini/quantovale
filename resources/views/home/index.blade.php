<!DOCTYPE html>
<html lang="en">
<head>

  @include('layouts.headg')
  @include('home.head')

</head>
<body id="main" class="grey lighten-4">

  @include('layouts.header')

  <main>
    <div class="container">
      @yield('content')
    </div>
  </main>

  @include('layouts.footer')

  <script>
  // Chama o modal de compartilhamento
  $(document).ready(function(){
    $('select').material_select();

    $('.modal').modal();

    $('.tooltipped').tooltip({delay: 50});

    $('.date_3').pickadate({
      selectMonths: true, // Creates a dropdown to control month
      selectYears: 15 // Creates a dropdown of 15 years to control year
    });

  });
  </script>
</body>
</html>
