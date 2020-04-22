@extends('layouts.octopus')

@section('vendorstyle')
<link rel="stylesheet" href="{{ asset('vendor/select2/select2.css') }}" />
<link rel="stylesheet" href="{{ asset('vendor/jquery-datatables-bs3/assets/css/datatables.css') }}" />
@endsection

@section('pagestyle')
<style>
.inv-line {
	margin-top: 10px;
	border-bottom: 1px dotted #ddd;
}
.inv-group {
	padding: 0;
}
.inv-row {
	margin: 0;
}
.inv-label {
	padding5 0 10px;
}
.inv-detail {
	padding: 0;
}
</style>
@endsection

@section('breadcrumbs')
<li><span>Covid</span></li>
@endsection

@section('content')
{{ var_dump($covid) }}
@endsection

@section('vendorscript')
<script src="{{ asset('vendor/select2/select2.js') }}"></script>
<script src="{{ asset('vendor/jquery-datatables/media/js/jquery.dataTables.js') }}"></script>
<script src="{{ asset('vendor/jquery-datatables/extras/TableTools/js/dataTables.tableTools.min.js') }}"></script>
<script src="{{ asset('vendor/jquery-datatables-bs3/assets/js/datatables.js') }}"></script>
@endsection

@section('pagescript')
@endsection