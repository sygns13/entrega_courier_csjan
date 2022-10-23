@extends('adminlte::layouts.app')

@section('htmlheader_title')
		Registro del Formulario 1 Entrega Courier
@endsection

<style type="text/css">         

#modaltamanio{
	width: 70% !important;
}
.swal2-popup{
	font-size: 1.175em !important;
}
</style>
@section('main-content')
<div class="container-fluid spark-screen">

	<div class="row">

		@include('adminlte::layouts.partials.loaders')

		@if(accesoUser([1,2]))

		<template v-if="divprincipal" id="divprincipal">
			@include('formulario1.main')
		</template>
		@endif


	</div>
</div>
@endsection
