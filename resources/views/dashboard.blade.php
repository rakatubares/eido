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

                    <h2 class="panel-title">Dokumen Outstanding</h2>
                    <p class="panel-subtitle">Jumlah dokumen belum selesai berdasarkan status</p>
                </header>
                <div class="panel-body">

                    <!-- Flot: Pie -->
                    <div class="chart chart-md" id="chartHarian"></div>
                </div>
            </section>
        </div>
    </div>
    
    @foreach( $dateAgg['new'] as $key => $val )
    {{ $key }} {{ $val->count() }}
    @endforeach
    

</div>
@endsection

@section('vendorscript')
<script src="{{ asset('vendor/flot/jquery.flot.js') }}"></script>
<script src="{{ asset('vendor/flot-tooltip/jquery.flot.tooltip.js') }}"></script>
<script src="{{ asset('vendor/flot/jquery.flot.pie.js') }}"></script>
<script src="{{ asset('vendor/flot/jquery.flot.categories.js') }}"></script>
<script src="{{ asset('vendor/flot/jquery.flot.resize.js') }}"></script>
@endsection

@section('pagescript')
<script>
$(document).ready(function() {
	(function( $ ) {

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
	}).apply( this, [ jQuery ]);
});
</script>
@endsection