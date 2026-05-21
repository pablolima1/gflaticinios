@extends('layouts.app')

@section('content')
<div class="grid grid-cols-12 gap-4 md:gap-6">

  <div class="col-span-12 xl:col-span-4">
    <x-ecommerce.annual-movement :totalAnualVendas="$totalAnualVendas" :totalAnualDespesas="$totalAnualDespesas" :lucroAnual="$lucroAnual" />
  </div>

  <div class="col-span-12 xl:col-span-5">
    <x-ecommerce.monthly-target />
  </div>

  <div class="col-span-12 space-y-6 xl:col-span-7">
    <x-ecommerce.monthly-sale />
    <x-ecommerce.ecommerce-metrics />
  </div>

  <!-- <div class="col-span-12">
      <x-ecommerce.statistics-chart />
    </div> -->

  <div class="col-span-12 xl:col-span-7">
    <x-ecommerce.recent-orders :clients="$topClientes" />
  </div>

  <div class="col-span-12 xl:col-span-5">
    <x-ecommerce.customer-demographic :birthdays="$birthdays" />
  </div>

</div>
@endsection