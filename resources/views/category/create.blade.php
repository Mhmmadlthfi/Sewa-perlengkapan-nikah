@extends('layouts.main')

@section('container')
   <div class="container-xxl flex-grow-1 container-p-y">
      <h5 class="fw-bold py-3 mb-4">
         <span class="text-muted fw-light">Kategori /</span> Tambah Data
      </h5>

      <div class="col-xxl">
         <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
               <h5 class="mb-0">Tambah Data Kategori</h5>
            </div>
            <div class="card-body">

               <form action="{{ route('category.store') }}" method="POST">
                  @csrf

                  <!-- Nama Kategori -->
                  <div class="row mb-3">
                     <label class="col-sm-2 col-form-label" for="name">Nama
                        Kategori</label>
                     <div class="col-sm-10">
                        <input type="text"
                           class="form-control @error('name') is-invalid @enderror"
                           id="name" name="name" placeholder="Dekorasi"
                           value="{{ old('name') }}" autocomplete="name" required />
                        @error('name')
                           <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                     </div>
                  </div>

                  <!-- Deskripsi -->
                  <div class="row mb-3">
                     <label class="col-sm-2 col-form-label" for="description">Deskripsi
                        Kategori</label>
                     <div class="col-sm-10">

                        {{-- Trix Editor --}}
                        <input id="description" type="hidden" name="description"
                           value="{{ old('body') }}">
                        <trix-editor class="trix-content" input="description"></trix-editor>

                        @error('description')
                           <p class="text-danger">{{ $message }}</p>
                        @enderror
                     </div>
                  </div>

                  <div class="row justify-content-end">
                     <div class="col-sm-10 mt-1">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                     </div>
                  </div>

               </form>

            </div>
         </div>
      </div>
   </div>
@endsection
