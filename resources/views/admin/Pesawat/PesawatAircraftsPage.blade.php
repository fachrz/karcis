@extends('admin.layouts.AdminNav')

@section('pageTitle', 'Pesawat Aircrafts')
@section('top-right-corner-button')
  <!-- Button trigger modal -->
<button class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#aircraftsinsert"><i class="fas fa-plus fa-sm text-white-50"></i> Insert Data</button>
@endsection
@section('content')
<!-- Modal -->
<div class="modal fade" id="aircraftsinsert" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Insert Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form action="{{ url('/admin/pesawataircrafts/add') }}" method="post" class="register-register-form" enctype="multipart/form-data">
      @csrf
      <fieldset class="register-input-container">
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="aircraft-registry">Aircraft Registry</label>
                    <input type="text" name="aircraft-registry" class="form-control" aria-describedby="emailHelp" placeholder="Masukan Nomor Registrasi Pesawat" required>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="airline">Airline</label>
                    <!-- <input type="text" name="airline" class="form-control" placeholder="Masukan Nama Maskapai" required> -->
                    <select class="form-control" id="exampleFormControlSelect1" name="airline-id">
                      <option disabled selected value="0">---Select Airlines---</option>
                      @foreach($airlines as $al)
                        <option value="{{ $al->airline_id }}">{{$al->airline_name}}</option>
                      @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
        <div class="col">
                <div class="form-group">
                    <label for="nationality">Nationality</label>
                    <input type="text" name="nationality" class="form-control" aria-describedby="emailHelp" placeholder="Masukan Negara pengelola Pesawat" required>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="aircraft-model">Aircraft Model</label>
                    <input type="text" name="aircraft-model" class="form-control" placeholder="Masukan Model Pesawat" required>
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
      <th scope="col">Aircraft Registry</th>
      <th scope="col">Airline</th>
      <th scope="col">Nationality</th>
      <th scope="col">Aircraft Model</th>
    </tr>
  </thead>
  <tbody>
  
    @php
        $no = 1;
    @endphp
    @foreach($aircrafts as $ac)
    <tr>
      <th scope="row">{{$no++}}</th>
      <td>{{$ac->aircraft_registry}}</td>
      <td>{{$ac->airlinesData->airline_name}}</td>
      <td>{{$ac->nationality}}</td>
      <td>{{$ac->aircraft_model}}</td>
    </tr>
    @endforeach
    
  </tbody>
</table>

<!-- Update Modal -->
<div class="modal fade" id="aircraftsupdatemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form action="{{ url('/admin/pesawataircrafts/edit') }}" method="post" class="register-register-form">
      @csrf
      <fieldset class="register-input-container">
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="aircraft-registry">Aircraft Registry</label>
                    <input type="text" readonly name="aircraft-registry" class="form-control" id="aircraft-registry" aria-describedby="emailHelp" placeholder="Masukan Nomor Registrasi Pesawat" required>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="airline">Airline</label>
                    <select class="form-control" id="airline-id" name="airline-id">
                      <!-- airline list -->
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
        <div class="col">
                <div class="form-group">
                    <label for="nationality">Nationality</label>
                    <input type="text" name="nationality" class="form-control" id="nationality" aria-describedby="emailHelp" placeholder="Masukan Negara pengelola Pesawat" required>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="aircraft-model">Aircraft Model</label>
                    <input type="text" name="aircraft-model" class="form-control" id="aircraft-model" placeholder="Masukan Model Pesawat" required>
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
@endsection