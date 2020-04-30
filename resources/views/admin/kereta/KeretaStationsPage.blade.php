@extends('admin.layouts.AdminNav')

@section('pageTitle', 'Kereta Stations')
@section('top-right-corner-button')
  <!-- Button trigger modal -->
<button class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#airportsinsert"><i class="fas fa-plus fa-sm text-white-50"></i> Insert Data</button>
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
<div class="modal fade" id="airportsinsert" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Insert Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form action="{{ url('/admin/keretastations/add') }}" method="post" class="register-register-form">
      @csrf
      <fieldset class="register-input-container">
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="id-airport">ID Station</label>
                    <input type="text" name="id-station" class="form-control" id="id-airport" aria-describedby="emailHelp" placeholder="ID station" required>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="airport-name">Station Name</label>
                    <input type="text" name="station-name" class="form-control" id="airport-name" placeholder="Station Name" required>
                </div>
            </div>
        </div>
        <div class="row">
        <div class="col">
                <div class="form-group">
                    <label for="location">Location</label>
                    <input type="text" name="location" class="form-control" id="location" aria-describedby="emailHelp" placeholder="Locaton" required>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="province">Province</label>
                    <input type="text" name="province" class="form-control" id="province" placeholder="Province" required>
                </div>
            </div>
        </div>
      </fieldset>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Insert Data</button>
        </form>
      </div>
    </div>
  </div>
</div>

    <table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">#</th>
      <th scope="col">ID Station</th>
      <th scope="col">Station Name</th>
      <th scope="col">Location</th>
      <th scope="col">Province</th>
      <th scope="col">Options</th>
    </tr>
  </thead>
  <tbody>
  
    @php
        $no = 1;
    @endphp
    @foreach($stations as $st)
    <tr>
      <th scope="row">{{$no++}}</th>
      <td>{{$st->id_station}}</td>
      <td>{{$st->station_name}}</td>
      <td>{{$st->location}}</td>
      <td>{{$st->province}}</td>
      <td>
        <a href="{{url('/admin/keretastations/delete/'.$st->id_station)}}"><button type="button" class="btn btn-danger" ><i class="fas fa-trash-alt"></i></button>
        </a>
      </td>
    </tr>
    @endforeach
    
  </tbody>
</table>
@endsection