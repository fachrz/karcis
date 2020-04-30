@extends('admin.layouts.AdminNav')

@section('pageTitle', 'Pesawat Flights')

@section('top-right-corner-button')
<!-- Button trigger modal -->
<button class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal"
    data-target="#flightinsert"><i class="fas fa-plus fa-sm text-white-50"></i> Insert Data</button>
@endsection
@section('content')
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
<!-- Modal -->
<div class="modal fade" id="flightinsert" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Flights Insert</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ url('/admin/pesawatflights/add') }}" method="post" class="register-register-form">
                    @csrf
                    <fieldset class="register-input-container">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="aircraft-registry">Airlines</label>
                                    <select class="form-control" id="airline-flights" name="airline-flight">
                                        <option disabled selected value="0">---Select Airlines---</option>
                                        @foreach($airlines as $al)
                                        <option value="{{ $al->airline_id }}">{{$al->airline_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="iata-code">IATA Code</label>
                                    <input type="text" name="iata-code-flight" id="iata-code-insert" class="form-control"
                                        placeholder="IATA Code" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="flight-number">Flight Number</label>
                                    <input type="number" name="flight-number-flight" class="form-control"
                                        placeholder="Flight Number" required>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="departure-date">From</label>
                                    <select class="form-control" name="airport-from-flight">
                                        <option disabled selected value="0">---Select Airports---</option>
                                        @foreach($airports as $ar)
                                        <option value="{{ $ar->id_airport }}">{{$ar->id_airport}}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="economy_quota">To</label>
                                    <select class="form-control" name="airport-to-flight">
                                        <option disabled selected value="0">---Select Airports---</option>
                                        @foreach($airports as $ar)
                                        <option value="{{ $ar->id_airport }}">{{$ar->id_airport}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                            
                            </div>
                        </div>
                    </fieldset>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Insert</button>
                </form>
            </div>
        </div>
    </div>
</div>

<table class="table">
    <thead class="thead-dark">
        <tr>
            <th scope="col">Flight Number</th>
            <th scope="col">From</th>
            <th scope="col">To</th>
            <th scope="col">Airline</th>
            <th scope="col">Options</th>
        </tr>
    </thead>
    <tbody>

        @foreach($flights as $fl)
        <tr>
            <td>{{$fl->flight_number}}</td>
            <td>{{$fl->airport_from}}</td>
            <td>{{$fl->airport_to}}</td>
            <td>{{$fl->airlineData->airline_name}}</td>
            <td>
                <a href=" {{url('/admin/pesawatflights/delete/'.$fl->flight_number)}} " class=""><button type="button"
                        class="btn btn-danger"><i class="fas fa-trash-alt"></i></button></a>
            </td>
        </tr>
        @endforeach


    </tbody>
</table>
@endsection
