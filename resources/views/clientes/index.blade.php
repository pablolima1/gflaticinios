@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-8">
        <x-tables.clientes.cliente-table :clientes="$clientes" />
    </div>
@endsection
