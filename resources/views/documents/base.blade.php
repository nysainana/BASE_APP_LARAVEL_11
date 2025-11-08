<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>
        @hasSection('document_title')
            @yield('document_title')
        @else
            @yield('title', 'Welcome!')
        @endif
    </title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 128 128%22><text y=%221.2em%22 font-size=%2296%22>⚫️</text></svg>">
    <link rel="stylesheet" href="{{ asset('bootstrap-5.3.2-dist/css/bootstrap.min.css') }}">
    <style>
        .body {
            width: 95%;
            margin: auto;
        }

        table {
            border-collapse: collapse;
        }

        .font {
            font: 0.8em sans-serif;
        }

        .font-head {
            font-size: 11px;
        }

        .head {
            margin-bottom: 20px;
        }

        .head .info-cte {
            /* font-size: 0.7em; */
        }

        .head .info-bon {
            float: right;
            text-align: center;
        }

        .p-no-space {
            margin-top: 0;
            margin-bottom: 1px;
        }

        .text-bold {
            font-weight: bold;
        }

        .text-underline {
            text-decoration: underline;
        }

        .table-info {
            margin: auto auto 20px;
        }

        .table-info .td-title {
            text-align: right;
            vertical-align: text-top;
        }

        .table-info .td-info {
            font-weight: bold;
            max-width: 300px;
        }

        .table-content {
            width: 100%;
            border-collapse: collapse;
            border: solid 1px;
        }

        .table-content th {
            border: solid 1px;
            white-space: nowrap;
            padding-left: 5px;
            padding-right: 5px;
        }

        .table-content td {
            border: solid;
            border-width: 0 1px 0 1px;
            padding-left: 5px;
            padding-right: 5px;
        }

        .table-content .first {
            padding-left: 5px;
        }

        .table-content .center {
            text-align: center;
        }

        .table-content .right {
            text-align: right;
            padding-right: 5px;
        }
    </style>
    @yield('stylesheets')
    @yield('javascripts')
</head>
<body class='font body'>
<div class='head font-head'>
    <div class='info-bon'>
        @hasSection('title')
            <p class='text-bold p-no-space'>@yield('title')</p>
        @endif
        @hasSection('commande')
            <p class='p-no-space'>@yield('commande')</p>
        @endif
        @hasSection('date')
            <p class='p-no-space'>Date: @yield('date') </p>
        @endif
        @hasSection('echeance')
            <p class='text-bold p-no-space'>Echéance: @yield('echeance')</p>
        @endif
    </div>
    <div class='info-cte font-head'>
        @if($societe)
            <p class='p-no-space'>{{ $societe->nom }}</p>

            @if($societe->adresse)
                <p class='p-no-space'>{{ $societe->adresse }}</p>
            @endif

            @if($societe->ville || $societe->pays)
                <p class='p-no-space'>
                    @if($societe->ville)
                        {{ $societe->ville }} {{ $societe->code_postal }}
                    @endif

                    @if($societe->pays)
                        , {{ $societe->pays }}
                    @endif
                </p>
            @endif

            @if($societe->stat)
                <p class='p-no-space'>N°STAT {{ $societe->stat }}</p>
            @endif

            @if($societe->nif)
                <p class='p-no-space'>NIF: {{ $societe->nif }}</p>
            @endif

            @if($societe->cif)
                <p class='p-no-space'>CIF: {{ $societe->cif }}</p>
            @endif

            @if($societe->rcs)
                <p class='p-no-space'>RCS: {{ $societe->rcs }}</p>
            @endif

            @if($societe->telephone)
                <p class='p-no-space'>Tél: {{ $societe->telephone }}</p>
            @endif

            @if($societe->email)
                <p class='p-no-space'>Email: {{ $societe->email }}</p>
            @endif
        @endif
    </div>
</div>

@yield('body')
</body>
</html>
