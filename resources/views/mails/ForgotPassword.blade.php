<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        .mail-wrapper{
            width: 500px;
            border-spacing: 0px;
            font-family: 'Segoe UI'
        }

        .mail-header{
            min-height: 80px;
            padding: 20px;
            background: #f74f43;
            color: white;
            font-size: 20px;
        }

        .mail-body{
            padding: 10px;
            background: #f7f7f7
        }

        .mail-footer{
            min-height: 40px;
            padding: 10px;
            background: #949494;
            color: white;
        }

        .msg-title{
            font-size: 20;
            padding: 10px;
        }

        .msg-body{
            padding: 10px;
        }
    </style>
</head>
<body>
    <table class="mail-wrapper" align="center">
        <tr>
            <td class="mail-header">
                <b>Karcis</b>
            </td>
        </tr>
        <tr>
            <td class="mail-body">
                <table>
                    <tr>
                        <td class="msg-title" align="center">
                            <b>PERMINTAAN LUPA PASSWORD</b>
                        </td>
                    </tr>
                    <tr>
                        <td class="msg-body">
                            Halo {{ $first_name ?? '' }},
                            <br>
                            <br>

                            <b>Sepertinya kamu lupa dengan password kamu,</b>
                            <br>
                            kamu bisa klik link dibawah ini untuk mengubah password kamu. link akan kadaluarsa dalam waktu 30 Menit.
                            <br>
                            <br>
                            <a href="{{ url('reset-password?id=')}}{{ $forgot_id ?? '' }}">http://karcis.test/reset-password?id={{ $forgot_id ?? '' }}</a>
                            <br>
                            <br>
                            Catat password kamu setelah kamu mengubahnya yaa, biar kamu nggk lupa lagi :)
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td class="mail-footer">
                Karcis.com <br>
                2022
            </td>
        </tr>
    </table>
    
</body>
</html>
