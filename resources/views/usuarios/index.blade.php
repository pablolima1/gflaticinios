@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-8">
        <x-tables.usuarios.usuario-table :usuarios="$usuarios" />
    </div>
@endsection
