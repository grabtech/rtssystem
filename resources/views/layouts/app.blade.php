<!DOCTYPE html>
<html lang="en">
<head>
<meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grab Ticket</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="{{url('/dashboard/css/styles.css')}}" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="{{url('/dashboard/js/scripts.js')}}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="{{url('/dashboard/assets/demo/chart-area-demo.js')}}"></script>
        <script src="{{url('/dashboard/assets/demo/chart-bar-demo.js')}}"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="{{url('/dashboard/js/datatables-simple-demo.js')}}"></script>


  
        <script src="https://cdn.jsdelivr.net/alertifyjs/1.10.0/alertify.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/alertifyjs/1.10.0/css/alertify.min.css" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/alertifyjs/1.10.0/css/themes/default.min.css" rel="stylesheet" />


    </head>
<body>
    @include('layouts.header')
    @include('layouts.sidebar')
</body>
</html>