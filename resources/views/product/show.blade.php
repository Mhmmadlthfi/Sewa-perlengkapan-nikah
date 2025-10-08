@extends('layouts.main')

{{-- @section('container')
   <div class="container py-4">
      <h2 class="mb-4">Detail Produk</h2>

      <div class="row justify-content-center">
         <div class="col-md-8">
            <div class="card shadow-sm">
               
            </div>
         </div>
      </div>
   </div>
@endsection --}}

@section('container')
   <div id="product-page" class="container-xxl flex-grow-1 container-p-y">

      <h6 class="fw-bold py-3 mb-4">
         <span class="text-muted fw-light">Produk /</span> Detail Data Produk
      </h6>

      <div class="card mb-4 border-0 shadow-sm rounded-3 overflow-hidden">
         <div class="row g-0">
            <!-- Gambar -->
            <div class="col-md-4 position-relative"
               style="min-height: 300px; max-height: 350px; overflow: hidden;">
               <img class="img-fluid h-100 w-100"
                  src="{{ $product->image_url
                      ? asset('storage/' . $product->image_url)
                      : asset('storage/dummy-images/dummy-images.png') }}"
                  alt="Foto {{ $product->name }}"
                  style="object-fit: cover; object-position: center;">
            </div>

            <div class="col-md-8">
               <div class="card-body h-100 d-flex flex-column p-4">
                  <!-- Header -->
                  <div class="mb-3">
                     <h4 class="card-title fw-bold mb-1">{{ $product->name }}</h4>
                     <div class="d-flex align-items-center flex-wrap">
                        <span
                           class="badge bg-light-custom text-dark me-2 mb-1">{{ $product->category->name }}</span>
                        <span
                           class="badge {{ $product->stock > 0 ? 'bg-success' : 'bg-danger' }} mb-1">
                           {{ $product->stock > 0 ? 'Tersedia' : 'Tidak tersedia' }}
                        </span>
                     </div>
                  </div>

                  <!-- Price Box -->
                  <div class="mb-3 p-3 rounded-2 bg-light-custom">
                     <div class="row align-items-center">
                        <div class="col-12 col-sm-8 mb-2 mb-sm-0">
                           <div class="d-flex flex-wrap align-items-center">
                              <span
                                 class="fs-4 fw-bold text-warning me-2">@rupiah($product->price)</span>
                              <span class="text-muted d-block d-sm-inline">/
                                 {{ $product->unit }}</span>
                           </div>
                        </div>
                        <div class="col-12 col-sm-4 text-sm-end">
                           <span class="text-muted">Stok: {{ $product->stock }}
                              {{ $product->unit }}</span>
                        </div>
                     </div>
                  </div>

                  <!-- Deskripsi -->
                  <div class="card-text flex-grow-1 mb-3"
                     style="max-height: 120px; overflow-y: auto;">
                     {!! $product->description ?: 'Tidak ada deskripsi produk.' !!}
                  </div>

                  <!-- Footer -->
                  <div class="mt-auto pt-3 border-top">
                     <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                           Diupdate:
                           {{ $product->updated_at ? $product->updated_at->diffForHumans() : '-' }}
                        </small>
                        <div class="d-flex">
                           <a href="{{ route('product.index') }}"
                              class="btn btn-primary ms-2">
                              <i class="bx bx-arrow-back me-1"></i>
                              <span class="d-none d-sm-inline">Kembali</span>
                           </a>
                           <a href="{{ route('product.edit', $product->id) }}"
                              class="btn btn-warning ms-2">
                              <i class="bx bx-edit me-sm-1"></i>
                              <span class="d-none d-sm-inline">Edit</span>
                           </a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>

   </div>
@endsection
