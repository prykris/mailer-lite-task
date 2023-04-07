<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">


    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
          crossorigin="anonymous">

    <!-- Datatables CSS -->
    <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet"
          crossorigin="anonymous">

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"
            crossorigin="anonymous"></script>

    <!-- JQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"
            integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Datatables -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    <!-- Moment -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Bootstrap Select -->
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/css/bootstrap-select.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/js/bootstrap-select.min.js"></script>

    <!-- List of countries -->
    <script src="{{ asset('scripts/countries.js') }}"></script>

    <style>
        html, body {
            height: 100%;
        }
    </style>

    <title>@yield('title', 'MailerLite Subscriber Manager')</title>
</head>
<body class="d-flex flex-column">
@include('components/navbar')

<div class="container flex-grow-1">
    @yield('content')
</div>

<footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top flex-grow-0">
    <div class="col-md-4 d-flex align-items-center">
        <span class="ms-3 mb-3 mb-md-0 text-muted">ಠಠ Kristaps Drivnieks</span>
    </div>
</footer>

<script src="{{ asset('scripts/app.js') }}"></script>
</body>
</html>
