@extends('admin.layouts.AdminNav')

@section('pageTitle', 'Users Account')

@section('top-right-corner-button')
  <!-- Button trigger modal -->
<button class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#adminInsertModal"><i class="fas fa-plus fa-sm text-white-50"></i> Insert Data</button>
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

<div class="table-response">
<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Email</th>
      <th scope="col">First Name</th>
      <th scope="col">Last Name</th>
      <th scope="col">telp</th>
      <th scope="col">Account Type</th>
      <th scope="col">Options</th>

    </tr>
  </thead>
  <tbody>
      @foreach($usersData as $ud)
    <tr>
        <th scope="row">1</th>
        <td>{{$ad->email}}</td>
        <td>{{$ad->first_name}}</td>
        <td>{{$ad->last_name}}</td>
        <td>{{$ad->telp}}</td>
        <td>{{$karcis_point}}</td>
        <td>{{$account_}}</td>


        <td>{{$ad->level}}</td>
        <td>
        <button type="button" class="btn btn-warning update-admin" data-toggle="modal" data-target="#adminUpdateModal" data-send="{{$ad->username}}">Edit</button>      
          <a href="{{url('/admin/adminaccount/delete/'.$ad->username)}}"><button   type="button" class="btn btn-danger" >Delete</button>
            </a>       
          
        </td>
    </tr>
    @endforeach
  </tbody>
</table>
</div>

<!-- Modal -->
<div class="modal fade" id="adminUpdateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
    <form action="{{url('/admin/adminaccount/edit')}}" method="POST">
    @csrf
    <div class="form-row">
        <div class="form-group col-md-6">
        <label for="inputEmail4">Username</label>
        <input type="text" class="form-control" id="update-username" name="username"  readonly>
        </div>
        <div class="form-group col-md-6">
        <label for="inputPassword4">Password</label>
        <input type="password" class="form-control" id="update-password" name="password">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
        <label for="inputCity">Admin Name</label>
        <input type="text" class="form-control" id="update-admin-name" name="admin-name">
        </div>
        <div class="form-group col-md-4">
        <label for="inputState">Privileges</label>
        <select id="update-privileges" class="form-control" name="update-privileges">
            <option selected>privileges...</option>
            <option value="0">Root</option>
            <option value="1">Cashier</option>
            <option value="2">Airline</option>
        </select>
        </div>
        
    </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="adminInsertModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Insert Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
    <form action="{{url('/admin/adminaccount/add')}}" method="POST">
    @csrf
    <div class="form-row">
        <div class="form-group col-md-6">
        <label for="inputEmail4">Username</label>
        <input type="text" class="form-control" id="inputEmail4" name="username">
        </div>
        <div class="form-group col-md-6">
        <label for="inputPassword4">Password</label>
        <input type="password" class="form-control" id="inputPassword4" name="password">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
        <label for="inputCity">Admin Name</label>
        <input type="text" class="form-control" id="inputCity" name="admin-name">
        </div>
        <div class="form-group col-md-4">
        <label for="inputState">Privileges</label>
        <select id="inputState" class="form-control" name="privileges">
            <option selected>privileges...</option>
            <option value="0">Root</option>
            <option value="1">Cashier</option>
            <option value="2">Airline</option>
        </select>
        </div>
        
    </div>
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