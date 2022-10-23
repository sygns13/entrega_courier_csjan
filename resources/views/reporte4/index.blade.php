@extends('vendor.adminlte.layouts.app')

@section('htmlheader_title')
	Reporte de Rutas
@endsection

<style type="text/css">         
          
#modaltamanio{
  width: 70% !important;
}
#modaltamanio3{
  width: 80% !important;
}

.swal2-popup{
	font-size: 1.175em !important;
}

.input-xs {
  height: 25px!important;
  padding: 1px!important 1px!important;
  font-size: 10px!important;
  line-height: 1.5!important; /* If Placeholder of the input is moved up, rem/modify this. */
  border-radius: 3px!important;
}

</style>
@section('main-content')
	<div class="container-fluid spark-screen" id="contenidoItem">



		<div class="row">

@include('vendor.adminlte.layouts.partials.loaders')

			@if(accesoUser([1,2,3,4]))

<template v-if="divprincipal" id="divprincipal">
	@include('reporte4.principal')
</template>
			@endif


		</div>
	</div>
@endsection
