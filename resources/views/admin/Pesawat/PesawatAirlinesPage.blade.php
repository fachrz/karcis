@extends('admin.layouts.AdminNav')

@section('pageTitle', 'Pesawat Airlines')
@section('top-right-corner-button')
  <!-- Button trigger modal -->
<button class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#airportsinsertmodal"><i class="fas fa-plus fa-sm text-white-50"></i> Insert Data</button>
@endsection
@section('content')
<!-- Insert Modal -->
<div class="modal fade" id="airportsinsertmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Insert Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form action="{{ url('/admin/pesawatairlines/add') }}" method="post" class="register-register-form" enctype="multipart/form-data">
      @csrf
      <fieldset class="register-input-container">
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="airline-name">Airline name</label>
                    <input type="text" name="airline-name" class="form-control" aria-describedby="emailHelp" placeholder="Nama Maskapai" required>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="airline-code1">IATA Code</label>
                    <input type="text" name="iata-code" class="form-control"  placeholder="Kode Maskapai" required>
                </div>
            </div>
        </div>
        <div class="row">
        <div class="col">
                <div class="form-group">
                    <label for="airline-code2">ICAO Code</label>
                    <input type="text" name="icao-code" class="form-control"  aria-describedby="emailHelp" placeholder="Kode Maskapai 2" required>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="province">Logo</label>
                    <input type="file" name="airline-logo" id="logo-insert" placeholder="Logo" required>
                </div>
            </div>
        </div>
        <div class="row">
        <div class="col">
                <div class="form-group">
                    <label for="province">Logo</label>
                    <input type="file" name="eticket-logo" id="logo-insert" placeholder="Logo" required>
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
      <th scope="col">Airline Name</th>
      <th scope="col">Logo</th>
      <th scope="col">IATA</th>
      <th scope="col">ICAO</th>
      <th scope="col">Options</th>
    </tr>
  </thead>
  <tbody>
  
    @php
        $no = 1;
    @endphp
    @foreach($airlines as $al)
    <tr>
      <th scope="row">{{$no++}}</th>
      <td>{{$al->airline_name}}</td>
      <td><img src="{{$al->airline_logo}}" alt="" style="width: 50px; height: 50px"></td>
      <td>{{$al->iata_code}}</td>
      <td>{{$al->icao_code}}</td>
      <td>
        <a href="{{url('/admin/pesawatairlines/delete/'.$al->airline_id)}}"><button type="button" class="btn btn-danger" ><i class="fas fa-trash-alt"></i></button>
        </a>
      </td>
    </tr>
    @endforeach
    
  </tbody>
</table>

@endsection