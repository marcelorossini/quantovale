@extends("auth.app")

@section("content")
<center>
  <img class="responsive-img" style="width: 250px;" src="" />

  <h5 class="red-text">Faça o login ou cadastre-se</h5>

</center>
<div class="container">
  <div class="z-depth-1 white row" style="padding: 1.5em;">

    <form class="col s12" role="form" method="POST" action="{{ url('/login') }}">
      {{ csrf_field() }}
      <div class="row">
        <div class="input-field col s12">
          <input class="validate" type="email" name="email" id="email"  value="{{ old('email') }}" required autofocus/>
          @if ($errors->has('email'))
          <span class="help-block">
            <strong>{{ $errors->first('email') }}</strong>
          </span>
          @endif

          <label for="email">E-mail</label>
        </div>
      </div>

      <div class="row">
        <div class="input-field col s12">
          <input class="validate" type="password" name="password" id="password" required/>
          @if ($errors->has('password'))
          <span class="help-block">
            <strong>{{ $errors->first('password') }}</strong>
          </span>
          @endif

          <label for="password">Senha</label>
        </div>
        <label style="float: right;">
          <a class="grey-text" href="#!"><b>Esqueceu a senha?</b></a>
        </label>
      </div>

      <br />
      <center>
        <div class="row">
          <button type="submit" name="btn_login" class="col s12 btn btn-large waves-effect red lighten-1">Login</button>
        </div>
        <div class="row">
          <a href="{{ route('getFacebookRedirect') }}" class="col s12 btn btn-large waves-effect indigo"><i class="mdi mdi-facebook-box"></i> Facebook Login</a>
        </div>
      </center>
    </form>
  </div>
</div>
<center>
  <a href="{{ url('/register') }}">Crie sua conta</a>
</center>
@endsection
