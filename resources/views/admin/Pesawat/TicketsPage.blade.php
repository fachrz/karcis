@extends('admin.layouts.AdminNav')

@section('pageTitle', 'Pesawat Tickets')
@section('top-right-corner-button')
<!-- Button trigger modal -->
<button class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal"
    data-target="#ticketsinsertmodal" id="ticketsInsert"><i class="fas fa-plus fa-sm text-white-50"></i> Insert Data</button>
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
                <button type="button" class="btn btn-info pesawat-btn-info" data-toggle="modal" data-target="#ticketsinfomodal" data-send="{{$ts->id_ticket}}"><i
                        class="fas fa-info"></i></button>
            </td>
        </tr>
        @endforeach

    </tbody>
</table>

<!-- Insert Modal -->
<div class="modal fade" id="ticketsinsertmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                <form action="{{ url('/admin/pesawattickets/add') }}" method="post" class="register-register-form">
                    @csrf
                    <fieldset class="register-input-container">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="id-tickets">ID Tickets</label>
                                    <input type="text" name="id-tickets" id="id-ticket" class="form-control"
                                        aria-describedby="emailHelp" readonly>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="airport-name">ID Schedules</label>
                                    <select class="form-control" id="airline-insert" name="id-schedule">
                                        <option disabled selected value="0">---Select Schedules---</option>
                                        @foreach($schedules as $sc)
                                        <option value="{{ $sc->id_schedule }}">{{$sc->flightData->airport_from}} --> {{$sc->flightData->airport_to}} ({{$sc->id_schedule}})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> 
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="location">Seat Class</label>
                                    <select class="form-control" name="seat-class">
                                        <option disabled selected value="">---Select Class---</option>
                                        <option value="economy">Economy</option>
                                        <option value="premeconomy">Premium Economy</option>
                                        <option value="bussiness">Bussiness</option>
                                        <option value="first">First</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="province">Karcis Point</label>
                                    <input type="text" name="karcis-point" class="form-control" placeholder="point"
                                        required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
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
                                    <label for="province">Premeconomy Quota</label>
                                    <input type="text" name="premeconomy-quota" class="form-control" placeholder="Premoeconomy Quota"
                                        required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="province">Bussiness Quota</label>
                                    <input type="text" name="bussiness-quota" class="form-control" placeholder="Bussiness Quota"
                                        required>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="province">First Quota</label>
                                    <input type="text" name="first-quota" class="form-control" placeholder="First Quota"
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
                        <td id="id-ticketinfo"></td>
                    <tr>
                        <td>ID schedule</td>
                        <td id="id-schedule"></td>
                    </tr>
                    <tr>
                        <td>Seat Class</td>
                        <td id="seat-class"></td>
                    </tr>
                    <tr>
                        <td>Karcis Point</td>
                        <td id="karcis-point"></td>
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
                        <td>Premeconomy Quota</td>
                        <td id="premeconomy-quota"></td>
                    </tr>
                    <tr>
                        <td>Bussiness Quota</td>
                        <td id="bussiness-quota"></td>
                    </tr>
                    <tr>
                        <td>First Quota</td>
                        <td id="first-quota"></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
