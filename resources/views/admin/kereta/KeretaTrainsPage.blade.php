@extends('admin.layouts.AdminNav')

@section('pageTitle', 'Kereta Trains')
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
      <form action="{{ url('/admin/keretatrains/add') }}" method="post" class="register-register-form">
      @csrf
      <fieldset class="register-input-container">
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="train-id">Train ID</label>
                    <input type="text" name="train-id" class="form-control" id="aircraft-registry" aria-describedby="emailHelp" placeholder="Masukan Nomor Registrasi Pesawat" required>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="train-name">Train Name</label>
                    <input type="text" name="train-name" class="form-control" id="airline" placeholder="Masukan Nama Maskapai" required>
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
      <th scope="col">Train ID</th>
      <th scope="col">Train Name</th>
      <th scope="col">Options</th>
    </tr>
  </thead>
  <tbody>
  
    @php
        $no = 1;
    @endphp
    @foreach($trains as $ts)
    <tr>
      <th scope="row">{{$no++}}</th>
      <td>{{$ts->train_id}}</td>
      <td>{{$ts->train_name}}</td>  
      <td>
      <a href="{{url('/admin/keretatrains/delete/'.$ts->train_id)}}"><button type="button" class="btn btn-danger" ><i class="fas fa-trash-alt"></i></button>        </a>
      </td>
    </tr>
    @endforeach
    
  </tbody>
</table>
@endsection