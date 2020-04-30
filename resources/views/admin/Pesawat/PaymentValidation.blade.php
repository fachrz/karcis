@extends('admin.layouts.AdminNav')

@section('pageTitle', 'Payment Validation')

@section('content')
<div class="container validation-box">
    <form action="{{url('/paymentvalidated')}}" method="post">
        @csrf
        <input type="text" class="form-control" name="payment_code" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Payment Code">
        <small id="emailHelp" class="form-text text-muted">Check Again Before Submit :)</small>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection