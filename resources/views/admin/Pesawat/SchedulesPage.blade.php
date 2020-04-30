@extends('Admin.Layouts.AdminNav')

@section('pageTitle', 'Pesawat Schedules')

@section('top-right-corner-button')
<!-- Button trigger modal -->
    <div>
        <button class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal"
    data-target="#scheduleinsert"><i class="fas fa-plus fa-sm text-white-50"></i> Add Schedule</button>
    </div>
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
<div class="modal fade" id="scheduleinsert" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Schedule Insert</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ url('/admin/pesawat/schedules') }}" method="post" class="register-register-form">
                    @csrf
                    <fieldset class="register-input-container">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="aircraft-registry">Airlines</label>
                                    <select class="form-control" id="airline-insert" name="airline">
                                        <option disabled selected value="0">Select Airlines</option>
                                        @forelse($airlines as $al)
                                        <option value="{{ $al->airline_id }}">{{$al->airline_name}}</option>
                                        @empty
                                        <option>Airline Data Notfound</option>
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="flight-number">Aircraft Registry</label>
                                    <select class="form-control" id="aircraft-insert" name="aircraft-registry">
                                        <option disabled selected value="0">---Select Registry---</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="flight-number">Flight Number</label>
                                    <select class="form-control" id="flight-insert" name="flight-number">
                                        <option disabled selected value="0">---Select Flight Number---</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="departure-date">Departure Date</label>
                                    <input type="datetime-local" class="form-control" id="insert-datepicker"
                                        aria-describedby="emailHelp" placeholder="Ex. 2020-02-02 19:18:44" required
                                        autocomplete="off" name="departure-date">
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

<table class="table">
    <thead class="thead-dark">
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Aircraft Reg.</th>
            <th scope="col">Flight Num.</th>
            <th scope="col">Departure Date</th>
        </tr>
    </thead>
    <tbody>

        @php
        $no = 1;
        @endphp
        @foreach($schedules as $sc)
        <tr>
            <td>{{$sc->id_schedule}}</td>
            <td>{{$sc->aircraft_registry}}</td>
            <td>{{$sc->flight_number}}</td>
            <td>{{$sc->departure_date}}</td>
        </tr>
        @endforeach


    </tbody>
</table>

<!--Update Modal -->
<div class="modal fade" id="schedulesupdatemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Schedule Update</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form action="{{ url('/admin/pesawatschedules/edit') }}" method="post" class="register-register-form">
                    @csrf
                    <fieldset class="register-input-container">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <input type="text" name="id-schedule" id="id-schedule" hidden readonly>
                                    <label for="aircraft-registry">Airlines</label>
                                    <select class="form-control" id="airline-update" name="airline-update">
                                        <option disabled selected value="0">---Select Airlines---</option>
                                        @foreach($airlines as $al)
                                        <option value="{{ $al->airline_id }}">{{$al->airline_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="flight-number">Aircraft Registry</label>
                                    <select class="form-control" id="aircraft-update" name="aircraft-registry">
                                        <option disabled selected value="0">---Select Registry---</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="flight-number">Flight Number</label>
                                    <select class="form-control" id="flight-update" name="flight-number">
                                        <option disabled selected value="0">---Select Flight Number---</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="departure-date">Departure Date</label>
                                    <input type="datetime-local" class="form-control"
                                        aria-describedby="emailHelp" id="departure-update" placeholder="Ex. 2020-02-02 19:18:44" required
                                        autocomplete="off" name="departure-date">
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="economy_quota">Economy Quota</label>
                                    <input type="number" id="economyupdate" name="economy-quota" class="form-control"
                                        placeholder="Kuota Kelas Ekonomi" required>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="premeconomy_quota">PremEconomy Quota</label>
                                    <input type="number" id="premeconomyupdate" name="premeconomy-quota" class="form-control"
                                        aria-describedby="emailHelp" placeholder="Kuota Kelas PremEconomy" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="bussiness_quota">Bussiness Quota</label>
                                    <input type="number" id="bussinessupdate" name="bussiness-quota" class="form-control"
                                        placeholder="Kuota Kelas Bisnis" required>
                                </div>

                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="first-quota">First Quota</label>
                                    <input type="number" id="firstupdate" name="first-quota" class="form-control"
                                        aria-describedby="emailHelp" placeholder="Kuota Kelas Pertama" required>
                                </div>
                            </div>
                        </div>
                    </fieldset>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save Change</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
