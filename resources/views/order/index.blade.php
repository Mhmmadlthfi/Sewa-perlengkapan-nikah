@extends('layouts.main')

@section('container')
<div id="order-page" class="container-xxl flex-grow-1 container-p-y">

   <h6 class="fw-bold py-3 mb-4">
      <span class="text-muted fw-light">Order /</span> Data Order
   </h6>

   {{-- Alert (khusus halaman order) --}}
   @if(request('transaction_status'))
        @php
            $transactionStatus = request('transaction_status');
            $order = request('order');

            $message = match ($transactionStatus) {
                'settlement' => "Pembayaran untuk order $order berhasil!",
                'pending'    => "Pembayaran untuk order $order masih menunggu penyelesaian.",
                'deny'       => "Pembayaran untuk order $order ditolak. Silakan coba lagi.",
                'cancel'     => "Transaksi untuk order $order dibatalkan.",
                'expire'     => "Waktu pembayaran untuk order $order telah habis.",
                default      => "Status transaksi untuk order $order tidak diketahui.",
            };

            $alertClass = match ($transactionStatus) {
                'settlement' => 'alert-success',
                'pending'    => 'alert-warning',
                'deny', 'cancel', 'expire' => 'alert-danger',
                default      => 'alert-secondary',
            };
        @endphp

        <div class="alert {{ $alertClass }} alert-dismissible fade show" role="alert">
            {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

   <div class="card">

      <div
         class="card-header d-flex justify-content-between align-items-center p-3 border-bottom">

         {{-- Judul --}}
         <h5 class="my-0">Data Order</h5>

         {{-- Export --}}
         <button class="btn btn-outline-primary ms-auto" data-bs-toggle="modal"
            data-bs-target="#exportOrderModal">
            <i class='bx bx-export mb-1'></i>
            <span class="d-none d-md-inline"> Export</span>
         </button>

         {{-- Tambah Data --}}
         <a href="{{ route('order.create') }}" class="btn btn-primary ms-2">
            <i class='bx bx-plus'></i>
            <span class="d-none d-md-inline"> Tambah Data</span>
         </a>

      </div>

      <div class="card-body border-bottom p-2 d-flex flex-column flex-md-row">

         {{-- Filter Status Order --}}
         <select id="status-order-select" name="status"
            class="form-select mb-2 mb-md-0 w-100 w-md-50"
            hx-get="{{ route('ajax.orders-table') }}" hx-target="#order-table"
            hx-trigger="change">
            <option value="">Semua Status Order</option>
            @foreach ($status as $value => $label)
            <option value="{{ $value }}">{{ $label }}</option>
            @endforeach
         </select>

         {{-- Filter Payment Status --}}
         <select id="payment-status-select" name="payment_status"
            class="form-select mb-2 mb-md-0 w-100 w-md-50 ms-md-2"
            hx-get="{{ route('ajax.orders-table') }}" hx-target="#order-table"
            hx-trigger="change">
            <option value="">Semua Status Pembayaran</option>
            @foreach ($paymentStatus as $value => $label)
            <option value="{{ $value }}">{{ $label }}</option>
            @endforeach
         </select>

         {{-- Search --}}
         <div class="input-group input-group-merge w-100 w-md-50 ms-0 ms-md-2">
            <span class="input-group-text" id="basic-addon-search31">
               <i class="icon-base bx bx-search"></i>
            </span>
            <input type="text" id="input-search" name="search" class="form-control"
               placeholder="Cari..." hx-get="{{ route('ajax.orders-table') }}"
               hx-target="#order-table" hx-include="[name=search], [name=user_id]"
               hx-trigger="keyup changed delay:500ms">
         </div>

      </div>

      {{-- Spinner --}}
      <div id="loading-order" class="d-none text-center py-2 my-2">
         <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
         </div>
      </div>

      {{-- Tabel Produk --}}
      <div id="order-table" class="table-responsive">
         @include('order.partials.table')
      </div>

   </div>

</div>
@include('order.partials.modal')
@endsection

@push('orders-script')
<script>
   // Scope agar tidak bentrok variabel saat HTMX reload sebagian halaman
   (() => {

      document.body.addEventListener('htmx:afterOnLoad', function(evt) {
         const orderTable = document.getElementById('order-table');

         // Cek apakah hasil response HTMX tidak menyisipkan elemen aneh
         if (orderTable && orderTable.querySelector('.layout-wrapper')) {
            console.error(
               'Response HTMX mengandung layout penuh. Ini harusnya partial view.'
            );
            orderTable.innerHTML =
               '<div class="text-danger p-3">Terjadi kesalahan: partial view tidak valid</div>';
         }
      });

      // Tampilkan spinner dan kosongkan tabel sebelum request
      document.body.addEventListener('htmx:beforeRequest', () => {
         const loading = document.getElementById('loading-order');
         const orderTable = document.getElementById('order-table');

         if (orderTable) orderTable.innerHTML = '';
         if (loading) loading.classList.remove('d-none');
      });

      // Sembunyikan spinner setelah respon dimuat
      document.body.addEventListener('htmx:afterSwap', () => {
         const loading = document.getElementById('loading-order');
         if (loading) loading.classList.add('d-none');
      });

      // Jalankan AJAX HTMX saat klik link paginasi
      document.body.addEventListener('click', function(e) {
         if (e.target.tagName === 'A' && e.target.closest('.pagination')) {
            e.preventDefault();
            htmx.ajax('GET', e.target.href, '#order-table');
         }
      });

   })();
</script>
@endpush