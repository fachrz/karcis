@extends('layouts.BlankTemplate')

@section('pageTitle', 'Karcis Online')

@section('content')
<div id="exptime" class="d-none">{{ $exptime }}</div>
<div id="countdown">
    Selesaikan pembayaran dalam waktu 
    <span class="countdown-timer" id="countdown-hours">00</span> :
    <span class="countdown-timer" id="countdown-minutes">00</span> :
    <span class="countdown-timer" id="countdown-seconds">00</span>
</div>
<style>
    .code-wrapper{
        width: 300px;
        margin: auto;
    }

    .payment-code{
        text-align: center;
        font-size: 20px;
        color: #fd5e53;
        font-weight: bold;
    }

    .payment-wrapper h4{
        font-size: 15px;
        padding: 10px 0px;
    }

    .payment-wrapper{
        margin: 30px auto;
        padding: 15px;
        width: 400px;
        border-radius: 5px;
        background: #fff;
        box-shadow: 0 10px 40px -10px rgba(0,64,128,.2);

    }

    .pd-pricing{
        text-align: right;
    }

    .price{
        padding: 10px 0px;
    }

    .payment-instruction{
        font-size: 12px;
    }

    .karcis-logo-wrapper{
        margin-bottom: 20px
    }
</style>

<div class="payment-wrapper">
    <div class="karcis-logo-wrapper" style="text-align: center">
    <a class="karcis-logo" href="{{ asset('/') }}">
        <img src="{{ asset('images/ticket.svg') }}" alt="logo" style="width:40px;">
        <b>Karcis</b>.com
    </a>
    </div>
    <h4 class="code-label">Kode Pembayaran</h4>
    <div class="payment-code">
        {{$payment_code}}
    </div>
    <div class="price">
        <table style="width: 100%">       
            <tr>
                <td>Jumlah yang harus dibayar </td>
                <td class="pd-pricing">Rp. {{ number_format($totalPrice,2,',','.')}}</td>
            </tr>
        </table>
    </div>
    <div class="card instruction-wrapper">
    <div class="card-body payment-instruction">
        Lakukan pembayaran di gerai karcis terdekat, dan berikan kode pembayaran ini kepada kasir
        <br>
        <br>
        Note: Halaman ini dikirimkan kealamat email customer
    </div>
    </div>
</div>
@endsection
@section('jslib')
    <script src="{{ asset('js/countdown.js') }}"></script>
@endsection