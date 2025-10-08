<div class="modal fade" id="exportOrderModal" tabindex="-1"
   aria-labelledby="exportOrderModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exportOrderModalLabel">Export Data Pesanan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"
               aria-label="Close"></button>
         </div>
         <form action="{{ route('order.export') }}" method="POST" id="exportOrderForm">
            @csrf
            <div class="modal-body">
               <div class="mb-3">
                  <label for="status" class="form-label">Status Order</label>
                  <select class="form-select" id="status" name="status">
                     <option value="">Semua Status Order</option>
                     @foreach ($status as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                     @endforeach
                  </select>
               </div>
               <div class="mb-3">
                  <label for="payment_status" class="form-label">Status Pembayaran</label>
                  <select class="form-select" id="payment_status" name="payment_status">
                     <option value="">Semua Status Pembayaran</option>
                     @foreach ($paymentStatus as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                     @endforeach
                  </select>
               </div>
               <div class="mb-3">
                  <label for="month" class="form-label">Bulan</label>
                  <select class="form-select" id="month" name="month">
                     <option value="">Semua</option>
                     @for ($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}">
                           {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                        </option>
                     @endfor
                  </select>
               </div>
               <div class="mb-3">
                  <label for="year" class="form-label">Tahun</label>
                  <select class="form-select" id="year" name="year">
                     <option value="">Semua</option>
                     @for ($i = now()->year; $i >= 2020; $i--)
                        <option value="{{ $i }}">{{ $i }}</option>
                     @endfor
                  </select>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary"
                  data-bs-dismiss="modal">Tutup</button>
               <button type="submit" class="btn btn-primary"
                  id="exportButton">Export</button>
            </div>
         </form>
      </div>
   </div>
</div>

<script>
   document.getElementById('exportOrderForm').addEventListener('submit', function(event) {
      var modal = bootstrap.Modal.getInstance(document.getElementById(
         'exportOrderModal'));
      modal.hide();
   });
</script>
