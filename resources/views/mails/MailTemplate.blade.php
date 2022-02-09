<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <style>
        .mail-wrapper{
            width: 500px;
            border: 1px solid;
            margin: auto;
        }
    
        .mail-header{
            text-align: center;
            height: 80px;
            border: 1px solid;
        }
        
        .mail-body{
            border: 1px solid;
            padding: 10px
        }
        
        .mail-footer{
            border: 1px solid;
            height: 40px;
            padding: 10px;
        }
    
        .msg-title{
            font-size: 20;
            padding: 10px;
        }
        
        .msg-body{
            padding: 10px;
        }
    </style>

    <table class="mail-wrapper">
        <tr>
            <td class="mail-header">Karcis.com</td>
        </tr>
        <tr>
            <td class="mail-body">
                <table>
                    <tr>
                        <td class="msg-title">
                            @yield('title')
                        </td>
                    </tr>
                    <tr>
                        <td class="msg-body">
                            @yield('body')
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
