@extends('layouts.main')

@section('container')
   <div class="container-xxl flex-grow-1 container-p-y">
      <h5 class="fw-bold py-3 mb-4">
         <span class="text-muted fw-light">User /</span> Tambah Data
      </h5>

      <div class="col-xxl">
         <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
               <h5 class="mb-0">Tambah Data User</h5>
            </div>
            <div class="card-body">

               <form action="{{ route('user.store') }}" method="POST">
                  @csrf

                  <!-- Nama User -->
                  <div class="row mb-3">
                     <label class="col-sm-2 col-form-label" for="name">Nama
                        User</label>
                     <div class="col-sm-10">
                        <input type="text"
                           class="form-control @error('name') is-invalid @enderror"
                           id="name" name="name" placeholder="Amalia"
                           value="{{ old('name') }}" autocomplete="name" required />
                        @error('name')
                           <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                     </div>
                  </div>

                  <!-- Email -->
                  <div class="row mb-3">
                     <label class="col-sm-2 col-form-label" for="email">Email</label>
                     <div class="col-sm-10">
                        <input type="email"
                           class="form-control @error('email') is-invalid @enderror"
                           id="email" name="email" placeholder="example@gmail.com"
                           value="{{ old('email') }}" autocomplete="email" required />
                        @error('email')
                           <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                     </div>
                  </div>

                  <!-- Phone -->
                  <div class="row mb-3">
                     <label class="col-sm-2 col-form-label" for="phone">Phone</label>
                     <div class="col-sm-10">
                        <input type="tel"
                           class="form-control @error('phone') is-invalid @enderror"
                           id="phone" name="phone" placeholder="081XXXXXXXXX"
                           value="{{ old('phone') }}" autocomplete="phone" required />
                        @error('phone')
                           <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                     </div>
                  </div>

                  <!-- Password -->
                  <div class="row mb-3 form-password-toggle">
                     <label class="col-sm-2 col-form-label" for="password">Password</label>
                     <div class="col-sm-10">
                        <div class="input-group input-group-merge">
                           <input aria-describedby="password"
                              class="form-control @error('password') is-invalid @enderror"
                              id="password" name="password"
                              placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                              type="password" required />
                           <span class="input-group-text cursor-pointer"><i
                                 class="bx bx-hide"></i></span>
                           @error('password')
                              <div class="invalid-feedback">{{ $message }}</div>
                           @enderror
                        </div>
                     </div>
                  </div>

                  <!-- Role -->
                  <div class="row mb-3">
                     <label for="role" class="col-sm-2 col-form-label">Role</label>
                     <div class="col-sm-10">
                        <select required
                           class="form-select @error('role') is-invalid @enderror"
                           id="role" name="role" aria-label="Default select example">
                           <option selected disabled>Pilih Role</option>
                           @foreach ($roles as $key => $value)
                              <option value="{{ $key }}"
                                 {{ old('role') == $key ? 'selected' : '' }}>
                                 {{ $value }}</option>
                           @endforeach
                        </select>
                        @error('role')
                           <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                     </div>
                  </div>

                  <!-- Alamat -->
                  <div class="row mb-3">
                     <label class="col-sm-2 col-form-label" for="address">Alamat</label>
                     <div class="col-sm-10">
                        <textarea class="form-control @error('address') is-invalid @enderror" name="address"
                           id="address"
                           placeholder="Gg. Melati No. 8, Kelurahan Menteng, Kecamatan Jakarta Pusat" required>{{ old('address') }}</textarea>
                        @error('address')
                           <div class="invalid-feedback">{{ $message }}</div>
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
