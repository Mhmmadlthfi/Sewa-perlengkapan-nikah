@extends('layouts.main')

@section('container')
<div id="product-page" class="container-xxl flex-grow-1 container-p-y">

   <h6 class="fw-bold py-3 mb-4">
      <span class="text-muted fw-light">Produk /</span> Data Produk
   </h6>

   {{-- Alert --}}
   @include('partials.alert')

   <div class="card">

      <div
         class="card-header d-flex justify-content-between align-items-center p-3 border-bottom">

         {{-- Judul --}}
         <h5 class="my-0">Data Product</h5>

         {{-- Export --}}
         <button class="btn btn-outline-primary ms-auto" data-bs-toggle="modal"
            data-bs-target="#exportModal">
            <i class='bx bx-export mb-1'></i>
            <span class="d-none d-md-inline"> Export</span>
         </button>

         {{-- Tambah Data --}}
         <a href="{{ route('product.create') }}" class="btn btn-primary ms-2">
            <i class='bx bx-plus'></i>
            <span class="d-none d-md-inline"> Tambah Data</span>
         </a>

      </div>

      <div class="card-body border-bottom p-2 d-flex flex-column flex-md-row">

         {{-- Filter Kategori --}}
         <select id="category-select" name="category_id"
            class="form-select mb-2 mb-md-0 w-100 w-md-50"
            hx-get="{{ route('ajax.products-table') }}" hx-target="#product-table"
            hx-include="[name=search],[name=category_id]" hx-trigger="change">
            <option value="">Semua Kategori</option>
            @foreach ($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
         </select>

         {{-- Search --}}
         <div class="input-group input-group-merge w-100 w-md-50 ms-0 ms-md-2">
            <span class="input-group-text" id="basic-addon-search31">
               <i class="icon-base bx bx-search"></i>
            </span>
            <input type="text" id="input-search" name="search" class="form-control"
               placeholder="Cari nama, unit, stok..."
               hx-get="{{ route('ajax.products-table') }}" hx-target="#product-table"
               hx-include="[name=search],[name=category_id]"
               hx-trigger="keyup changed delay:500ms">
         </div>

      </div>

      {{-- Spinner --}}
      <div id="loading-product" class="d-none text-center py-2 my-2">
         <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
         </div>
      </div>

      {{-- Tabel Produk --}}
      <div id="product-table" class="table-responsive">
         @include('product.partials.table')
      </div>

   </div>

</div>

@include('product.partials.export')
@endsection

@push('products-script')
<script>
   // Scope agar tidak bentrok variabel saat HTMX reload sebagian halaman
   (() => {

      document.body.addEventListener('htmx:afterOnLoad', function(evt) {
         const productTable = document.getElementById('product-table');

         // Cek apakah hasil response HTMX tidak menyisipkan elemen aneh
         if (productTable && productTable.querySelector('.layout-wrapper')) {
            console.error(
               'Response HTMX mengandung layout penuh. Ini harusnya partial view.'
            );
            productTable.innerHTML =
               '<div class="text-danger p-3">Terjadi kesalahan: partial view tidak valid</div>';
         }
      });

      // Tampilkan spinner dan kosongkan tabel sebelum request
      document.body.addEventListener('htmx:beforeRequest', () => {
         const loading = document.getElementById('loading-product');
         const productTable = document.getElementById('product-table');

         if (productTable) productTable.innerHTML = '';
         if (loading) loading.classList.remove('d-none');
      });

      // Sembunyikan spinner setelah respon dimuat
      document.body.addEventListener('htmx:afterSwap', () => {
         const loading = document.getElementById('loading-product');
         if (loading) loading.classList.add('d-none');
      });

      // Jalankan AJAX HTMX saat klik link paginasi
      document.body.addEventListener('click', function(e) {
         if (e.target.tagName === 'A' && e.target.closest('.pagination')) {
            e.preventDefault();
            htmx.ajax('GET', e.target.href, '#product-table');
         }
      });

   })();
</script>
@endpush