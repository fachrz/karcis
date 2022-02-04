@extends('layouts.BlankTemplate')

@section('pageTitle', 'Register Page')

@section('csslib')
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')

<div class="register-container">
<div class="register-box">
    <div>
      <p class="register-title text-center">Register to Karcis</p>
    </div>

    @if ($message = Session::get('Success'))
      <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button> 
          <strong>{{ $message }}</strong>
      </div>
    @endif

    @if ($message = Session::get('Error'))
      <div class="alert alert-danger alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button> 
          <strong>{{ $message }}</strong>
      </div>
    @endif

    {{-- <div class="register-third-party-register">
      <p class="register-button-info-text register-info-text text-center">EASILY USING</p>
      <div class="register-button-container container-fluid">
        <div class="row">
        <div class="col-sm">
           <button class="register-facebook register-button tpl-button" account-type="facebook">
           <span class="header-sprite register-fb-logo"></span>
            <!-- react-text: 78 -->FACEBOOK<!-- /react-text -->
        </button>
        </div>
        <div class="col-sm">
          <button class="register-google register-button tpl-button" account-type="google">
           <span class="header-sprite register-gplus-logo"></span>
              <!-- react-text: 81 -->GOOGLE<!-- /react-text -->
        </button>
        </div>
        </div>
      </div>
    </div> --}}
    {{-- <p class="register-info-text text-center">- OR USING EMAIL -</p> --}}
    <form action="{{ url('/registerrequest') }}" method="post" class="register-register-form">
      @csrf
      <div class="register-input-container">
        <div class="form-group">
          <label for="email">Email address</label>
          <input type="email" name="email" class="form-control register-input-item" id="email" aria-describedby="emailHelp" placeholder="Masukan Email" required>
        </div>

        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" name="password" class="form-control register-input-item" id="password" placeholder="Masukan Nama" required>
        </div>

        <div class="form-group">
          <label for="first-name">First Name</label>
          <input type="text" name="first-name" class="form-control register-input-item" id="first-name" aria-describedby="emailHelp" placeholder="Masukan Nama Depan" required>
        </div>

        <div class="form-group">
          <label for="last-name">Last Name</label>
          <input type="text" name="last-name" class="form-control register-input-item" id="last-name" placeholder="Masukan Nama Belakang" required>
        </div>

        <div class="form-group">
          <label for="no-telp">No Telepon</label>
          <input type="text" name="telp" class="form-control register-input-item" id="no-telp" placeholder="Masukan Nomor Telepon" required>
        </div>
      </div>
      <fieldset class="register-register-button-container">
        <input type="submit" class="register-register-button" value="Register">
      </fieldset>
    </form>
    <p style="text-align: center;">Already have an account? <a href="{{ url('/login') }}">Back to Login</a> </p>
  </div>
</div>
@endsection