@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Adicionar Novo Processo" />
    <x-form.processos.create-form :clientes="$clientes" :tipos_processos="$tipos_processos" />
@endsection
