<table class="table table-hover">
   <thead>
      <tr>
         <th>No</th>
         <th>Nama</th>
         <th>Harga</th>
         <th>Unit</th>
         <th>Stok</th>
         <th>Kategori</th>
         <th>Action</th>
      </tr>
   </thead>
   <tbody>
      @forelse ($products as $product)
         <tr>
            <td>
               {{ ($products->currentPage() - 1) * $products->perPage() + $loop->iteration }}
            </td>
            <td>{{ $product->name }}</td>
            <td>@rupiah($product->price)</td>
            <td>{{ $product->unit }}</td>
            <td>{{ $product->stock }}</td>
            <td>{{ $product->category->name }}</td>
            <td>

               <!-- Tampilan desktop (di atas 1017px) -->
               <div class="d-none d-lg-flex">
                  @include('product.partials.action')
               </div>

               <!-- Tampilan non-desktop -->
               <div class="dropdown d-lg-none">
                  <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                     data-bs-toggle="dropdown">
                     <i class="tf-icons bx bx-dots-vertical-rounded"></i>
                  </button>

                  <div class="dropdown-menu dropdown-actions p-2">
                     <div class="actions-container d-flex flex-wrap gap-2">
                        @include('product.partials.action')
                     </div>
                  </div>
               </div>

            </td>
         </tr>
      @empty
         <tr>
            <td colspan="7" class="text-center">Tidak ada data</td>
         </tr>
      @endforelse
   </tbody>
</table>

{{-- Paginasi --}}
@if ($products->hasPages())
   <div class="card-footer border-top p-3" hx-target="#product-table" hx-swap="innerHTML">
      {!! $products->appends(request()->query())->withPath(route('ajax.products-table'))->links('pagination::bootstrap-5') !!}
   </div>
@endif
