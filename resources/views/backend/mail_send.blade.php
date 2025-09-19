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
        *{
            margin: 0;
            box-sizing: border-box;
        }
        .main_mail{
            width: 100%

        }

    </style>
</head>
<body>



    <main class="main_mail">
        <h3>This is the mail from Assets System.</h3><br>
        <h4>The System has recieved Reset Password request.</h4><br>
        <p>Use this Code to reset your current Password</p><br>
        <p>Note Expire 15min.</p><br>
        <h3>Code: {{$mailData['temp_password']}}</h3>
        <p>Name : {{$mailData['fullName']}}</p>
        <p>Company : {{$mailData['company']}}</p>
        <p>Department: {{$mailData['department']}}</p>
        <p>Phone : {{$mailData['phone']}}</p>
        <p>Email : {{$mailData['email']}}</p><br>
                <p>Thank you.</p><br>
    </main>


</body>
</html>
