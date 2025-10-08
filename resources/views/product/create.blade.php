@extends('layouts.main')

@section('container')
   <div class="container-xxl flex-grow-1 container-p-y">
      <h5 class="fw-bold py-3 mb-4">
         <span class="text-muted fw-light">Produk /</span> Tambah Data
      </h5>

      <div class="col-xxl">
         <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
               <h5 class="mb-0">Tambah Data Produk</h5>
            </div>
            <div class="card-body">

               <form action="{{ route('product.store') }}" method="POST"
                  enctype="multipart/form-data">
                  @csrf

                  <!-- Kategori -->
                  <div class="row mb-3">
                     <label class="col-sm-2 col-form-label"
                        for="category_id">Kategori</label>
                     <div class="col-sm-10">
                        <select required
                           class="form-select @error('category_id') is-invalid @enderror"
                           id="category_id" name="category_id">
                           <option value="" disabled @selected(!old('category_id'))>
                              Pilih Kategori</option>
                           @foreach ($categories as $category)
                              <option value="{{ $category->id }}"
                                 @selected(old('category_id') == $category->id)>
                                 {{ $category->name }}
                              </option>
                           @endforeach
                        </select>
                        @error('category_id')
                           <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                     </div>
                  </div>

                  <!-- Nama Produk -->
                  <div class="row mb-3">
                     <label class="col-sm-2 col-form-label" for="name">Nama
                        Produk</label>
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

                  <!-- Harga -->
                  <div class="row mb-3">
                     <label class="col-sm-2 col-form-label" for="price">Harga</label>
                     <div class="col-sm-10">
                        <input type="number"
                           class="form-control @error('price') is-invalid @enderror"
                           id="price" name="price" min="0" placeholder="8000000"
                           value="{{ old('price') }}" autocomplete="price" required />
                        @error('price')
                           <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                     </div>
                  </div>

                  <!-- Satuan -->
                  <div class="row mb-3">
                     <label class="col-sm-2 col-form-label" for="unit">Satuan</label>
                     <div class="col-sm-10">
                        <select required
                           class="form-select @error('unit') is-invalid @enderror"
                           id="unit" name="unit">
                           <option value="" disabled @selected(!old('unit'))>
                              Pilih Satuan
                           </option>
                           @foreach ($units as $unit)
                              <option value="{{ $unit }}"
                                 @selected(old('unit') == $unit)>
                                 {{ ucfirst($unit) }}
                              </option>
                           @endforeach
                        </select>
                        @error('unit')
                           <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                     </div>
                  </div>

                  <!-- Stock -->
                  <div class="row mb-3">
                     <label class="col-sm-2 col-form-label" for="stock">Stok
                        Produk</label>
                     <div class="col-sm-10">
                        <input type="number"
                           class="form-control @error('stock') is-invalid @enderror"
                           id="stock" name="stock" min="0" placeholder="10"
                           value="{{ old('stock') }}" autocomplete="stock" required />
                        @error('stock')
                           <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                     </div>
                  </div>

                  <!-- Foto Produk -->
                  <div class="row mb-3">
                     <label for="image_url" class="col-sm-2 col-form-label">Foto
                        Produk</label>
                     <div class="col-sm-10">
                        <input type="file"
                           class="form-control @error('image_url') is-invalid @enderror"
                           id="image_url" name="image_url" />
                        @error('image_url')
                           <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @if (!$errors->has('image_url'))
                           <div id="imageHelp" class="form-text">
                              Ukuran maks foto adalah 3MB.
                           </div>
                        @endif
                     </div>
                  </div>

                  <!-- Deskripsi -->
                  <div class="row mb-3">
                     <label class="col-sm-2 col-form-label" for="description">Deskripsi
                        Produk</label>
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
