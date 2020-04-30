@extends('admin.layouts.AdminNav')

@section('pageTitle', 'Kereta Tickets')
@section('top-right-corner-button')
<!-- Button trigger modal -->
<button class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal"
    data-target="#keretaticketsinsertmodal" id="keretaticketsinsert"><i class="fas fa-plus fa-sm text-white-50"></i> Insert Data</button>
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

<table class="table">
    <thead class="thead-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col">ID Tickets</th>
            <th scope="col">ID Schedule</th>
            <th scope="col">Seat Class</th>
            <th scope="col">Price</th>
            <th scope="col">Options</th>
        </tr>
    </thead>
    <tbody>

        @php
        $no = 1;
        @endphp
        @foreach($tickets as $ts)
        <tr>
            <th scope="row">{{$no++}}</th>
            <td>{{$ts->id_ticket}}</td> 
            <td>{{$ts->id_schedule}}</td>
            <td>{{ ucfirst($ts->seat_class)}}</td>
            <td>Rp. {{ number_format($ts->price,2,',','.') }}</td>
            <td>
                <button type="button" class="btn btn-info kereta-btn-info" data-toggle="modal" data-target="#ticketsinfomodal" data-send="{{$ts->id_ticket}}"><i
                        class="fas fa-info"></i></button>
            </td>
        </tr>
        @endforeach

    </tbody>
</table>

<!-- Insert Modal -->
<div class="modal fade" id="keretaticketsinsertmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Insert Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ url('/admin/keretatickets/add') }}" method="post" class="register-register-form">
                    @csrf
                    <fieldset class="register-input-container"> 
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="id-tickets">ID Tickets</label>
                                    <input type="text" id="id-ticket" name="id-tickets" class="form-control"
                                        aria-describedby="emailHelp" placeholder="Ticket ID" readonly>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="airport-name">ID Schedules</label>
                                    <select class="form-control" id="airline-insert" name="id-schedule">
                                        <option disabled selected value="0">---Select Schedules---</option>
                                        @foreach($schedules as $sc)
                                        <option value="{{ $sc->id_schedule }}">{{$sc->station_to}} --> {{$sc->station_from}} ({{$sc->id_schedule}})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> 
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="location">Seat Class</label>
                                    <input type="text" name="seat-class" class="form-control" aria-describedby="emailHelp"
                                        placeholder="seat class" required>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="province">Price</label>
                                    <input type="text" name="price" class="form-control" placeholder="price"
                                        required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="province">Economy Quota</label>
                                    <input type="text" name="economy-quota" class="form-control" placeholder="Economy Quota"
                                        required>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="province">Bussiness Quota</label>
                                    <input type="text" name="bussiness-quota" class="form-control" placeholder="Bussiness Quota"
                                        required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="province">Executive Quota</label>
                                    <input type="text" name="executive-quota" class="form-control" placeholder="Executive Quota"
                                        required>
                                </div>
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

<!-- Update Modal -->
<div class="modal fade" id="airportsupdatemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ url('/admin/pesawatairports/edit') }}" method="post" class="register-register-form">
                    @csrf
                    <fieldset class="register-input-container">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="id-airport">IATA Code</label>
                                    <input type="text" name="id-airport" class="form-control" id="id-airport"
                                        aria-describedby="emailHelp" placeholder="IATA Code" readonly required>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="airport-name">Airport Name</label>
                                    <input type="text" name="airport-name" class="form-control" id="airport-name"
                                        placeholder="Airport Name" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="location">Location</label>
                                    <input type="text" name="location" class="form-control" id="location"
                                        aria-describedby="emailHelp" placeholder="Locaton" required>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="province">Province</label>
                                    <input type="text" name="province" class="form-control" id="province"
                                        placeholder="Province" required>
                                </div>
                            </div>
                        </div>
                    </fieldset>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Info Modal -->
<div class="modal fade" id="ticketsinfomodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Info Modal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table border="1" style="padding: 10px">
                    <tr>
                        <td>ID Tiket</td>
                        <td id="id-ticket"></td>
                    <tr>
                        <td>ID schedule</td>
                        <td id="id-schedule"></td>
                    </tr>
                    <tr>
                        <td>Seat Class</td>
                        <td id="seat-class"></td>
                    </tr>
                    <tr>
                        <td>price</td>
                        <td id="price"></td>
                    </tr>
                    <tr>
                        <td>Economy Quota</td>
                        <td id="economy-quota"></td>
                    </tr>
                    <tr>
                        <td>Bussiness Quota</td>
                        <td id="bussiness-quota"></td>
                    </tr>
                    <tr>
                        <td>Executive Quota</td>
                        <td id="executive-quota"></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
