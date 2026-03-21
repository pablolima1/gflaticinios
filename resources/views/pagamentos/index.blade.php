@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-8">
        <x-tables.pagamentos.pagamento-table :pagamentos="$pagamentos" />
    </div>
@endsection
