@extends('layouts.app')

@section('title', 'Booking Details - Caravel')

@section('content')
<!-- subheader begin -->
<section id="subheader" class="jarallax text-light">
    <img src="{{ asset('images/background/subheader.jpg') }}" class="jarallax-img" alt="">
    <div class="center-y relative text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h1>Booking Details</h1>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</section>
<!-- subheader close -->

<section class="no-top">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fa fa-check-circle"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fa fa-exclamation-triangle"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">
                            <i class="fa fa-file-text"></i> Booking {{ $booking->booking_number }}
                        </h4>
                    </div>
                    <div class="card-body">
                        <!-- Status Badges -->
                        <div class="mb-4 text-center">
                            @php
                                $statusClass = match($booking->status) {
                                    'pending' => 'warning',
                                    'confirmed' => 'success',
                                    'completed' => 'info',
                                    'cancelled' => 'danger',
                                    default => 'secondary'
                                };
                                $paymentClass = match($booking->payment_status) {
                                    'pending' => 'warning',
                                    'paid' => 'success',
                                    'refunded' => 'info',
                                    'failed' => 'danger',
                                    default => 'secondary'
                                };
                            @endphp
                            <span class="badge bg-{{ $statusClass }} fs-5 me-2">
                                Status: {{ ucfirst($booking->status) }}
                            </span>
                            <span class="badge bg-{{ $paymentClass }} fs-5">
                                Payment: {{ ucfirst($booking->payment_status) }}
                            </span>
                        </div>

                        <hr>

                        <!-- Car Details -->
                        <h5 class="mb-3"><i class="fa fa-car"></i> Vehicle Information</h5>
                        <div class="row mb-4">
                            <div class="col-md-4">
                                @if($booking->car->image)
                                    @if(str_starts_with($booking->car->image, 'http'))
                                        <img src="{{ $booking->car->image }}" 
                                             alt="{{ $booking->car->make }} {{ $booking->car->model }}" 
                                             class="img-fluid rounded">
                                    @elseif(file_exists(public_path('storage/' . $booking->car->image)))
                                        <img src="{{ asset('storage/' . $booking->car->image) }}" 
                                             alt="{{ $booking->car->make }} {{ $booking->car->model }}" 
                                             class="img-fluid rounded">
                                    @elseif(file_exists(public_path('images/cars/' . $booking->car->image)))
                                        <img src="{{ asset('images/cars/' . $booking->car->image) }}" 
                                             alt="{{ $booking->car->make }} {{ $booking->car->model }}" 
                                             class="img-fluid rounded">
                                    @else
                                        <img src="{{ asset('images/cars/default-car.jpg') }}" 
                                             alt="Car" 
                                             class="img-fluid rounded">
                                    @endif
                                @elseif($booking->car->gallery && count($booking->car->gallery) > 0)
                                    <img src="{{ asset('storage/' . $booking->car->gallery[0]) }}" 
                                         alt="{{ $booking->car->make }} {{ $booking->car->model }}" 
                                         class="img-fluid rounded">
                                @else
                                    <img src="{{ asset('images/cars/default-car.jpg') }}" 
                                         alt="Car" 
                                         class="img-fluid rounded">
                                @endif
                            </div>
                            <div class="col-md-8">
                                <h4>{{ $booking->car->make }} {{ $booking->car->model }}</h4>
                                <p class="text-muted mb-2">{{ $booking->car->year }}</p>
                                <p><strong>Category:</strong> {{ ucfirst($booking->car->type) }}</p>
                                <p><strong>Transmission:</strong> {{ ucfirst($booking->car->transmission) }}</p>
                                <p><strong>Fuel Type:</strong> {{ ucfirst($booking->car->fuel_type) }}</p>
                            </div>
                        </div>

                        <hr>

                        <!-- Booking Details -->
                        <h5 class="mb-3"><i class="fa fa-calendar"></i> Booking Information</h5>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <p><strong>Pickup Location:</strong><br>{{ $booking->pickup_location }}</p>
                                <p><strong>Pickup Date:</strong><br>{{ $booking->pickup_date->format('l, F d, Y - h:i A') }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Drop-off Location:</strong><br>{{ $booking->dropoff_location }}</p>
                                <p><strong>Return Date:</strong><br>{{ $booking->return_date->format('l, F d, Y - h:i A') }}</p>
                            </div>
                        </div>

                        <hr>

                        <!-- Customer Details -->
                        <h5 class="mb-3"><i class="fa fa-user"></i> Customer Information</h5>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <p><strong>Name:</strong> {{ $booking->customer_name }}</p>
                                <p><strong>Email:</strong> {{ $booking->customer_email }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Phone:</strong> {{ $booking->customer_phone }}</p>
                                @if($booking->customer_address)
                                    <p><strong>Address:</strong><br>{{ $booking->customer_address }}</p>
                                @endif
                            </div>
                        </div>

                        @if($booking->special_requirements)
                            <div class="alert alert-info">
                                <strong><i class="fa fa-comment"></i> Special Requirements:</strong><br>
                                {{ $booking->special_requirements }}
                            </div>
                        @endif

                        <hr>

                        <!-- Pricing Details -->
                        <h5 class="mb-3"><i class="fa fa-money"></i> Pricing Details</h5>
                        <table class="table table-borderless">
                            <tr>
                                <td>Rental Period:</td>
                                <td class="text-end"><strong>{{ $booking->days }} day(s)</strong></td>
                            </tr>
                            <tr>
                                <td>Daily Rate:</td>
                                <td class="text-end">৳{{ number_format($booking->daily_rate * 110, 0) }}</td>
                            </tr>
                            <tr>
                                <td>Subtotal:</td>
                                <td class="text-end">৳{{ number_format($booking->total_amount * 110, 0) }}</td>
                            </tr>
                            <tr>
                                <td>Tax (10%):</td>
                                <td class="text-end">৳{{ number_format($booking->tax_amount * 110, 0) }}</td>
                            </tr>
                            @if($booking->discount_amount > 0)
                            <tr>
                                <td>Discount:</td>
                                <td class="text-end text-success">-৳{{ number_format($booking->discount_amount * 110, 0) }}</td>
                            </tr>
                            @endif
                            @if($booking->extras && count($booking->extras) > 0)
                            <tr>
                                <td>Extras:</td>
                                <td class="text-end">
                                    @foreach($booking->extras as $extra)
                                        <span class="badge bg-info">{{ ucfirst(str_replace('_', ' ', $extra)) }}</span>
                                    @endforeach
                                </td>
                            </tr>
                            @endif
                            <tr class="table-active">
                                <td><strong>Total Amount:</strong></td>
                                <td class="text-end"><strong class="fs-4 text-primary">৳{{ number_format($booking->final_amount * 110, 0) }}</strong></td>
                            </tr>
                        </table>

                        <hr>

                        <!-- Payment Information -->
                        <h5 class="mb-3"><i class="fa fa-credit-card"></i> Payment Information</h5>
                        @php
                            $paymentMethods = [
                                'bkash' => 'bKash',
                                'nagad' => 'Nagad',
                                'rocket' => 'Rocket',
                                'upay' => 'Upay',
                                'credit_card' => 'Credit Card',
                                'debit_card' => 'Debit Card',
                                'cash' => 'Cash',
                                'pending' => 'Not Selected Yet'
                            ];
                        @endphp
                        
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <p><strong>Payment Method:</strong><br>
                                    @if($booking->payment_method === 'pending')
                                        <span class="badge bg-secondary text-white fs-6">
                                            <i class="fa fa-clock-o"></i> Not Selected Yet
                                        </span>
                                    @else
                                        <span class="badge bg-info text-white fs-6">
                                            {{ $paymentMethods[$booking->payment_method] ?? ucfirst(str_replace('_', ' ', $booking->payment_method)) }}
                                        </span>
                                    @endif
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Payment Status:</strong><br>
                                    @if($booking->payment_status === 'paid')
                                        <span class="badge bg-success fs-6">Paid</span>
                                    @elseif($booking->payment_status === 'pending')
                                        <span class="badge bg-warning text-dark fs-6">Pending</span>
                                    @elseif($booking->payment_status === 'failed')
                                        <span class="badge bg-danger fs-6">Failed</span>
                                    @else
                                        <span class="badge bg-secondary fs-6">{{ ucfirst($booking->payment_status) }}</span>
                                    @endif
                                </p>
                            </div>
                        </div>

                        @if($booking->transaction_id)
                            <div class="alert alert-success">
                                <strong><i class="fa fa-check-circle"></i> Transaction ID:</strong> {{ $booking->transaction_id }}
                            </div>
                        @endif

                        <!-- Payment Section (if payment is pending) -->
                        @if($booking->payment_status === 'pending' && $booking->status !== 'cancelled')
                            <div class="alert alert-warning">
                                <i class="fa fa-exclamation-triangle"></i> <strong>Payment Required:</strong> Please complete your payment to confirm this booking.
                            </div>

                            <div class="card border-primary mb-4">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0"><i class="fa fa-money"></i> Complete Payment</h5>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('bookings.payment', $booking) }}" method="POST" id="paymentForm">
                                        @csrf
                                        
                                        <div class="mb-3">
                                            <label class="form-label"><strong>Select Payment Method:</strong></label>
                                            <select name="payment_method" id="paymentMethodSelect" class="form-select form-control" required>
                                                <option value="">-- Choose Payment Method --</option>
                                                
                                                <optgroup label="Mobile Banking (Bangladesh)">
                                                    <option value="bkash" {{ $booking->payment_method === 'bkash' ? 'selected' : '' }}>
                                                        💳 bKash - Mobile Banking
                                                    </option>
                                                    <option value="nagad" {{ $booking->payment_method === 'nagad' ? 'selected' : '' }}>
                                                        💳 Nagad - Mobile Banking
                                                    </option>
                                                    <option value="rocket" {{ $booking->payment_method === 'rocket' ? 'selected' : '' }}>
                                                        💳 Rocket - Mobile Banking
                                                    </option>
                                                    <option value="upay" {{ $booking->payment_method === 'upay' ? 'selected' : '' }}>
                                                        💳 Upay - Mobile Banking
                                                    </option>
                                                </optgroup>
                                                
                                                <optgroup label="Card Payment">
                                                    <option value="credit_card" {{ $booking->payment_method === 'credit_card' ? 'selected' : '' }}>
                                                        💳 Credit Card
                                                    </option>
                                                    <option value="debit_card" {{ $booking->payment_method === 'debit_card' ? 'selected' : '' }}>
                                                        💳 Debit Card
                                                    </option>
                                                </optgroup>
                                                
                                                <optgroup label="Other Methods">
                                                    <option value="cash" {{ $booking->payment_method === 'cash' ? 'selected' : '' }}>
                                                        💵 Cash on Pickup
                                                    </option>
                                                </optgroup>
                                            </select>
                                        </div>

                                        <!-- Payment Instructions based on method -->
                                        <div id="paymentInstructions" class="mb-3" style="display: none;">
                                            <!-- Mobile Banking Instructions -->
                                            <div id="mobileBankingInstructions" class="payment-instruction" style="display: none;">
                                                <div class="alert alert-info">
                                                    <h6><i class="fa fa-mobile"></i> Mobile Banking Payment Instructions:</h6>
                                                    <ol class="mb-2">
                                                        <li>Open your mobile banking app</li>
                                                        <li>Select "Send Money" or "Payment"</li>
                                                        <li>Enter the merchant number: <strong>01700-000000</strong></li>
                                                        <li>Amount: <strong>৳{{ number_format($booking->final_amount * 110, 0) }}</strong></li>
                                                        <li>Reference: <strong>{{ $booking->booking_number }}</strong></li>
                                                        <li>Complete the payment and note the transaction ID</li>
                                                    </ol>
                                                    <p class="mb-0"><small><i class="fa fa-info-circle"></i> You will receive a confirmation SMS after successful payment.</small></p>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Transaction ID / Reference Number:</label>
                                                    <input type="text" name="transaction_id" id="transactionIdInput" class="form-control" 
                                                           placeholder="Enter your transaction ID">
                                                    <small class="text-muted">Enter the transaction ID from your mobile banking app</small>
                                                </div>
                                            </div>

                                            <!-- Card Payment Instructions -->
                                            <div id="cardInstructions" class="payment-instruction" style="display: none;">
                                                <div class="alert alert-info">
                                                    <h6><i class="fa fa-credit-card"></i> Card Payment:</h6>
                                                    <p>You will be redirected to secure payment gateway to complete your card payment.</p>
                                                </div>
                                            </div>

                                            <!-- Cash Payment Instructions -->
                                            <div id="cashInstructions" class="payment-instruction" style="display: none;">
                                                <div class="alert alert-success">
                                                    <h6><i class="fa fa-money"></i> Cash Payment:</h6>
                                                    <p>You can pay cash when picking up the vehicle. Please bring the exact amount of <strong>৳{{ number_format($booking->final_amount * 110, 0) }}</strong></p>
                                                    <p class="mb-0"><small><i class="fa fa-info-circle"></i> Booking reference: {{ $booking->booking_number }}</small></p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong>Total Amount:</strong>
                                                <h4 class="text-primary mb-0">৳{{ number_format($booking->final_amount * 110, 0) }}</h4>
                                            </div>
                                            <button type="submit" class="btn btn-primary btn-lg">
                                                <i class="fa fa-check"></i> Confirm Payment
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <script>
                                document.getElementById('paymentMethodSelect').addEventListener('change', function() {
                                    const method = this.value;
                                    const instructionsDiv = document.getElementById('paymentInstructions');
                                    const allInstructions = document.querySelectorAll('.payment-instruction');
                                    const transactionIdInput = document.getElementById('transactionIdInput');
                                    
                                    // Hide all instructions first
                                    allInstructions.forEach(inst => inst.style.display = 'none');
                                    
                                    // Remove required from transaction ID by default
                                    if (transactionIdInput) {
                                        transactionIdInput.removeAttribute('required');
                                    }
                                    
                                    if (method) {
                                        instructionsDiv.style.display = 'block';
                                        
                                        // Show relevant instructions
                                        if (['bkash', 'nagad', 'rocket', 'upay'].includes(method)) {
                                            document.getElementById('mobileBankingInstructions').style.display = 'block';
                                            // Make transaction ID required for mobile banking
                                            if (transactionIdInput) {
                                                transactionIdInput.setAttribute('required', 'required');
                                            }
                                        } else if (['credit_card', 'debit_card'].includes(method)) {
                                            document.getElementById('cardInstructions').style.display = 'block';
                                        } else if (method === 'cash') {
                                            document.getElementById('cashInstructions').style.display = 'block';
                                        }
                                    } else {
                                        instructionsDiv.style.display = 'none';
                                    }
                                });

                                // Trigger change event if method is pre-selected
                                if (document.getElementById('paymentMethodSelect').value) {
                                    document.getElementById('paymentMethodSelect').dispatchEvent(new Event('change'));
                                }
                            </script>
                        @endif

                        <!-- Action Buttons -->
                        <div class="mt-4 d-flex gap-2 justify-content-center flex-wrap">
                            <a href="{{ route('bookings.index') }}" class="btn btn-secondary">
                                <i class="fa fa-arrow-left"></i> Back to Bookings
                            </a>
                            
                            @if($booking->status === 'pending')
                                <a href="{{ route('bookings.edit', $booking) }}" class="btn btn-warning">
                                    <i class="fa fa-edit"></i> Edit Booking
                                </a>
                            @endif

                            @if($booking->payment_status === 'paid')
                                <a href="{{ route('bookings.receipt', $booking) }}" class="btn btn-info" target="_blank">
                                    <i class="fa fa-print"></i> Print Receipt
                                </a>
                            @endif

                            @if($booking->status !== 'cancelled' && $booking->status !== 'completed')
                                <form action="{{ route('bookings.cancel', $booking) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to cancel this booking?');">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fa fa-times"></i> Cancel Booking
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
