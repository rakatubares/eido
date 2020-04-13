@extends('layouts.octopus')

@section('vendorstyle')
@endsection

@section('pagestyle')
<style>
#flotPlaceholder div.xAxis div.tickLabel 
{    
    transform: rotate(-90deg);
    -ms-transform:rotate(-90deg); /* IE 9 */
    -moz-transform:rotate(-90deg); /* Firefox */
    -webkit-transform:rotate(-90deg); /* Safari and Chrome */
    -o-transform:rotate(-90deg); /* Opera */
    /*rotation-point:50% 50%;*/ /* CSS3 */
    /*rotation:270deg;*/ /* CSS3 */
}
</style>
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

                    <h2 class="panel-title">Dokumen Harian</h2>
                    <p class="panel-subtitle">Jumlah yang masuk dan selesai per hari</p>
                </header>
                <div class="panel-body">

                    <!-- Flot: Pie -->
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
        var flotPieData = [
            @foreach ( $statusAgg as $status => $val )
                { 
                    label: "{{ $status }}", 
                    data: [
                        [1,"{{ $val->count() }}"]
                    ]
                },
            @endforeach
        ];

        var plot = $.plot('#flotPie', flotPieData, {
			series: {
				pie: {
					show: true,
					combine: {
						color: '#999',
						threshold: 0.1
					}
				}
			},
			legend: {
				show: false
			},
			grid: {
				hoverable: true,
				clickable: true
			}
		});

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
        console.log(newDocData);
        console.log(comDocData);
	}).apply( this, [ jQuery ]);
});
</script>
@endsection