@extends('layouts.app')

@section('content')
<x-common.page-breadcrumb pageTitle="Gerenciar Meus Processos" />
<div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
    <x-tables.processos.processo-index-table :processos="$processos" />
</div>
@endsection