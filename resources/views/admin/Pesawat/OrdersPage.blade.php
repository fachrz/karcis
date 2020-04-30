@extends('admin.layouts.AdminNav')

@section('pageTitle', 'Orders')
@section('generate-report', '/')

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
<form action="{{ url('/admin/ordersconfirmation') }}" method="post">
@csrf
  <div class="form-group">
    <label for="payment-code">Payment Code</label>
    <input type="text" class="form-control" id="payment-code" name="payment-code" aria-describedby="emailHelp" placeholder="Masukan Kode Pembayaran">
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>

<div>
  <br>
  <br>
  @php
    $dataOrder = Session::get('dataOrder')
  @endphp
  @if($dataOrder = Session::get('dataOrder'))
    <div>Nama : {{$dataOrder['cust_fullname']}}</div> 
    <div>Harga : Rp. {{ number_format($dataOrder['total_price'] ,2,',','.') }}</div>
    <form action="{{ url('/admin/orders/validation') }}" method="post">
    @csrf
    <input type="text" class="form-control" name="payment-code" aria-describedby="emailHelp" value="{{$dataOrder['payment_code']}}" hidden readonly>
    <input type="text" class="form-control" name="location" aria-describedby="emailHelp" value="{{$dataOrder['location']}}" hidden readonly>
    <input type="text" class="form-control" name="total_price" aria-describedby="emailHelp" value="{{$dataOrder['total_price']}}" hidden readonly>
      <button type="submit" class="btn btn-primary">Confirm</button>
    </form>

  @elseif($orderMsg = Session::get('orderMsg'))
    {{$orderMsg}}
  @endif
</div>

@endsection