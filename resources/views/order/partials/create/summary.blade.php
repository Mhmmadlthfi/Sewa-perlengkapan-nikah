<div class="card shadow-sm">
   <div class="card-header bg-primary text-white">
      <h5 class="mb-0 fw-semibold text-white">Ringkasan Order</h5>
   </div>
   <div class="card-body">
      <!-- Customer -->
      <p class="my-2"><strong>Customer:</strong> <span id="summary-customer"
            x-text="$store.order.user?.name ?? '-'"></span></p>

      <!-- Produk Dipilih -->
      <h6 class="mb-3">Produk Dipilih</h6>
      <ul class="list-group mb-3" id="summary-products">
         <template x-for="item in $store.order.items" :key="item.id">
            <li class="list-group-item d-flex justify-content-between align-items-center">
               <div>
                  <strong x-text="item.name"></strong><br>
                  <small class="text-muted"
                     x-text="`${rupiah(item.price)} x ${item.quantity}`"></small>
               </div>
               <div class="btn-group btn-group-sm" role="group"
                  aria-label="Quantity controls">
                  <button type="button" class="btn btn-outline-secondary"
                     @click="$store.order.remove(item.id)">-</button>
                  <span class="btn btn-outline-primary disabled"
                     x-text="item.quantity"></span>
                  <button type="button" class="btn btn-outline-secondary"
                     @click="$store.order.add(item)">+</button>
               </div>
            </li>
         </template>
      </ul>

      <!-- Total Harga Produk -->
      {{-- <div class="d-flex justify-content-between mb-2">
         <span>Total Harga Produk</span>
         <strong x-text="rupiah($store.order.total)"></strong>
      </div> --}}

      {{-- <!-- Biaya Ongkir -->
      <div class="d-flex justify-content-between mb-3">
         <span>Biaya Ongkir</span>
         <strong x-text="rupiah($store.order.delivery_fee)"></strong>
      </div> --}}

      <hr>

      <!-- Total Harga Keseluruhan -->
      <div class="d-flex justify-content-between align-items-center mb-3">
         <h5 class="mb-0">Total Keseluruhan</h5>
         <h5 class="text-primary mb-0" x-text="rupiah($store.order.total)"></h5>
      </div>

      <!-- Tanggal Rental -->
      <p><strong>Tanggal Rental:</strong> <span
            x-text="`${$store.order.rental_start} - ${$store.order.rental_end}`"></span>
      </p>

      <!-- Alamat -->
      <p><strong>Alamat:</strong> <span id="summary-address"
            x-text="$store.order.address"></span>
      </p>

      <!-- Tombol Checkout -->
      <div class="d-grid">
         <form x-ref="form" @submit.prevent="$store.order.submitOrder()">
            <div class="d-grid">
               <button type="submit"
                  class="btn btn-primary btn-lg d-flex align-items-center justify-content-center gap-2"
                  :disabled="$store.order.loading">
                  <template x-if="$store.order.loading">
                     <span class="spinner-border spinner-border-sm" role="status"
                        aria-hidden="true"></span>
                  </template>
                  <span
                     x-text="$store.order.loading ? 'Memproses...' : 'Checkout'"></span>
               </button>
            </div>
         </form>
      </div>
   </div>
</div>
