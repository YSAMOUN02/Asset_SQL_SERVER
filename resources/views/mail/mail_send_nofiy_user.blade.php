<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- LINK CSS  --}}
    {{-- <link rel="stylesheet" href="{{URL('assets/css/style.css')}}"> --}}

    {{-- ICON WEBSITE --}}

    <title>Asset System</title>
    <style>
        * {
            margin: 0;
            box-sizing: border-box;
        }

        .main_mail {
            width: 100%
        }

        .credential {
            font-size: 25px;
            font-weight: bold;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>



    <main class="main_mail"
        style="font-family: Arial, sans-serif; line-height: 1.5; color:#333; max-width:600px; margin:auto; padding:20px; background:#f9f9f9; border-radius:8px;">

        <h3 style="color:#004a99;">This is a message from Assets System ,The system has notified your user</h3>
    
        <div class="credential"> User Login: {{ $mailData['user_login'] }}<br> Password: {{ $mailData['password'] }}
        </div>

        <p><strong>Name:</strong> {{ $mailData['fullName'] }}</p>
        <p><strong>ID :</strong> {{ $mailData['id_card'] }}</p>
        <p><strong>Position:</strong> {{ $mailData['position'] }}</p>
        <p><strong>System Role:</strong> {{ $mailData['role'] }}</p>
        <p><strong>Company:</strong> {{ $mailData['company'] }}</p>
        <p><strong>Department:</strong> {{ $mailData['department'] }}</p>
        <p><strong>Email:</strong> {{ $mailData['email'] }}</p>
        <p>Link Access System : <a href="{{ $mailData['login_link'] }}">{{ $mailData['login_link'] }}</a></p>
        <a class="button" href="{{ $mailData['login_link'] }}"
            style="display:inline-block; padding:10px 20px; background:#28a745; color:#fff; text-decoration:none; border-radius:5px; margin:15px 0;">Login Now</a>

        <p>Thank you.</p>

    </main>


</body>

</html>
