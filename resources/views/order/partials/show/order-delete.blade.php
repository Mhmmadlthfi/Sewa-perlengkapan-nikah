<form action="{{ route('order.destroy', $order->id) }}" method="POST"
   onsubmit="return confirm('Yakin ingin menghapus order ini?')" class="d-inline">
   @csrf
   @method('DELETE')
   <button class="btn btn-sm btn-outline-danger" type="submit">Hapus</button>
</form>
