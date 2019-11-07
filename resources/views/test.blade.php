<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Test Laravel Vue Grid</title>
    <link href="{{asset('css/app.css')}}" rel="stylesheet" type="text/css">
</head>
<body>
<h1>{{env('APP_NAME')}} </h1>
<div id="app">
    <test-component></test-component>
</div>
<script src="{{asset('js/grid.js')}}" ></script>
</body>
</html>
