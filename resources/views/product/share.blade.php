<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Facebook -->
  <meta property="og:url"           content="{{ url()->full() }}"/>
  <meta property="og:type"          content="website" />
  <meta property="og:title"         content="QuantoVale: {{ $tabProduct->name }}" />
  <meta property="og:description"   content="{{ $tabProduct->name }}" />
  <meta property="og:image"         content=""/>
</head>
<body>
{{ $tabUsuario->name }}
{{ $tabProduct->name }}

@foreach ($aFiltres as $sFilter)
<div>
  {{ $sFilter[0] }}: {{ $sFilter[1] }}
</div>
@endforeach

R$ {{ $nValor }}

</body>
</html>
