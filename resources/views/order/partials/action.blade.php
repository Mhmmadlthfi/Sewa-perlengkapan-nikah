{{-- Show --}}
<a href="{{ route('order.show', $order->id) }}"
   class="btn btn-sm btn-icon btn-outline-info">
   <i class='bx bx-file-find'></i>
</a>

{{-- Delete --}}
<form action="{{ route('order.destroy', $order->id) }}" method="post" class="d-inline ms-1">
   @csrf
   @method('DELETE')
   <button class="btn btn-sm btn-icon btn-outline-danger"
      onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')">
      <i class='bx bx-trash'></i>
   </button>
</form>