<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400i" rel="stylesheet" type="text/css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">


        <link rel="stylesheet" type="text/css" href="{{ mix('css/app.css') }}">
        <!-- <link rel="stylesheet" href="css/app.css"> -->

    </head>
    <body>
        <div id="app">
        </div>
        <!-- <script src="js/app.js"></script> -->
        <!-- <script type="text/javascript" src="js/app.js"></script> -->
        <script type="text/javascript" src="{{ mix('js/app.js') }}"></script>
    </body>
</html>
