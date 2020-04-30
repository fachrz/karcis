@extends('layouts.AuthTemplate')

@section('pageTitle', 'Karcis - Beli Tiket Online')

@section('content')
<!-- Start PeTik Order Section -->
<div class="container ptk-order-wrapper">
  <div class="card ptk-order-card">
    <div class="card-header text-center krc-order-header">
      <ul class="ptk-order-tabs">
        <li class="nav-item krc-order-item-active" id="pesawat" onclick="tabs(this.id)" section-body="pesawat-section">
          <a class="nav-link krc-tabs">Pesawat</a>
        </li>
        <li class="nav-item kereta-active" id="kereta" onclick="tabs(this.id)" section-body="kereta-section">
          <a class="nav-link">Kereta</a>
        </li>
      </ul>
    </div>
    <div class="card-body krc-card-body">
      <div class="body-section show-first" id="pesawat-section">
        <div class="krc-search-form row">
          <div class="krc-input-form-group col-sm ptk-from">
            <label class="krc-input-label label-from" for="tsfrom">From</label>
            <input class="krc-input ticket-search-from" id="from-input-search" type="text" name="from" widget-type="krc-dropdown" widget-name="#from-destination" quirk="destination-search" autocomplete="off" placeholder="Dari mana?">
            <div class="krc-dropdown krc-destination-widget" id="from-destination">
              @foreach ($airports as $ap)
              <div class="destination-list row no-gutters result-list" id="fromlist-1">
                <div class="destinationlist-content col-sm">
                  <div class="destinationlist-location airport-name">{{$ap->airport_name}}</div>
                </div>
                <div class="destionationlist-code col-3 airport-code">{{$ap->id_airport}}</div>
              </div>
              @endforeach
            </div>
          </div>
          <div class="krc-input-form-group col-sm ptk-from">
            <label class="krc-input-label label-from" for="tsfrom">To</label>
            <input class="krc-input ticket-search-to" id="to-input-search" widget-type="krc-dropdown" widget-name="#to-destination" quirk="destination-search" type="text" name="to" autocomplete="off" placeholder="Mau kemana?" value="">
            <div class="krc-dropdown krc-destination-widget " id="to-destination">
              @foreach ($airports as $ap)
              <div class="destination-list row no-gutters result-list">
                <div class="destinationlist-content col-sm">
                  <div class="destinationlist-location airport-name">{{ $ap->airport_name }}</div>
                </div> 
                <div class="destionationlist-code col-3 airport-code">{{ $ap->id_airport }}</div>
              </div>
              @endforeach
            </div>
          </div>
          <div class="krc-input-form-group col-sm">
            <div class="ptk-departure">
              <label class="krc-input-label" for="psdeparture">Departure</label>
              <input class="krc-input" data-type="date" id="departure" type="text" name="departure" readonly value="">
              <input type="text" id="alt-date-departure" readonly hidden value="">
            </div>
          </div>
          <div class="krc-input-form-group col-sm">
              <input type="checkbox" id="return-input-checkbox">
              <label class="krc-input-label" for="return-input-checkbox">Return</label>
              <input class="krc-input" data-type="date" id="return" type="text" name="departure" readonly value="" disabled>
              <input type="text" id="alt-date-return" readonly hidden value="">
            </div>
          <div class="krc-input-form-group col-sm" widget-for="widget-ptk-passclass">
            <label class="krc-input-label" for="tspassclass">Passenger & Cabin Class</label>
            <input class="krc-input" id="krc-pass-class" type="text" widget-type="krc-dropdown" name="pass-class" widget-name="#passenger-class" readonly="" value="1, Economy">
            <div class="krc-passclass-widget krc-dropdown" id="passenger-class">
              <div class="row">
                <div class="col-sm">
                  <div class="form-group">
                    <label for="">Adult</label>
                    <input class="form-control" id="adult" type="number" value="1">
                  </div>
                  <div class="form-group">
                    <label for="">Child</label>
                    <input class="form-control" id="child" type="number" value="0">
                  </div>
                </div>
                <div class="col-sm">
                <div class="form-group">
                  <label for="">Baby</label>
                  <input class="form-control" id="baby" type="number" value="0">
                </div>
                <div class="form-group">
                <label for="">Class</label>
                  <select class="form-control" id="cabinclassoption">
                    <option>Economy</option>
                    <option>Bussiness</option>
                    <option>FirstClass</option>
                  </select>
                </div>
                </div>
              </div>
              <button type="button" id="passclass-submit" class="btn btn-primary btn-block">OK</button>
            </div>
          </div>
        </div>
        <button type="button" class="btn krc-search-button">Search</button>
      </div>
    </div>
  </div>
</div>
<!-- End PeTik Order Section -->
@endsection