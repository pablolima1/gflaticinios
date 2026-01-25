@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Editar Tipo de Despesa" />
    <x-form.tipodespesas.tipo-despesa-edit-form :tipodespesa="$tipoDespesa"/>
@endsection
