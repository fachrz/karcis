@extends('layouts.BlankTemplate')

@section('pageTitle', 'Forgot Password')

@section('csslib')
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')

<div class="login-container">
<div class="login-box">
    <div>
      <p class="login-title text-center">Forgot Password</p>
    </div>
    @if ($message = Session::get('success'))
      <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button> 
          <strong>{{ $message }}</strong>
      </div>
    @endif

    @if ($message = Session::get('error'))
      <div class="alert alert-danger alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button> 
          <strong>{{ $message }}</strong>
      </div>
    @endif
    
    <form action="{{ url('/forgot') }}" method="post" class="login-login-form">
      @csrf
      <div class="login-input-container">
        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" class="form-control login-input-item" name="email" placeholder="Your Email Address">
          <small class="login-input-error">
            @error('email')
              {{ $message }}
            @enderror
          </small>
        </div>
      </div>
      <div class="login-login-button-container">
        <input type="submit" name="" class="login-login-button" value="Send Email">
      </div>
    </form>
  </div>
</div>
@endsection