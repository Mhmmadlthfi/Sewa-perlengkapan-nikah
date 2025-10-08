{{-- Modal Update Status --}}
<div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel"
   aria-hidden="true">
   <div class="modal-dialog">
      <form method="POST" action="{{ route('order.status-update', $order) }}">
         @csrf
         @method('PATCH')
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="statusModalLabel">Update Status Order</h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal"
                  aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
               <div class="mb-3">
                  <label for="status" class="form-label">Status Baru</label>
                  <select name="status" id="status" class="form-select" required>
                     @foreach (\App\Models\Order::getStatusOptions() as $value => $label)
                        <option value="{{ $value }}"
                           {{ $order->status === $value ? 'selected' : '' }}>
                           {{ $label }}
                        </option>
                     @endforeach
                  </select>
                  <input type="hidden" name="id" value="{{ $order->id }}">
               </div>
            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
         </div>
      </form>
   </div>
</div>

{{-- Modal Update Payment Status --}}
{{-- <div class="modal fade" id="paymentStatusModal" tabindex="-1"
   aria-labelledby="paymentStatusModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <form method="POST" action="{{ route('order.status-payment-update', $order) }}">
         @csrf
         @method('PATCH')
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="paymentStatusModalLabel">Update Status
                  Pembayaran</h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal"
                  aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
               <div class="mb-3">
                  <label for="payment_status" class="form-label">Status
                     Pembayaran</label>
                  <select name="payment_status" id="payment_status" class="form-select">
                     @foreach (\App\Models\Order::getPaymentStatusOptions() as $value => $label)
                        <option value="{{ $value }}"
                           {{ $order->payment_status === $value ? 'selected' : '' }}>
                           {{ $label }}
                        </option>
                     @endforeach
                  </select>
                  <input type="hidden" name="id" value="{{ $order->id }}">
               </div>
            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-success">Simpan</button>
            </div>
         </div>
      </form>
   </div>
</div> --}}

<!-- Modal Edit Ongkir -->
{{-- <div class="modal fade" id="modalEditOngkir" tabindex="-1"
   aria-labelledby="modalEditOngkirLabel" aria-hidden="true">
   <div class="modal-dialog">
      <form action="{{ route('order.delivery-fee-update', $order) }}" method="POST"
         class="modal-content">
         @csrf
         @method('PATCH')
         <div class="modal-header">
            <h5 class="modal-title" id="modalEditOngkirLabel">Update Biaya Pengiriman</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"
               aria-label="Tutup"></button>
         </div>
         <div class="modal-body">
            <div class="mb-3">
               <label for="delivery_fee" class="form-label">Biaya Pengiriman (Rp)</label>
               <input type="number" name="delivery_fee" id="delivery_fee"
                  class="form-control" min="0" value="{{ $order->delivery_fee }}"
                  required>
               <input type="hidden" name="id" value="{{ $order->id }}">
            </div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary"
               data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
         </div>
      </form>
   </div>
</div> --}}
