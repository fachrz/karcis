@extends('layouts.KeretaAuthTemplate')

@section('pageTitle', 'Karcis Kereta')

@section('content')
<div id="exptime" class="d-none">{{ $exptime }}</div>
<div id="countdown">
    Silahkan Selesaikan pesanan Anda dalam waktu
    <span class="countdown-timer" id="countdown-hours">00</span> :
    <span class="countdown-timer" id="countdown-minutes">00</span> :
    <span class="countdown-timer" id="countdown-seconds">00</span>
</div>

<div class="container">
    <div class="row no-gutter">
        <div class="col-sm">
            <div class="card krc-order-form">
                <h3>Data Pemesan</h3>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nama Lengkap</label>
                        <input type="text" class="form-control" id="cust-fullname" aria-describedby="emailHelp"
                            placeholder="Masukan Nama Lengkap" value="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Email</label>
                        <input type="email" class="form-control" id="cust-email" placeholder="Email Address" value="">
                    </div>
            </div>
            <div class="card krc-order-form">
                <h3>Data Penumpang</h3>            
            @for ($i = 1; $i <= $adult + $baby; $i++)
                @php
                    if ($i <= $adult) {
                        $type = "Adult";
                    }else if ($i <= $adult + $baby){
                        $type = "Baby";
                    }
                @endphp
            
                <div class="krc-passenger-type">
                    <div class="header">Penumpang {{$i}} : {{ $type }}</div>
                    <div class="toggle-order d-none">test</div>
                </div>
                <input type="text" class="pass-type" value="{{ strtolower($type) }}" hidden readonly>
                <div class="form-group">
                    <select class="form-control pass-title">
                        <option value="default" selected>Choose Title</option>
                        <option value="mr">Mr.</option>
                        <option value="mrs">Mrs.</option>
                        <option value="ms">Ms.</option>
                    </select>
                </div>
                <div class="form-group">
                    <input type="email" class="form-control pass-fullname" aria-describedby="emailHelp"
                        placeholder="Masukan Nama lengkap">
                </div>
                <div class="form-group">
                    <select class="form-control pass-citizenship">
                        <option value="default" selected>Choose Country</option>
                        <option value="indonesia">Indonesia</option>
                    </select>
                </div>
            @endfor
            </div>
            </div>

            <div class="col-4" style="padding: 0px 0px 0px 10px">
                <div class="card order-sidebar info-sidebar-wrapper">
                    <h5 class="card-header sidebar-header">Info Perjalanan</h5>
                    <div class="card-body">
                        <p>
                            {{ date('d F Y', strtotime($Tiketdata->scheduleData->departure_date)) }}
                        </p>
                        <h5 class="card-title">
                            {{$Tiketdata->scheduleData->stationFromData->station_name}} - {{$Tiketdata->scheduleData->stationToData->station_name}}
                        </h5>
                        <p>{{ ucfirst($Tiketdata->seat_class) }} Class</p>
                    </div>
                    <h5 class="card-header pd-header">Ringkasan Harga</h5>
                    <div class="card-body pd-body">
                        <table style="width: 100%">
                            @if($adult != 0)
                            <tr>
                                <td>Dewasa {{$adult > 1 ? "($adult)" : ''}}</td>
                                <td class="pd-pricing">
                                    @if($Tiketdata)
                                        Rp. {{ number_format($Tiketdata->price * $adult,2,',','.') }}
                                    @endif
                                </td>
                            </tr>
                            @endif
                            @if($baby != 0)
                            <tr>
                                <td>Bayi {{$baby > 1 ? "($baby)" : ''}}</td>
                                <td class="pd-pricing">
                                    @if($Tiketdata)
                                        Rp. {{ number_format($Tiketdata->price * $baby,2,',','.') }}
                                    @endif
                                </td>
                            </tr>
                            @endif
                        </table>
                        <hr>
                        <table style="width: 100%">
                            <tr id="total-price">
                                <td class="pd-total-text">Total</td>
                                <td class="pd-pricing pd-total-price">Rp. {{ number_format($totalprice,2,',','.')}}</td>
                            </tr>
                            <tr id="voucher-used" class="d-none">
                                <td class="pd-total-text"></td>
                                <td class="pd-pricing pd-total-price"></td>
                            </tr>
                        </table>
                    </div>
                    <button class="btn btn-primary order-button" type="button">Pesan Kereta</button>
                </div>

            </div>

        </div>
    </div>
</div>
@endsection
@section('jslib')
<script src="{{ asset('js/countdown.js') }}"></script>
@endsection
