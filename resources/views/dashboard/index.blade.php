{{-- @extends('layouts.main')

@section('container')
   <div class="container-xxl flex-grow-1 container-p-y">
      <h6 class="fw-bold py-3 mb-4">
         <span class="text-muted fw-light">Dashboard /</span> Halaman Dashboard
      </h6>

      <!-- Summary Cards -->
      <div class="row mb-4">
         <!-- Categories Card -->
         <div class="col-md-4 mb-4">
            <div class="card h-100 border-top border-primary border-3">
               <div class="card-body text-end">
                  <h5 class="card-title text-start">Kategori Produk</h5>
                  <p class="display-5 fw-bold">{{ $categories }}</p>
</div>
</div>
</div>

<!-- Products Card -->
<div class="col-md-4 mb-4">
   <div class="card h-100 border-top border-success border-3">
      <div class="card-body text-end">
         <h5 class="card-title text-start">Produk</h5>
         <p class="display-5 fw-bold">{{ $products }}</p>
      </div>
   </div>
</div>

<!-- Users Card -->
<div class="col-md-4 mb-4">
   <div class="card h-100 border-top border-info border-3">
      <div class="card-body text-end">
         <h5 class="card-title text-start">Pengguna</h5>
         <p class="display-5 fw-bold">{{ $users }}</p>
      </div>
   </div>
</div>
</div>

<!-- Order Status Cards -->
<div class="row mb-4">
   <div class="col-12 mb-3">
      <h5 class="fw-bold">Status Order</h5>
   </div>

   <!-- Pending Orders -->
   <div class="col-md-4 mb-4">
      <div class="card h-100 border-top border-primary border-3">
         <div class="card-body text-end">
            <h5 class="card-title text-start">Pending</h5>
            <p class="display-5 fw-bold">{{ $order_status['pending'] }}</p>
         </div>
      </div>
   </div>

   <!-- Confirmed Orders -->
   <div class="col-md-4 mb-4">
      <div class="card h-100 border-top border-info border-3">
         <div class="card-body text-end">
            <h5 class="card-title text-start">Confirmed</h5>
            <p class="display-5 fw-bold">{{ $order_status['confirmed'] }}</p>
         </div>
      </div>
   </div>

   <!-- Ongoing Orders -->
   <div class="col-md-4 mb-4">
      <div class="card h-100 border-top border-warning border-3">
         <div class="card-body text-end">
            <h5 class="card-title text-start">Ongoing</h5>
            <p class="display-5 fw-bold">{{ $order_status['ongoing'] }}</p>
         </div>
      </div>
   </div>

   <!-- Completed Orders -->
   <div class="col-md-4 mb-4">
      <div class="card h-100 border-top border-success border-3">
         <div class="card-body text-end">
            <h5 class="card-title text-start">Completed</h5>
            <p class="display-5 fw-bold">{{ $order_status['completed'] }}</p>
         </div>
      </div>
   </div>

   <!-- Cancelled Orders -->
   <div class="col-md-4 mb-4">
      <div class="card h-100 border-top border-danger border-3">
         <div class="card-body text-end">
            <h5 class="card-title text-start">Cancelled</h5>
            <p class="display-5 fw-bold">{{ $order_status['cancelled'] }}</p>
         </div>
      </div>
   </div>
</div>

<!-- Payment Status Cards -->
<div class="row">
   <div class="col-12 mb-3">
      <h5 class="fw-bold">Status Pembayaran</h5>
   </div>

   <!-- Paid Orders -->
   <div class="col-md-6 mb-4">
      <div class="card h-100 border-top border-success border-3">
         <div class="card-body text-end">
            <h5 class="card-title text-start">Paid</h5>
            <p class="display-5 fw-bold">{{ $payment_status['paid'] }}</p>
         </div>
      </div>
   </div>

   <!-- Unpaid Orders -->
   <div class="col-md-6 mb-4">
      <div class="card h-100 border-top border-danger border-3">
         <div class="card-body text-end">
            <h5 class="card-title text-start">Unpaid</h5>
            <p class="display-5 fw-bold">{{ $payment_status['unpaid'] }}</p>
         </div>
      </div>
   </div>
</div>
</div>
@endsection --}}

@extends('layouts.main')

@section('container')
<div class="container-xxl flex-grow-1 container-p-y">
   <h6 class="fw-bold py-3 mb-4">
      <span class="text-muted fw-light">Dashboard /</span> Halaman Dashboard
   </h6>

   <!-- Summary Cards -->
   <div class="row mb-4">
      <!-- Categories Card -->
      <div class="col-md-4 mb-4">
         <div class="card h-100">
            <div class="card-body">
               <div class="d-flex justify-content-between align-items-end">
                  <h5 class="card-title mb-0">Kategori Produk</h5>
                  <p class="display-5 fw-bold mb-0 text-primary">{{ $categories }}</p>
               </div>
               <div class="border-bottom border-primary border-3 mt-3"></div>
            </div>
         </div>
      </div>

      <!-- Products Card -->
      <div class="col-md-4 mb-4">
         <div class="card h-100">
            <div class="card-body">
               <div class="d-flex justify-content-between align-items-end">
                  <h5 class="card-title mb-0">Produk</h5>
                  <p class="display-5 fw-bold mb-0 text-success">{{ $products }}</p>
               </div>
               <div class="border-bottom border-success border-3 mt-3"></div>
            </div>
         </div>
      </div>

      <!-- Users Card -->
      <div class="col-md-4 mb-4">
         <div class="card h-100">
            <div class="card-body">
               <div class="d-flex justify-content-between align-items-end">
                  <h5 class="card-title mb-0">Customer</h5>
                  <p class="display-5 fw-bold mb-0 text-info">{{ $users }}</p>
               </div>
               <div class="border-bottom border-info border-3 mt-3"></div>
            </div>
         </div>
      </div>
   </div>

   <!-- Order Status Cards -->
   <div class="row mb-4">
      <div class="col-12 mb-3">
         <h5 class="fw-bold">Status Order</h5>
      </div>

      <!-- Pending Orders -->
      <div class="col-md-4 mb-4">
         <div class="card h-100">
            <div class="card-body">
               <div class="d-flex justify-content-between align-items-end">
                  <h5 class="card-title mb-0">Pending</h5>
                  <p class="display-5 fw-bold mb-0 text-primary">
                     {{ $order_status['pending'] }}
                  </p>
               </div>
               <div class="border-bottom border-primary border-3 mt-3"></div>
            </div>
         </div>
      </div>

      <!-- Confirmed Orders -->
      <div class="col-md-4 mb-4">
         <div class="card h-100">
            <div class="card-body">
               <div class="d-flex justify-content-between align-items-end">
                  <h5 class="card-title mb-0">Confirmed</h5>
                  <p class="display-5 fw-bold mb-0 text-info">
                     {{ $order_status['confirmed'] }}
                  </p>
               </div>
               <div class="border-bottom border-info border-3 mt-3"></div>
            </div>
         </div>
      </div>

      <!-- Ongoing Orders -->
      <div class="col-md-4 mb-4">
         <div class="card h-100">
            <div class="card-body">
               <div class="d-flex justify-content-between align-items-end">
                  <h5 class="card-title mb-0">Ongoing</h5>
                  <p class="display-5 fw-bold mb-0 text-warning">
                     {{ $order_status['ongoing'] }}
                  </p>
               </div>
               <div class="border-bottom border-warning border-3 mt-3"></div>
            </div>
         </div>
      </div>

      <!-- Completed Orders -->
      <div class="col-md-4 mb-4">
         <div class="card h-100">
            <div class="card-body">
               <div class="d-flex justify-content-between align-items-end">
                  <h5 class="card-title mb-0">Completed</h5>
                  <p class="display-5 fw-bold mb-0 text-success">
                     {{ $order_status['completed'] }}
                  </p>
               </div>
               <div class="border-bottom border-success border-3 mt-3"></div>
            </div>
         </div>
      </div>

      <!-- Cancelled Orders -->
      <div class="col-md-4 mb-4">
         <div class="card h-100">
            <div class="card-body">
               <div class="d-flex justify-content-between align-items-end">
                  <h5 class="card-title mb-0">Cancelled</h5>
                  <p class="display-5 fw-bold mb-0 text-danger">
                     {{ $order_status['cancelled'] }}
                  </p>
               </div>
               <div class="border-bottom border-danger border-3 mt-3"></div>
            </div>
         </div>
      </div>
   </div>

   <!-- Payment Status Cards -->
   <div class="row">
      <div class="col-12 mb-3">
         <h5 class="fw-bold">Status Pembayaran</h5>
      </div>

      <!-- Paid Orders -->
      <div class="col-md-6 mb-4">
         <div class="card h-100">
            <div class="card-body">
               <div class="d-flex justify-content-between align-items-end">
                  <h5 class="card-title mb-0">Paid</h5>
                  <p class="display-5 fw-bold mb-0 text-success">
                     {{ $payment_status['paid'] }}
                  </p>
               </div>
               <div class="border-bottom border-success border-3 mt-3"></div>
            </div>
         </div>
      </div>

      <!-- Unpaid Orders -->
      <div class="col-md-6 mb-4">
         <div class="card h-100">
            <div class="card-body">
               <div class="d-flex justify-content-between align-items-end">
                  <h5 class="card-title mb-0">Unpaid</h5>
                  <p class="display-5 fw-bold mb-0 text-danger">
                     {{ $payment_status['unpaid'] }}
                  </p>
               </div>
               <div class="border-bottom border-danger border-3 mt-3"></div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection