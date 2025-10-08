{{-- Modal Export Produk --}}
<div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exportModalLabel"
   aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">Export Data Produk</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"
               aria-label="Close"></button>
         </div>
         <form action="{{ route('product.export') }}" method="POST" id="exportForm">
            @csrf
            <div class="modal-body">
               <div class="mb-3">
                  <label for="category" class="form-label">Kategori</label>
                  <select class="form-select" name="category_id" id="category">
                     <option value="">Semua</option>
                     @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                     @endforeach
                  </select>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary"
                  data-bs-dismiss="modal">Close</button>
               <button type="submit" class="btn btn-primary">Export</button>
            </div>
         </form>
      </div>
   </div>
</div>

{{-- Script untuk menutup modal setelah submit --}}
<script>
   document.getElementById('exportForm').addEventListener('submit', function() {
      const modal = bootstrap.Modal.getInstance(document.getElementById(
         'exportModal'));
      modal.hide();
   });
</script>
