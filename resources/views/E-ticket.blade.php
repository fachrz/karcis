<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
    <style>
        .doc-title{
            font-weight: bold;
            font-size: 30px;
        }
    </style>
    <table style="width: 100%; margin-bottom: 10px">
        <tr>
            <td style="padding: 10px">
                <div class="doc-title">E-tiket</div>
            </td>
            <td style="text-align: right;" style="padding: 10px;">
                <img src="{{ asset('images/Karcis.jpg') }}" alt="logo" style="width:185px;" >
            </td>
        </tr>
    </table>    
    <div class="wrapper">
        <div class="">Detail Penerbangan</div>
        <div class="">
            <img src="{{ asset($dataTiket->scheduleData->flightData->airlineData->etiket_logo) }}" alt="logo" style="width:180px;">
            <div class="">{{$dataTiket->scheduleData->flightData->airlineData->airline_name}} ({{$dataTiket->scheduleData->flightData->flight_number}})</div>
            <hr>
            {{$departure_date['date']}}
            <div style="padding: 15px">
                <table style="width: 100%">
                    <tr>
                        <td>
                            <div>{{$airportFrom->province}}</div>
                            <div>{{$airportFrom->airport_name}}({{$dataTiket->scheduleData->flightData->airport_from}})</div>
                            <div>Berangkat {{$departure_date['time']}}</div>
                        </td>
                        <td>
                            <div>{{$airportTo->province}}</div>
                            <div>{{$airportTo->airport_name}}({{$dataTiket->scheduleData->flightData->airport_to}})</div>
                            <div>Tiba {{$departure_date['time']}}</div>
                        </td>
                    </tr>
                </table>
            </div>
            @if($dataTiket2 != null)
            <img src="{{ asset($dataTiket2->scheduleData->flightData->airlineData->etiket_logo) }}" alt="logo" style="width:180px;">
            <div class="">{{$dataTiket2->scheduleData->flightData->airlineData->airline_name}} ({{$dataTiket2->scheduleData->flightData->flight_number}})</div>
            <hr>
            {{$departure_date['date2']}}
            <div style="padding: 15px">
                <table style="width: 100%">
                    <tr>
                        <td>
                            <div>{{$airportFrom2->province}}</div>
                            <div>{{$airportFrom2->airport_name}}({{$dataTiket2->scheduleData->flightData->airport_from}})</div>
                            <div>Berangkat {{$departure_date['time2']}}</div>
                        </td>
                        <td>
                            <div>{{$airportTo2->province}}</div>
                            <div>{{$airportTo2->airport_name}}({{$dataTiket2->scheduleData->flightData->airport_to}})</div>
                            <div>Tiba {{$departure_date['time2']}}</div>
                        </td>
                    </tr>
                </table>
            </div>
            @endif
            <div>
                <span style="font-size: 16px; font-weight: bold">Note :</span> 
                <ul>
                    <li>Semua waktu tertera adalah waktu bandara setempat</li>
                    <li>Mohon lakukan check-in minimal 1 jam (domestik) sebelum</li>
                </ul>
            </div>
            <div class="">
                <div class="" style="font-size: 21px; padding: 10px 0px">Detail Penumpang</div> 
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Titel</th>
                            <th scope="col">Nama Penumpang</th>
                            <th scope="col">Jenis Tiket</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach($passenger as $ps)
                        <tr>
                            <th scope="row">{{$i++}}</th>
                            <td scope="col">{{$ps->title}}</td>
                            <td scope="col">{{$ps->fullname}}</td>
                            <td scope="col">{{$ps->type}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    </table>
            </div>
        </div>
    </div>
    <div class="footer">
    <div style="padding: 10px">
    <table>
        <tr>
            <td style="width: 180px">
                <img src="{{ asset('images/ticket.svg') }}" alt="logo" style="width:80px;">
                            <b>Karcis</b>.com
            </td>
            <td>
                <div style="font-size: 15px">
                Tiket ini dapat dicetak dan dibawa untuk ditunjukkan kepada petugas pada saat check-in. Sertakan identitas diri para penumpang pada saat check-in agar petugas dapat melakukan verifikasi tiket ini
                </div>
            </td>
        </tr>
    </table>
    </div>
        <hr>
    <div style="text-align: center">
        Jika mengalami kendala, mohon hubungi Karcis.com di 089-123-54-354 atau Email admin@Karcis.com
        </div>
    </div>
    </body>
</html>