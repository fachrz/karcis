@extends('admin.layouts.AdminNav')

@section('pageTitle', 'Kereta Schedules')

@section('top-right-corner-button')
<!-- Button trigger modal -->
<button class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal"
    data-target="#scheduleinsert"><i class="fas fa-plus fa-sm text-white-50"></i> Insert Data</button>
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
                <h5 class="modal-title" id="exampleModalLabel">Insert Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ url('/admin/keretaschedules/add') }}" method="post" class="register-register-form">
                    @csrf
                    <fieldset class="register-input-container">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="station-from">From</label>
                                    <select class="form-control" name="station-from">
                                        <option disabled selected value="0">---Select Stations---</option>
                                        @foreach($stations as $st)
                                        <option value="{{ $st->id_station }}">{{$st->id_station}}</option>
                                        @endforeach
                                    </select> 
                                  </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="station-to">To</label>
                                    <select class="form-control" name="station-to">
                                        <option disabled selected value="0">---Select Stations---</option>
                                        @foreach($stations as $st)
                                        <option value="{{ $st->id_station }}">{{$st->id_station}}</option>
                                        @endforeach
                                    </select> 
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="aircraft-model">Train</label>
                                    <select class="form-control" name="kereta-train">
                                        <option disabled selected value="0">---Select Trains---</option>
                                        @foreach($trains as $tr)
                                        <option value="{{ $tr->train_id }}">{{$tr->train_id}}</option>
                                        @endforeach
                                    </select> 
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="departure-date">Departure Date</label>
                                    <input type="datetime-local" name="departure-date" class="form-control" id="departure-date"
                                        aria-describedby="emailHelp" placeholder="Masukan Tanggal keberangkatan"
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

<table class="table">
    <thead class="thead-dark">
        <tr>
            <th scope="col">ID</th>
            <th scope="col">From</th>
            <th scope="col">To</th>
            <th scope="col">Train</th>
            <th scope="col">Departure Date</th>
            <th scope="col">Option</th>
        </tr>
    </thead>
    <tbody>

        @foreach($schedules as $sc)
        <tr>
            <td>{{$sc->id_schedule}}</td>
            <td>{{$sc->station_from}}</td>
            <td>{{$sc->station_to}}</td>
            <td>{{$sc->train_id}}</td>
            <td>{{$sc->departure_date}}</td>
            <td>
                <a href="{{url('/admin/keretaschedules/delete/'.$sc->id_schedule)}}"><button type="button"
                        class="btn btn-danger"><i class="fas fa-trash-alt"></i></button> </a>
            </td>
        </tr>
        @endforeach


    </tbody>
</table>
@endsection
