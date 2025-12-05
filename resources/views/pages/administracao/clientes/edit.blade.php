@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Editar Cliente" />
    <x-form.clientes.cliente-edit-form :cliente="$cliente"/>
@endsection
