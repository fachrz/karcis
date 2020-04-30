@extends('layouts.AuthTemplate')

@section('pageTitle', 'Karcis - Beli Tiket Online')

@section('content')
<div class="table-responsive">
<table class="table">
  <thead>
    <tr> 
      <th scope="col">#</th>
      <th scope="col">Id Order</th>
      <th scope="col">From</th>
      <th scope="col">To</th>
      <th scope="col">Schedule Date</th>
      <th scope="col">Pulang Pergi</th>
      <th scope="col">Status</th>
      <th scope="col">Option</th>

    </tr>
  </thead>
  <tbody>
    @foreach($pesawatHistory as $ph)
    <tr>
      <th scope="row">1</th>
      <td>{{$ph->id_order}}</td>
      <td>{{$ph->ticketData->scheduleData->flightData->airportFromData->airport_name}}
        ({{$ph->ticketData->scheduleData->flightData->airport_from}})
      </td>
      <td>{{$ph->ticketData->scheduleData->flightData->airportToData->airport_name}}
      ({{$ph->ticketData->scheduleData->flightData->airport_to}})
      </td>
      <td>{{$ph->ticketData->scheduleData->departure_date}}</td>
      @if($ph->id_ticket2 != null)
        <td>Yes</td>
      @else
        <td>No</td>
      @endif
      <td>
          Dibayar
      </td>
      <td>
        <a href="{{ url('/historyorder/delete/'.$ph->id_order) }}"><button type="button" class="btn btn-primary">Batalkan Pemesanan</button></a>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
</div>
@endsection