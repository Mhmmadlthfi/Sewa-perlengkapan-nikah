@extends('layouts.main')
@section('container')
   <div class="container-xxl flex-grow-1 container-p-y">
      <h6 class="fw-bold py-3 mb-4">
         <span class="text-muted fw-light">User / </span> Detail User
      </h6>
      <div class="col-xxl">
         <div class="card mb-4">
            <div
               class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
               <h5 class="mb-0">Detail User</h5>
               <div>
                  <a href="{{ route('user.index') }}" class="btn btn-sm btn-primary">
                     <i class="bx bx-arrow-back"></i> Kembali
                  </a>
                  <a href="{{ route('user.edit', $user) }}"
                     class="btn btn-sm btn-warning ms-1">
                     <i class="bx bx-edit"></i> Edit
                  </a>
               </div>
            </div>
            <div class="card-body">
               <div class="row mb-3">
                  <label class="col-sm-2 col-form-label">Nama</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" value="{{ $user->name }}"
                        readonly>
                  </div>
               </div>
               <div class="row mb-3">
                  <label class="col-sm-2 col-form-label">Email</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" value="{{ $user->email }}"
                        readonly>
                  </div>
               </div>
               <div class="row mb-3">
                  <label class="col-sm-2 col-form-label">Nomor Telepon</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" value="{{ $user->phone }}"
                        readonly>
                  </div>
               </div>
               <div class="row mb-3">
                  <label class="col-sm-2 col-form-label">Alamat</label>
                  <div class="col-sm-10">
                     <textarea class="form-control" readonly>{{ $user->address }}</textarea>
                  </div>
               </div>
               <div class="row mb-3">
                  <label class="col-sm-2 col-form-label">Role</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" value="{{ $user->role }}"
                        readonly>
                  </div>
               </div>
               <div class="row mb-3">
                  <label class="col-sm-2 col-form-label">Status</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control"
                        value="{{ $user->is_active ? 'Aktif' : 'Non-Aktif' }}" readonly>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
@endsection
