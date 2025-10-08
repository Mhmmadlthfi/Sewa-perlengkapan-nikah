@extends('layouts.main')

@section('container')
   <div class="container-xxl flex-grow-1 container-p-y">
      <h5 class="fw-bold py-3 mb-4">
         <span class="text-muted fw-light">Order /</span> Buat Order
      </h5>

      <div class="col-xxl">
         <div class="card mb-4">
            <div class="card-body" x-data="$store.order">

               <div x-cloak x-show="$store.order.errors.availability"
                  class="alert alert-danger alert-dismissible fade show" x-transition>
                  <span x-text="$store.order.errors.availability"></span>
                  <button type="button" class="btn-close"
                     @click="$store.order.errors.availability = ''"></button>
               </div>

               <div class="row">
                  <!-- Kolom Kiri: Form Pemesanan -->
                  <div class="col-md-6">
                     @include('order.partials.create.order-form')
                  </div>

                  <!-- Kolom Kanan: Ringkasan Order -->
                  <div class="col-md-6">
                     @include('order.partials.create.summary')
                  </div>
               </div>

            </div>
         </div>
      </div>
   </div>
   </div>
@endsection

@push('order-create-script')
    @php
        $snapUrl = config('midtrans.is_production')
            ? 'https://app.midtrans.com/snap/snap.js'
            : 'https://app.sandbox.midtrans.com/snap/snap.js';
    @endphp
    <script src="{{ $snapUrl }}" data-client-key="{{ config('midtrans.client_key') }}"></script>
   <script>
      document.addEventListener('DOMContentLoaded', function() {
         // Select Produk
         $('.product-select').select2({
            placeholder: 'Pilih atau cari produk',
            width: '100%',
            ajax: {
               url: "{{ route('ajax.produk-search') }}",
               dataType: 'json',
               delay: 250,
               processResults: function(data) {
                  return {
                     results: data.data.map(item => ({
                        id: item.id,
                        text: item.name,
                        data: item
                     }))
                  };
               },
               cache: true
            }
         }).on('change', function() {
            const selected = $(this).select2('data')[0];

            if (selected?.data) {

               Alpine.store('order').add(selected.data);

               // Reset pilihan agar bisa input lagi
               $(this).val(null).trigger('change');
            }
         });

         // Select User
         $('.user-select').select2({
            placeholder: 'Pilih atau cari customer',
            width: '100%',
            ajax: {
               url: "{{ route('ajax.user-search') }}",
               dataType: 'json',
               delay: 250,
               processResults: function(data) {
                  return {
                     results: data.data.map(item => ({
                        id: item.id,
                        text: item.name,
                        data: item
                     }))
                  };
               },
               cache: true
            }
         }).on('change', function() {
            const selected = $(this).select2('data')[0];

            if (selected?.data) {
               Alpine.store('order').user = selected.data;
            }
         });
      });
   </script>
@endpush
