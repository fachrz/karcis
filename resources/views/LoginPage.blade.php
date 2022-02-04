@extends('layouts.BlankTemplate')

@section('pageTitle', 'Login Page')

@section('csslib')
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')

<div class="login-container">
<div class="login-box">
    <div>
      <p class="login-title text-center">Login to Karcis</p>
    </div>
    @if ($message = Session::get('error'))
      <div class="alert alert-danger alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button> 
          <strong>{{ $message }}</strong>
      </div>
    @endif
    {{-- <div class="login-third-party-login">
      <p class="login-button-info-text login-info-text text-center">EASILY USING</p>
      <div class="login-button-container container-fluid">
        <div class="row">
        <div class="col-sm">
           <button class="login-facebook login-button tpl-button" account-type="facebook">
           <span class="header-sprite login-fb-logo"></span>
            <!-- react-text: 78 -->FACEBOOK<!-- /react-text -->
        </button>
        </div>
        <div class="col-sm">
          <button class="login-google login-button tpl-button" account-type="google">
           <span class="header-sprite login-gplus-logo"></span>
              <!-- react-text: 81 -->GOOGLE<!-- /react-text -->
        </button>
        </div>
        </div>
      </div>
    </div> --}}
    {{-- <p class="login-info-text text-center">- OR USING EMAIL -</p> --}}
    <form action="{{ url('/auth') }}" method="post" class="login-login-form">
      @csrf
      <fieldset class="login-input-container">
        <div class="login-input-item">
          <input type="email" class="login-user-input-email login-user-input" name="email" placeholder="Your Email Address">
        </div>
        <div class="login-input-item">
          <input type="password" class="login-user-input-password login-user-input" name="password" placeholder="Enter Password">
        </div>
      </fieldset>
      <fieldset class="login-login-button-container">
        <input type="submit" name="" class="login-login-button" value="Login">
      </fieldset>
    </form>
    <div class="login-link-container">
      <a class="login-link" href="#">Forgot password?</a>
      <div class="login-right-links">
        <a class="login-create-account-link login-link" href="{{url('/register')}}">Create Account</a>
      </div>
    </div>
  </div>
</div>
@endsection