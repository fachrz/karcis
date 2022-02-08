@extends('Mail.MailTemplate')

@section('title', 'Pengajuan Lupa Password')
    
@section('body')
    Halo Fachrurozi,
    <br>
    <br>

    <b>Sepertinya kamu lupa dengan password kamu.</b>
    <br>
    kamu bisa klik link dibawah ini untuk mengubah password kamu. link akan kadaluarsa dalam waktu 30 Menit.
    <br>
    <br>

    <a href="{{ url('reset-password?id=')}}{{ $forgot_id ?? '' }}">http://karcis.test/reset-password?id={{ $forgot_id ?? '' }}</a>

    <br>
@endsection