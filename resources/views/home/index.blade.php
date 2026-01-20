@extends('layouts.master')

@section('content')
    <style>
        #tableRecentActivity {
            table-layout: fixed;
            word-wrap: break-word;
        }

        #tableRecentActivity td {
            overflow: hidden;
            text-overflow: ellipsis;
        }

        #tableRecentActivity tbody td {
            font-size: 13px;
            padding: 6px 8px;
            vertical-align: middle;
        }

        thead th {
            font-size: 13px !important;
            padding: 6px 8px !important;
            vertical-align: middle;
        }

        thead tr.filter-row th {
            padding: 4px 6px !important;
        }


        .table-critical-tasks td,
        .table-critical-tasks th {
            font-size: 12px;
            padding: 4px 6px;
            vertical-align: middle;
        }
    </style>
    <div class="container-fluid mt-4 px-4">
    </div>

    <script></script>
@endsection
