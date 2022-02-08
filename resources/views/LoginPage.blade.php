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
    @if ($message = Session::get('Error'))
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
    <form action="{{ url('/login') }}" method="post" class="login-login-form">
      @csrf
      
      <div class="login-input-container">
        <div class="">
          
        </div>
        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" class="form-control login-input-item" name="email" placeholder="Your Email Address">
          <small class="login-input-error">
            @error('email')
              {{ $message }}
            @enderror
          </small>
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" class="form-control login-input-item" name="password" placeholder="Enter Password">
          <small class="login-input-error">
            @error('password')
              {{ $message }}
            @enderror
          </small>
        </div>
      </div>
      <div class="login-login-button-container">
        <input type="submit" name="" class="login-login-button" value="Login">
      </div>
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