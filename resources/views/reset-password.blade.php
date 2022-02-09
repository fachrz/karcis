@extends('layouts.BlankTemplate')

@section('pageTitle', 'Forgot Password')

@section('csslib')
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')

<div class="login-container">
<div class="login-box">
    <div>
      <p class="login-title text-center">Reset Password</p>
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
    
    <form action="{{ url('/reset-password') }}" method="post" class="login-login-form">
      @csrf
      <div class="login-input-container">
        <div class="form-group">
          <input type="text" name="forgot_id" value="{{ $reset_id }}" readonly hidden>
          <label for="new_password">New Password</label>
          <input type="password" class="form-control login-input-item" name="new_password" placeholder="Your New Password">
          <small class="login-input-error">
            @error('new_password')
              {{ $message }}
            @enderror
          </small>
        </div>
        <div class="form-group">
            <label for="confirm_new_password">Confirm New Password</label>
            <input type="password" class="form-control login-input-item" name="confirm_new_password" placeholder="Confirm New Password">
            <small class="login-input-error">
              @error('confirm_new_password')
                {{ $message }}
              @enderror
            </small>
          </div>
      </div>
      <div class="login-login-button-container">
        <input type="submit" name="" class="login-login-button" value="Ubah Password">
      </div>
    </form>
  </div>
</div>
@endsection