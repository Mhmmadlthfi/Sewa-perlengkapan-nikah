@extends('layouts.main')

@section('container')
   <div class="container-xxl flex-grow-1 container-p-y">
      <h6 class="fw-bold py-3 mb-4">
         <span class="text-muted fw-light">Order / </span> Detail Order
      </h6>

      <div class="col-xxl">

         {{-- Alert --}}
         @include('partials.alert')

         <div class="card mb-4">

            <div
               class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
               <h5 class="mb-0">Detail Order</h5>

               {{-- Tombol di desktop --}}
               <div class="d-none d-sm-flex gap-2">
                  <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                     data-bs-target="#statusModal">
                     Update Status Order
                  </button>
                  {{-- <button class="btn btn-sm btn-outline-success" data-bs-toggle="modal"
                     data-bs-target="#paymentStatusModal">
                     Update Status Payment
                  </button> --}}
                  @include('order.partials.show.order-delete')
               </div>

               {{-- Dropdown aksi untuk mobile --}}
               <div class="dropdown d-block d-sm-none">
                  <button class="btn btn-sm btn-outline-secondary dropdown-toggle"
                     type="button" id="actionDropdown" data-bs-toggle="dropdown"
                     aria-expanded="false">
                     Aksi
                  </button>
                  <ul class="dropdown-menu dropdown-menu-end"
                     aria-labelledby="actionDropdown">
                     <li>
                        <a class="dropdown-item" href="#" data-bs-toggle="modal"
                           data-bs-target="#statusModal">Update Status Order</a>
                     </li>
                     {{-- <li>
                        <a class="dropdown-item" href="#" data-bs-toggle="modal"
                           data-bs-target="#paymentStatusModal">Update Status Payment</a>
                     </li> --}}
                     <li>
                        @include('order.partials.show.order-delete')
                     </li>
                  </ul>
               </div>
            </div>

            <div class="card-body">
               @include('order.partials.show.detail-order')
            </div>

         </div>

         <div class="card">

            <div class="card-header">
               <h6 class="mb-0">Daftar Produk</h6>
            </div>

            {{-- Tabel Produk Order --}}
            <div class="card-body table-responsive">
               <table class="table table-striped mb-0">
                  <thead>
                     <tr>
                        <th>No</th>
                        <th>Produk</th>
                        <th>Jumlah</th>
                        <th>Harga</th>
                        <th>Subtotal</th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach ($order->items as $index => $item)
                        <tr>
                           <td>{{ $index + 1 }}</td>
                           <td>{{ $item->product->name }}</td>
                           <td>{{ $item->quantity }}</td>
                           <td>Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                           <td>
                              Rp{{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                           </td>
                        </tr>
                     @endforeach
                  </tbody>
               </table>
            </div>

         </div>

      </div>
   </div>

   @include('order.partials.show.modals')
@endsection
