@extends("auth.app")

@section("content")
<center>
  <img class="responsive-img" style="width: 250px;" src="" />

  <h5 class="red-text">Preencha os dados abaixo</h5>

</center>
<div class="container">
  <div class="z-depth-1 white row" style="padding: 1.5em;">

    <form class="col s12" role="form" method="POST" action="{{ url('/register') }}">
      {{ csrf_field() }}
      <div class="row">
        <div class="input-field col s12">
          <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
          @if ($errors->has('name'))
              <span class="help-block">
                  <strong>{{ $errors->first('name') }}</strong>
              </span>
          @endif
          <label for="email">Nome</label>
        </div>
      </div>

      <div class="row">
        <div class="input-field col s12">
          <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
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
          <input id="password" type="password" class="form-control" name="password" required>
          @if ($errors->has('password'))
              <span class="help-block">
                  <strong>{{ $errors->first('password') }}</strong>
              </span>
          @endif
          <label for="email">Senha</label>
        </div>
      </div>

      <div class="row">
        <div class="input-field col s12">
          <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
          @if ($errors->has('password_confirmation'))
              <span class="help-block">
                  <strong>{{ $errors->first('password_confirmation') }}</strong>
              </span>
          @endif
          <label for="email">Confirme a senha</label>
        </div>
      </div>

      <br />
      <center>
        <div class="row">
          <button type="submit" name="btn_login" class="col s12 btn btn-large waves-effect red lighten-1">Continuar</button>
        </div>
        <div class="row">
          <a href="{{ route('getFacebookRedirect') }}" class="col s12 btn btn-large waves-effect indigo"><i class="mdi mdi-facebook-box"></i> Facebook Login</a>
        </div>
      </center>
    </form>
  </div>
</div>
<center>
  <a href="{{ url('/login') }}">Faça o login</a>
</center>
@endsection
