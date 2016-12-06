<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Jquery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="{{ asset("/js/materialize.js") }}"></script>

<!-- App -->
<link href="{{ asset("/css/materialize.css") }}" rel="stylesheet">
<link href="{{ asset("/css/app.css") }}" rel="stylesheet">

<!-- Ajax -->
<script src="{{ asset("/js/ajax/jquery.form.js") }}"></script>

<!-- Fontes -->
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<!-- Icones -->
<link href="{{ asset("/css/materialdesignicons.min.css") }}" media="all" rel="stylesheet" type="text/css" />

<!-- Scripts -->
<!--<script src="{{ asset("/js/app.js") }}"></script>-->

<!-- Tamanho dos cards -->
<script src="{{ asset("/js/matchHeight/jquery.matchHeight.js") }}"></script>

<script src="{{ asset("/js/helpers.js") }}"></script>

<script>
    window.Laravel = <?php echo json_encode([
        'csrfToken' => csrf_token(),
    ]); ?>
</script>
