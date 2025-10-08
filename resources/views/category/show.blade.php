@extends('layouts.main')

@section('container')
   <div class="container-xxl flex-grow-1 container-p-y">
      <h6 class="fw-bold py-3 mb-4">
         <span class="text-muted fw-light">Kategori / </span> Detail Kategori
      </h6>

      <div class="col-xxl">
         {{-- Alert --}}
         @include('partials.alert')

         <div class="card mb-4">
            <div
               class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
               <h5 class="mb-0">Detail Kategori</h5>
               <div>
                  <a href="{{ route('category.index') }}" class="btn btn-sm btn-primary">
                     <i class="bx bx-arrow-back"></i> Kembali
                  </a>
                  <a href="{{ route('category.edit', $category) }}"
                     class="btn btn-sm btn-warning ms-1">
                     <i class="bx bx-edit"></i> Edit
                  </a>
               </div>
            </div>

            <div class="card-body">
               <div class="mb-3">
                  <label class="form-label fw-semibold">Nama Kategori</label>
                  <div class="form-control-plaintext">{{ $category->name }}</div>
               </div>

               <div class="mb-3">
                  <label class="form-label fw-semibold">Deskripsi</label>
                  <div class="form-control-plaintext">
                     {!! $category->description ?? '<em class="text-muted">Tidak ada deskripsi</em>' !!}
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
@endsection
