@extends('layouts.main')

@section('container')
<div class="container-xxl flex-grow-1 container-p-y">

   <h6 class="fw-bold py-3 mb-4">
      <span class="text-muted fw-light">Kategori /</span> Data Kategori
   </h6>

   {{-- Alert --}}
   @include('partials.alert')

   {{-- Tabel Data Kategori --}}
   <div class="card">
      <div
         class="card-header d-flex justify-content-between align-items-center p-3 border-bottom">

         {{-- Judul --}}
         <h5 class="my-0">Data Kategori</h5>

         {{-- Tambah Data --}}
         <a href="{{ route('category.create') }}" class="btn btn-primary ms-2">
            <i class='bx bx-plus'></i>
            <span class="d-none d-md-inline"> Tambah Data</span>
         </a>
      </div>

      <div class="table-responsive text-nowrap">
         <table class="table table-hover">
            <thead>
               <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>Deskripsi</th>
                  <th>Actions</th>
               </tr>
            </thead>
            <tbody class="table-border-bottom-0">
               @forelse ($categories as $category)
               <tr>
                  <td>
                     {{ ($categories->currentPage() - 1) * $categories->perPage() + $loop->iteration }}
                  </td>
                  <td>
                     <strong>{{ $category->name }}</strong>
                  </td>
                  <td>
                     {{ $category->description
                               ? \Illuminate\Support\Str::limit(strip_tags($category->description), 5)
                               : '-' }}
                  </td>
                  <td>
                     <a href="{{ route('category.show', $category) }}"
                        class="btn btn-sm btn-icon btn-outline-info">
                        <i class='tf-icons bx bx-file-find'></i></a>
                     <a href="{{ route('category.edit', $category) }}"
                        class="btn btn-sm btn-icon btn-outline-warning"><i
                           class='tf-icons bx bx-edit'></i></a>
                     <form action="{{ route('category.destroy', $category) }}"
                        method="post" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-icon btn-outline-danger"
                           onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')"
                           @if (!$category->can_delete) disabled @endif><i
                              class='tf-icons bx bx-trash'></i></button>
                     </form>
                  </td>
               </tr>
               @empty
               <tr>
                  <td colspan="7" class="text-center">Tidak ada data</td>
               </tr>
               @endforelse
            </tbody>
         </table>
      </div>

      {{-- Footer Paginasi --}}
      @if ($categories->hasPages())
      <div class="card-footer border-top p-3">
         {!! $categories->withQueryString()->links('pagination::bootstrap-5') !!}
      </div>
      @endif

   </div>

</div>
@endsection