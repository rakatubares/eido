@extends('layouts.octopus')

@section('vendorstyle')
@endsection

@section('pagestyle')
@endsection

@section('breadcrumbs')
<li><span>Dashboard</span></li>
@endsection

@section('content')

<div class="row">
    <div class="col-md-4">
        <section class="panel panel-featured-left panel-featured-primary">
            <div class="panel-body">
                <div class="widget-summary widget-summary-md">
                    <div class="widget-summary-col widget-summary-col-icon">
                        <div class="summary-icon bg-primary">
                            <i class="fa fa-file-text"></i>
                        </div>
                    </div>
                    <div class="widget-summary-col">
                        <div class="summary">
                            <h4 class="title">Total Impor</h4>
                            <div class="info">
                                <strong class="amount">{{ $total['all'] }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="col-md-4">
        <section class="panel panel-featured-left panel-featured-danger">
            <div class="panel-body">
                <div class="widget-summary widget-summary-md">
                    <div class="widget-summary-col widget-summary-col-icon">
                        <div class="summary-icon bg-danger">
                            <i class="fa fa-spinner"></i>
                        </div>
                    </div>
                    <div class="widget-summary-col">
                        <div class="summary">
                            <h4 class="title">Outstanding</h4>
                            <div class="info">
                                <strong class="amount">{{ $total['outstanding'] }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="col-md-4">
        <section class="panel panel-featured-left panel-featured-success">
            <div class="panel-body">
                <div class="widget-summary widget-summary-md">
                    <div class="widget-summary-col widget-summary-col-icon">
                        <div class="summary-icon bg-success">
                            <i class="fa fa-check-circle"></i>
                        </div>
                    </div>
                    <div class="widget-summary-col">
                        <div class="summary">
                            <h4 class="title">Selesai</h4>
                            <div class="info">
                                <strong class="amount">{{ $total['selesai'] }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="row">
        <div class="col-md-6">
            <section class="panel">
                <header class="panel-heading">
                    <div class="panel-actions">
                        <a href="#" class="fa fa-caret-down"></a>
                    </div>

                    <h2 class="panel-title">Dokumen Outstanding</h2>
                    <p class="panel-subtitle">Jumlah dokumen belum selesai berdasarkan status</p>
                </header>
                <div class="panel-body">

                    <!-- Flot: Pie -->
                    <div class="chart chart-md" id="flotPie"></div>
                </div>
            </section>
        </div>
        <div class="col-md-6">
            <section class="panel">
                <header class="panel-heading">
                    <div class="panel-actions">
                        <a href="#" class="fa fa-caret-down"></a>
                    </div>

                    <h2 class="panel-title">Dokumen Selesai</h2>
                    <p class="panel-subtitle">Jumlah per dokumen impor</p>
                </header>
                <div class="panel-body">

                    <!-- Flot: Pie -->
                    <div class="chart chart-md" id="dokPenutupPie"></div>
                </div>
            </section>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <section class="panel">
                <header class="panel-heading">
                    <div class="panel-actions">
                        <a href="#" class="fa fa-caret-down"></a>
                    </div>

                    <h2 class="panel-title">Dokumen Harian</h2>
                    <p class="panel-subtitle">Jumlah yang masuk dan selesai per hari</p>
                </header>
                <div class="panel-body">

                    <!-- Flot: Bar -->
                    <div class="chart chart-md" id="neCoBar"></div>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection

@section('vendorscript')
<script src="{{ asset('vendor/flot/jquery.flot.js') }}"></script>
<script src="{{ asset('vendor/flot-tooltip/jquery.flot.tooltip.js') }}"></script>
<script src="{{ asset('vendor/flot/jquery.flot.stack.js') }}"></script>
<script src="{{ asset('vendor/flot/jquery.flot.pie.js') }}"></script>
<script src="{{ asset('vendor/flot/jquery.flot.time.js') }}"></script>
<script src="{{ asset('vendor/flot/jquery.flot.tickrotor.js') }}"></script>
<script src="{{ asset('vendor/flot/jquery.flot.categories.js') }}"></script>
<script src="{{ asset('vendor/flot/jquery.flot.resize.js') }}"></script>
<script src="{{ asset('vendor/flot/jquery.flot.orderBars.js') }}"></script>
@endsection

@section('pagescript')
<script>
$(document).ready(function() {
	(function( $ ) {
        // Get date function
        function gd(date) {
            return new Date(date);
        }

        // Pie chart total outstanding
        function makePie(data, idPie) {
            var pieColor = ['#F47A1F', '#FDBB2F', '#377B2B', '#7AC142', '#007CC3', '#00529B'];
            var flotPieData = [];
            var n = 0;

            jQuery.each(data, function(key, val) {
                var pieElem = { 
                    label: key, 
                    data: [
                        [1,data[key]]
                    ],
                    color: pieColor[n]
                }
                flotPieData.push(pieElem);
                n += 1;
            });

            var plot = $.plot(idPie, flotPieData, {
                series: {
                    pie: {
                        show: true,
                        radius: 0.90,
                        label: {
                            show: true,
                            radius: 1,
                            formatter: function (label, series) {
                                return '<div style="font-size:7.5pt;text-align:center;padding:2px;color:' + series.color + '"><strong style="font-size:10pt;">' + series.data[0][1] + '</strong></div>';
                            }
                        }
                    }
                },
                legend: {
                    show: true
                },
                grid: {
                    hoverable: true,
                    clickable: true
                }
            });
        }

        var status = {!! json_encode($statusAgg->toArray(), JSON_HEX_TAG) !!};
        makePie(status, '#flotPie');

        var dok = {!! json_encode($dokPenutup->toArray(), JSON_HEX_TAG) !!};
        makePie(dok, '#dokPenutupPie');

        // Bar chart
        var newDocData = [
            @foreach ( $neCoChart as $key => $val )
                [gd("{{ $val[0] }}"),"{{ $val[1] }}"],
            @endforeach
        ];
        var comDocData = [
            @foreach ( $neCoChart as $key => $val )
                [gd("{{ $val[0] }}"),"-{{ $val[2] }}"],
            @endforeach
        ];
        var neCoBarData = [newDocData, comDocData];
        $.plot($("#neCoBar"), neCoBarData, {
            series: {
                bars: {
                    show: 'bars',
                    barWidth: 0.6
                }
            },
            bars: {
                align: "center",
                barWidth: 24 * 60 * 60 * 600,
                lineWidth: 1,
                order: 1
            },
            xaxis: {
                mode: "time",
                tickSize: [1, "day"],
                timeformat: "%d %b"
            }
        });

        $.ajax({
            url: '{{ route("dash.test") }}',
            type: 'GET',
            data: { _token: "{{ csrf_token() }}" },
            success: function (params) {
                console.log(params);
            }
        });
	}).apply( this, [ jQuery ]);
});
</script>
@endsection