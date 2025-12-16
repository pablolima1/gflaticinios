@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Editar Tipo de Processo" />
    <x-form.tipoprocessos.tipo-processo-edit-form :tipoprocesso="$tipoProcesso"/>
@endsection
