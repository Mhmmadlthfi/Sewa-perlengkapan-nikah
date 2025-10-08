<table class="table table-hover">
   <thead>
      <tr>
         <th>No</th>
         <th>Order ID</th>
         <th>Customer</th>
         <th>Total Harga</th>
         <th>Tanggal Order</th>
         <th>Status Order</th>
         <th>Status Pembayaran</th>
         <th>Action</th>
      </tr>
   </thead>
   <tbody>
      @forelse ($orders as $order)
         <tr>
            <td>
               {{ ($orders->currentPage() - 1) * $orders->perPage() + $loop->iteration }}
            </td>
            <td>{{ $order->order_code }}</td>
            <td>{{ $order->user->name }}</td>
            <td>@rupiah($order->total_price)</td>
            <td>{{ $order->order_date }}</td>
            <td>
               <span class="badge bg-{{ $order->getStatusClass() }}">
                  {{ $order->getStatusLabel() }}
               </span>
            </td>
            <td>
               <span class="badge bg-{{ $order->getPaymentStatusClass() }}">
                  {{ $order->getPaymentStatusLabel() }}
               </span>
            </td>
            <td>
               <!-- Tampilan desktop (di atas 1017px) -->
               <div class="d-none d-lg-flex">
                  @include('order.partials.action')
               </div>

               <!-- Tampilan non-desktop -->
               <div class="dropdown d-lg-none">
                  <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                     data-bs-toggle="dropdown">
                     <i class="tf-icons bx bx-dots-vertical-rounded"></i>
                  </button>

                  <div class="dropdown-menu dropdown-actions p-2">
                     <div class="actions-container d-flex flex-wrap gap-2">
                        @include('order.partials.action')
                     </div>
                  </div>
               </div>

            </td>
         </tr>
      @empty
         <tr>
            <td colspan="8" class="text-center">Tidak ada data</td>
         </tr>
      @endforelse
   </tbody>
</table>

{{-- Paginasi --}}
@if ($orders->hasPages())
   <div class="card-footer border-top p-3" hx-target="#order-table" hx-swap="innerHTML">
      {!! $orders->appends(request()->query())->withPath(route('ajax.orders-table'))->links('pagination::bootstrap-5') !!}
   </div>
@endif
