<div class="row mb-3">
   <div class="col-md-4 text-muted">Order ID</div>
   <div class="col-md-8 fw-bold">{{ $order->id }}</div>
</div>

<div class="row mb-3">
   <div class="col-md-4 text-muted">Nama Pemesan</div>
   <div class="col-md-8 fw-semibold">{{ $order->user->name }}</div>
</div>

<div class="row mb-3">
   <div class="col-md-4 text-muted">Tanggal Order</div>
   <div class="col-md-8">
      {{ \Carbon\Carbon::parse($order->order_date)->translatedFormat('d F Y H:i') }}
      WIB
   </div>
</div>

<div class="row mb-3">
   <div class="col-md-4 text-muted">Tanggal Sewa</div>
   <div class="col-md-8">
      {{ \Carbon\Carbon::parse($order->rental_start)->translatedFormat('d F Y') }}
      s/d
      {{ \Carbon\Carbon::parse($order->rental_end)->translatedFormat('d F Y') }}
   </div>
</div>

<div class="row mb-3">
   <div class="col-md-4 text-muted">Status Order</div>
   <div class="col-md-8">
      <span class="badge bg-{{ $order->getStatusClass() }}">
         {{ $order->getStatusLabel() }}
      </span>
   </div>
</div>

<div class="row mb-3">
   <div class="col-md-4 text-muted">Status Pembayaran</div>
   <div class="col-md-8">
      <span class="badge bg-{{ $order->getPaymentStatusClass() }}">
         {{ $order->getPaymentStatusLabel() }}
      </span>
   </div>
</div>

<div class="row mb-3">
   <div class="col-md-4 text-muted">Alamat Pengiriman</div>
   <div class="col-md-8">{{ $order->address }}</div>
</div>

<div class="row mb-3">
   <div class="col-md-4 text-muted">Catatan</div>
   <div class="col-md-8">{{ $order->notes ? $order->notes : '-' }}</div>
</div>

{{-- <div class="row mb-3">
   <div class="col-md-4 text-muted">Biaya Pengiriman</div>
   <div class="col-md-8 d-flex align-items-center justify-content-between">
      <span>Rp{{ number_format($order->delivery_fee, 0, ',', '.') }}</span>
      <button class="btn btn-sm btn-outline-primary ms-3" data-bs-toggle="modal"
         data-bs-target="#modalEditOngkir">
         <i class="bx bx-edit"></i> Edit
      </button>
   </div>
</div> --}}

{{-- <div class="row mb-3">
   <div class="col-md-4 text-muted">Total Harga</div>
   <div class="col-md-8">
      Rp{{ number_format($order->total_price, 0, ',', '.') }}</div>
</div> --}}

<div class="row">
   <div class="col-md-4 text-muted">Total Harga</div>
   <div class="col-md-8 fw-bold text-primary">
      Rp{{ number_format($order->total_price + $order->delivery_fee, 0, ',', '.') }}
   </div>
</div>
