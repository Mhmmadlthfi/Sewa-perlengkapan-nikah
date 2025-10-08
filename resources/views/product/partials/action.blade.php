{{-- Show --}}
<a href="{{ route('product.show', $product->id) }}"
   class="btn btn-sm btn-icon btn-outline-info">
   <i class='tf-icons bx bx-file-find'></i>
</a>

{{-- Edit --}}
<a href="{{ route('product.edit', $product->id) }}"
   class="btn btn-sm btn-icon btn-outline-warning ms-1">
   <i class='tf-icons bx bx-edit'></i>
</a>

{{-- Delete --}}
<form action="{{ route('product.destroy', $product->id) }}" method="post"
   class="d-inline ms-1">
   @method('delete')
   @csrf
   <button class="btn btn-sm btn-icon btn-outline-danger"
      onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')"
      @if (!$product->can_delete) disabled @endif>
      <i class='tf-icons bx bx-trash'></i>
   </button>
</form>
