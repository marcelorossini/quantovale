<?php $aFacebook = ( Auth::check() ? facebook(Auth::user()->id) : null ) ?>

@if (Agent::isMobile())  <!-- facebook(Auth::user()->name)['picture_480'] -->
<ul id="slide-out" class="side-nav">
  <li><div class="userView">
    <div class="background red lighten-1">

    </div>
    @if (Auth::check())
    <a href="#!user"><img class="circle" src="{{ !is_null($aFacebook) ? $aFacebook['picture_480'] : '' }}"></a>
    <a href="#!name"><span class="white-text name">{{ Auth::user()->name }}</span></a>
    <a href="#!email"><span class="white-text email">{{ Auth::user()->email }}</span></a>
    @endif
  </div></li>
  @if (Auth::check())
  <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
      {{ csrf_field() }}
  </form>
  <li><a href="{{ url('/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="mdi mdi-logout-variant"  style="font-size: 2em;"></i> Logout</a></li>
  <!--
  <li><a href="#!"><i class="material-icons">cloud</i>First Link With Icon</a></li>
  <li><a href="#!">Second Link</a></li>
  <li><div class="divider"></div></li>
  <li><a class="subheader">Subheader</a></li>
  <li><a class="waves-effect" href="#!">Third Link With Waves</a></li>
-->
  @else
  <li><a href="{{ route('login') }}"><i class="mdi mdi-login" style="font-size: 2em;"></i> Entrar</a></li>
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
        <li><a href="#"><img src="{{ !is_null($aFacebook) ? $aFacebook['picture_480'] : '' }}" alt="" class="circle responsive-img"><br> {{ Auth::user()->name }}</a></li>
        @else
        <li><a href="{{ route('login') }}">Entre</a></li>
        @endif
      </ul>
    </div>
  </div>
</nav>
@endif
