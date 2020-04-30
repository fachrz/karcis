@extends('layouts.Authtemplate')

@section('pageTitle', 'Karcis Online')

@section('content')
<div class="container">
    <div class="row no-gutters">
        <div class="col-sm-3.5">
            <div class="card departure-section d-none" style="padding: 8px; margin: 5px 5px 5px 0px">
            <div class="d-flex flex-row bd-highlight mb-3 align-item-center" style="margin: 0px !important">
                <div class="p-2 bd-highlight" style="padding: 8px 0px 8px 0px !important; margin: 0px !important;">
                    <div class="krc-departure-img-thumbnail" style="width: 95px !important; margin: 6px;">
                        <img class="krc-departure-airline-img"
                            src=""
                            alt="Card image cap">
                    </div>
                </div>
                <div class="p-2 bd-highlight" style="padding: 8px 8px 8px 0px !important">
                    <div style="font-size: 15px" id="departure-from-to"><span id="from">CGK</span> - <span id="to">SUB</span></div>
                    <div style="font-size: 12px" id="departure-date">Sel, 12 april 2020</div>
                    <div style="font-size: 12px" id="departure-price-wrapper">
                        <div id="departure-price"></div>
                        <div class="departure-edit d-none"><a id="departure-change" href="#">Ganti</a></div>
                    </div>
                </div>
            </div>
            </div>
        </div>
        <div class="col-sm-3.5">
        <div class="card return-section d-none" style="padding: 8px; margin: 5px 5px 5px 0px">
            
        </div>
        </div>
    </div>

    @foreach($tiketresult as $tiket)
    <div class="card result-card" style="display: inline-block; padding: 5px 10px 5px 5px">
        <div class="card-header krc-result-list-header" style="padding: 12px 8px !important">
            {{ ucfirst($tiket->scheduleData->flightData->airlineData->airline_name) }}
            {{ $tiket->scheduleData->flight_number }}
        </div>
        <div class="d-flex flex-row bd-highlight mb-3 align-item-center">
            <div class="p-2 bd-highlight">
                <div class="krc-result-airline-img">
                    <img class="krc-airline-img"
                        src="{{ asset($tiket->scheduleData->flightData->airlineData->airline_logo) }}"
                        alt="Card image cap">
                </div>
            </div>
            <div class="p-2 bd-highlight">
                <div class="flight-info">
                    <div class="segments">
                        <div class="segment departure">
                            @php
                            $time = $tiket->scheduleData->departure_date;
                            $time = date("H:i", strtotime($time));
                            @endphp
                            <time>{{ $time }}</time>
                            <span class="airport">{{ $tiket->scheduleData->flightData->airport_from }}</span>
                        </div>
                        <div class="divider"><span class="plane"></span></div>
                        <div class="segment destination">
                            @php
                            $dtarrival = new Carbon\Carbon($tiket->scheduleData->departure_date);
                            $dtarrival->addMinutes(60)->toDateTimeString();
                            $dtarrivalstr = $dtarrival;
                            $dtarrivalstr = date("H:i", strtotime($dtarrivalstr));
                            @endphp
                            <time>{{$dtarrivalstr}}</time>
                            <span class="airport">{{ $tiket->scheduleData->flightData->airport_to }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-2 bd-highlight">
                <div style="padding:7px; font-size:18px">{{ ucfirst($tiket->seat_class) }}</div>
            </div>
            <div class="p-2 bd-highlight">
                <div style="padding:5px; font-size:20px">{{ "Rp " . number_format($tiket->price,2,',','.') }}</div>
            </div>
            <div class="p-2 bd-highlight">
                <div style="padding:5px; font-size:20px">{{ $tiket->karcis_point }} KCP</div>
            </div>
            <div class="p-2 bd-highlight">
                <button class="btn btn-primary choose-button" data-href="{{ $tiket->id_ticket }}">Choose</button>
            </div>

            
        </div>
    </div>
    @endforeach
    
</div>
@endsection
