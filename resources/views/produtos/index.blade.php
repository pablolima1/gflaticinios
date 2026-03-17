@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-8">
        <x-tables.produtos.produto-table :produtos="$produtos" />
    </div>
@endsection
