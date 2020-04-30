@extends('layouts.KeretaAuthTemplate')

@section('pageTitle', 'PeTik Online')

@section('content')
<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Train Name</th>
      <th scope="col">From</th>
      <th scope="col">To</th>
      <th scope="col">Departure Date</th>
      <th scope="col">Seat Class</th>
      <th scope="col">Price</th>
      <th scope="col">Option</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($tiketresult as $tiket)
    <tr>
      <th scope="row">1</th>
        <td>{{ $tiket->scheduleData->trainData->train_name}}</td>
        <td>{{ $tiket->scheduleData->stationFromData->id_station}}</td>
        <td>{{ $tiket->scheduleData->stationToData->id_station}}</td>
        <td>{{ $tiket->scheduleData->departure_date}}</td>
        <td>{{ $tiket->seat_class }}</td>
        <td>Rp. {{ number_format($tiket->price,2,',','.') }}</td>

        <td><button type=" button" class="btn btn-primary choose-button" data-href="{{ $tiket->id_ticket }}">Choose</button></td>
      </tr>
      @endforeach
  </tbody>
</table>
@endsection