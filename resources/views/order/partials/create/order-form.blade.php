<form>

   <div class="mb-3">
      <label for="user" class="form-label">Pilih Customer</label>
      <select id="user" class="user-select form-control"
         :class="{ 'is-invalid': $store.order.errors.user }">
      </select>
      <div class="invalid-feedback" x-show="$store.order.errors.user">
         Harap pilih customer terlebih dahulu.
      </div>
   </div>

   <div class="mb-3">
      <label for="product" class="form-label">Pilih Produk</label>
      <select id="product" class="product-select form-control"
         :class="{ 'is-invalid': $store.order.errors.items }">
      </select>
      <div class="invalid-feedback" x-show="$store.order.errors.items">
         Harap pilih minimal satu produk.
      </div>
   </div>

   <div x-data="{ today: new Date().toISOString().split('T')[0] }" class="mb-3">
      <label for="rental_start" class="form-label">Tanggal Mulai
         Rental</label>
      <input type="date" x-model="$store.order.rental_start" :min="today"
         class="form-control" id="rental_start" name="rental_start"
         :class="{ 'is-invalid': $store.order.errors.rental_start }">
      <div class="invalid-feedback" x-show="$store.order.errors.rental_start">
         Tanggal mulai rental wajib diisi.
      </div>
   </div>

   <div class="mb-3">
      <label for="rental_end" class="form-label">Tanggal Akhir
         Rental</label>
      <input type="date" x-model="$store.order.rental_end" id="rental_end"
         name="rental_end" class="form-control" :min="$store.order.minRentalEnd"
         :class="{ 'is-invalid': $store.order.errors.rental_end }" />
      <div class="invalid-feedback" x-show="$store.order.errors.rental_end">
         Tanggal akhir rental wajib diisi.
      </div>
   </div>

   <div class="mb-3">
      <label for="address" class="form-label">Alamat Pengiriman</label>
      <textarea class="form-control" name="address" x-model="$store.order.address"
         :class="{ 'is-invalid': $store.order.errors.address }"></textarea>
      <div class="invalid-feedback" x-show="$store.order.errors.address">
         Alamat pengiriman wajib diisi.
      </div>
   </div>

   {{-- <div class="mb-3" x-data="{ tempFee: $store.order.delivery_fee }">
      <label for="delivery_fee" class="form-label">Biaya Ongkir
         Tambahan</label>
      <input type="number" class="form-control" id="delivery_fee" name="delivery_fee"
         :class="{ 'is-invalid': tempFee < 0 }" x-model="tempFee"
         @input="if (tempFee >= 0) {$store.order.delivery_fee = tempFee;}">
      <div class="invalid-feedback" x-show="tempFee < 0">
         Biaya ongkir tidak boleh kurang dari 0.
      </div>
   </div> --}}

   <div class="mb-3">
      <label for="notes" class="form-label">Catatan</label>
      <textarea x-model="$store.order.notes" class="form-control" id="notes" name="notes"
         rows="2"></textarea>
   </div>

</form>
