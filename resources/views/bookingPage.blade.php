@extends('layouts.Authtemplate')

@section('pageTitle', 'PeTik Online')

@section('content')
<div class="container booking-container">
    <div class="card petik-infobar">
    <div class="card-body">
        <h5 class="card-title">Penerbangan dari {{ $bookingdata->from }} -> {{ $bookingdata->to }}</h5>
    </div>
    </div>
  <div class="row no-gutters">
    <div class="col-sm">
        <div class="card">
        <h5 class="card-header">{{ $bookingdata->from }} -> {{ $bookingdata->to }}</h5>
        <div class="card-body">
            <p>{{ date('d F Y', strtotime($bookingdata->departure_date)) }}</p>
            <h5 class="card-title">{{ $bookingdata->airplane->airline }} {{ $bookingdata->airplane->airline_id }}</h5>
            <p>{{ $bookingdata->seat_class }} Class</p>
        </div>
        </div>
    </div>
    <div class="col-4">
        <div class="card pricing-details">
            <h5 class="card-header">Ringkasan Harga</h5>
            <div class="card-body pricing-details-body">
                <div class="row no-gutters">
                    <div class="col-12 col-sm-6 col-md-8">{{ $bookingdata->airplane->airline }} (Dewasa) x1</div>
                    <div class="col-6 col-md-4">Rp. {{ number_format($bookingdata->price,2,',','.') }}</div>
                </div>
                <div class="row no-gutters pricing-total">
                    <div class="col-12 col-sm-6 col-md-8">Total</div>
                    <div class="col-6 col-md-4">Rp. {{ number_format($bookingdata->price,2,',','.')}}</div>
                </div>
            </div>
            <a class="btn btn-primary booking-button" href="/order/{{ $bookingdata->id_tiket }}">Booking Ticket</a>
        </div>
  </div>
</div>

@endsection