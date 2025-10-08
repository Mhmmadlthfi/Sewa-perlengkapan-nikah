@extends('layouts.main')

@section('container')
<div class="container-xxl flex-grow-1 container-p-y">

   <h6 class="fw-bold py-3 mb-4">
      <span class="text-muted fw-light">User /</span> Data User
   </h6>

   {{-- Alert --}}
   @include('partials.alert')

   {{-- Tabel Data User --}}
   <div class="card">
      <div
         class="card-header d-flex justify-content-between align-items-center p-3 border-bottom">

         {{-- Judul --}}
         <h5 class="my-0">Data User</h5>

         {{-- Tambah Data --}}
         <a href="{{ route('user.create') }}" class="btn btn-primary ms-2">
            <i class='bx bx-plus'></i>
            <span class="d-none d-md-inline"> Tambah Data</span>
         </a>
      </div>

      <div class="card-body border-bottom p-2 d-flex flex-column flex-md-row">

         {{-- Filter Role --}}
         <select id="role-select" name="role"
            class="form-select mb-2 mb-md-0 w-100 w-md-50"
            hx-get="{{ route('ajax.users-table') }}" hx-target="#user-table"
            hx-include="[name='search'],[name='is_active']" hx-trigger="change">
            <option value="">Semua Role</option>
            @foreach ($roles as $key => $value)
            <option value="{{ $key }}">
               {{ $value }}
            </option>
            @endforeach
         </select>

         {{-- Filter Status --}}
         <select id="status-select" name="is_active"
            class="form-select mb-2 mb-md-0 w-100 w-md-50 ms-md-2"
            hx-get="{{ route('ajax.users-table') }}" hx-target="#user-table"
            hx-include="[name='search'],[name='role']" hx-trigger="change">
            <option value="">Semua Status</option>
            <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>
               Aktif</option>
            <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>
               Tidak Aktif</option>
         </select>

         {{-- Search --}}
         <div class="input-group input-group-merge w-100 w-md-50 ms-md-2">
            <span class="input-group-text" id="basic-addon-search31">
               <i class="icon-base bx bx-search"></i>
            </span>
            <input type="text" id="input-search" name="search" class="form-control"
               placeholder="Cari nama, email, telepon..."
               hx-get="{{ route('ajax.users-table') }}" hx-target="#user-table"
               hx-include="[name='role'],[name='is_active']"
               hx-trigger="keyup changed delay:500ms">
         </div>

      </div>

      {{-- Spinner --}}
      <div id="loading-user" class="d-none text-center py-2 my-2">
         <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
         </div>
      </div>

      <div id="user-table" class="table-responsive text-nowrap">
         @include('user.partials.table')
      </div>

      {{-- Paginasi --}}
      @if ($users->hasPages())
      <div class="card-footer border-top p-3" hx-target="#user-table"
         hx-swap="innerHTML">
         {!! $users->appends(request()->query())->withPath(route('ajax.users-table'))->links('pagination::bootstrap-5') !!}
      </div>
      @endif

   </div>

</div>
@endsection

@push('users-script')
<script>
   (() => {
      // Fungsi untuk menangani error response
      function handleHtmxError(userTable) {
         console.error(
            'Response HTMX mengandung layout penuh. Ini harusnya partial view.');
         userTable.innerHTML =
            '<div class="text-danger p-3">Terjadi kesalahan: partial view tidak valid</div>';
      }

      // Fungsi untuk menangani before request
      function handleBeforeRequest() {
         const loading = document.getElementById('loading-user');
         const userTable = document.getElementById('user-table');

         if (userTable) userTable.innerHTML = '';
         if (loading) loading.classList.remove('d-none');
      }

      // Fungsi untuk menangani after swap
      function handleAfterSwap() {
         const loading = document.getElementById('loading-user');
         if (loading) loading.classList.add('d-none');
      }

      // Fungsi untuk menangani klik pagination
      function handlePaginationClick(e) {
         if (e.target.tagName === 'A' && e.target.closest('.pagination')) {
            e.preventDefault();
            htmx.ajax('GET', e.target.href, '#user-table');
         }
      }

      // Inisialisasi event listeners
      document.body.addEventListener('htmx:afterOnLoad', function(evt) {
         const userTable = document.getElementById('user-table');
         if (userTable && userTable.querySelector('.layout-wrapper')) {
            handleHtmxError(userTable);
         }
      });

      document.body.addEventListener('htmx:beforeRequest', handleBeforeRequest);
      document.body.addEventListener('htmx:afterSwap', handleAfterSwap);
      document.body.addEventListener('click', handlePaginationClick);
   })();
</script>
@endpush