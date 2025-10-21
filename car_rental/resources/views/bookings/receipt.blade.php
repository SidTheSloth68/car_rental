<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Receipt - {{ $booking->booking_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            padding: 20px;
        }
        .receipt-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            border: 1px solid #ddd;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #007bff;
            padding-bottom: 20px;
        }
        .header h1 {
            color: #007bff;
            margin-bottom: 5px;
        }
        .booking-number {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin: 15px 0;
        }
        .status-badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: bold;
            margin: 5px;
        }
        .status-confirmed { background: #28a745; color: white; }
        .status-pending { background: #ffc107; color: #333; }
        .status-paid { background: #28a745; color: white; }
        .section {
            margin: 25px 0;
        }
        .section-title {
            font-size: 18px;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 2px solid #007bff;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-top: 15px;
        }
        .info-item {
            padding: 10px;
            background: #f8f9fa;
            border-left: 3px solid #007bff;
        }
        .info-label {
            font-weight: bold;
            color: #666;
            font-size: 12px;
            text-transform: uppercase;
        }
        .info-value {
            color: #333;
            font-size: 15px;
            margin-top: 3px;
        }
        .car-info {
            background: #e9ecef;
            padding: 20px;
            border-radius: 5px;
            margin: 15px 0;
        }
        .car-info h3 {
            color: #007bff;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background: #007bff;
            color: white;
            font-weight: bold;
        }
        .total-row {
            font-weight: bold;
            font-size: 18px;
            background: #f8f9fa;
        }
        .total-row td {
            border-top: 2px solid #007bff;
            padding-top: 15px;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            padding-top: 20px;
            border-top: 2px solid #ddd;
            color: #666;
            font-size: 14px;
        }
        .print-button {
            text-align: center;
            margin: 20px 0;
        }
        .btn {
            display: inline-block;
            padding: 10px 30px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }
        .btn:hover {
            background: #0056b3;
        }
        @media print {
            .print-button {
                display: none;
            }
            body {
                padding: 0;
            }
        }
    </style>
</head>
<body>
    <div class="receipt-container">
        <div class="header">
            <h1>CARAVEL CAR RENTAL</h1>
            <p>Premium Car Rental Services</p>
            <div class="booking-number">Booking Receipt #{{ $booking->booking_number }}</div>
            <div>
                <span class="status-badge status-{{ strtolower($booking->status) }}">
                    {{ ucfirst($booking->status) }}
                </span>
                <span class="status-badge status-{{ strtolower($booking->payment_status) }}">
                    Payment: {{ ucfirst($booking->payment_status) }}
                </span>
            </div>
        </div>

        <div class="print-button">
            <button onclick="window.print()" class="btn">🖨️ Print Receipt</button>
            <a href="{{ route('bookings.show', $booking) }}" class="btn" style="background: #6c757d;">← Back to Booking</a>
        </div>

        <!-- Car Information -->
        <div class="section">
            <div class="section-title">Vehicle Information</div>
            <div class="car-info">
                <h3>{{ $booking->car->make }} {{ $booking->car->model }} ({{ $booking->car->year }})</h3>
                <div class="info-grid">
                    <div>
                        <strong>Type:</strong> {{ ucfirst($booking->car->type) }}<br>
                        <strong>Transmission:</strong> {{ ucfirst($booking->car->transmission) }}
                    </div>
                    <div>
                        <strong>Fuel:</strong> {{ ucfirst($booking->car->fuel_type) }}<br>
                        <strong>Seats:</strong> {{ $booking->car->seats }} passengers
                    </div>
                </div>
            </div>
        </div>

        <!-- Booking Details -->
        <div class="section">
            <div class="section-title">Booking Details</div>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Pickup Location</div>
                    <div class="info-value">{{ $booking->pickup_location }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Drop-off Location</div>
                    <div class="info-value">{{ $booking->dropoff_location }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Pickup Date & Time</div>
                    <div class="info-value">{{ $booking->pickup_date->format('l, F d, Y - h:i A') }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Return Date & Time</div>
                    <div class="info-value">{{ $booking->return_date->format('l, F d, Y - h:i A') }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Rental Duration</div>
                    <div class="info-value">{{ $booking->days }} day(s)</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Booking Date</div>
                    <div class="info-value">{{ $booking->created_at->format('F d, Y') }}</div>
                </div>
            </div>
        </div>

        <!-- Customer Information -->
        <div class="section">
            <div class="section-title">Customer Information</div>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Name</div>
                    <div class="info-value">{{ $booking->customer_name }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Email</div>
                    <div class="info-value">{{ $booking->customer_email }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Phone</div>
                    <div class="info-value">{{ $booking->customer_phone }}</div>
                </div>
                @if($booking->customer_address)
                <div class="info-item">
                    <div class="info-label">Address</div>
                    <div class="info-value">{{ $booking->customer_address }}</div>
                </div>
                @endif
            </div>
        </div>

        <!-- Pricing Breakdown -->
        <div class="section">
            <div class="section-title">Payment Summary</div>
            <table>
                <thead>
                    <tr>
                        <th>Description</th>
                        <th style="text-align: right;">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Daily Rate (৳{{ number_format($booking->daily_rate * 110, 0) }} × {{ $booking->days }} day{{ $booking->days > 1 ? 's' : '' }})</td>
                        <td style="text-align: right;">৳{{ number_format($booking->total_amount * 110, 0) }}</td>
                    </tr>
                    @if($booking->extras && count($booking->extras) > 0)
                        @foreach($booking->extras as $extra)
                            <tr>
                                <td>{{ ucfirst(str_replace('_', ' ', $extra)) }} 
                                    @if($extra === 'insurance')
                                        (৳1,650/day × {{ $booking->days }} day{{ $booking->days > 1 ? 's' : '' }})
                                    @elseif($extra === 'gps')
                                        (৳550/day × {{ $booking->days }} day{{ $booking->days > 1 ? 's' : '' }})
                                    @elseif($extra === 'child_seat')
                                        (৳880/day × {{ $booking->days }} day{{ $booking->days > 1 ? 's' : '' }})
                                    @endif
                                </td>
                                <td style="text-align: right;">
                                    @if($extra === 'insurance')
                                        ৳{{ number_format(1650 * $booking->days, 0) }}
                                    @elseif($extra === 'gps')
                                        ৳{{ number_format(550 * $booking->days, 0) }}
                                    @elseif($extra === 'child_seat')
                                        ৳{{ number_format(880 * $booking->days, 0) }}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    <tr>
                        <td>Tax (10%)</td>
                        <td style="text-align: right;">৳{{ number_format($booking->tax_amount * 110, 0) }}</td>
                    </tr>
                    @if($booking->discount_amount > 0)
                    <tr style="color: #28a745;">
                        <td>Discount</td>
                        <td style="text-align: right;">-৳{{ number_format($booking->discount_amount * 110, 0) }}</td>
                    </tr>
                    @endif
                    <tr class="total-row">
                        <td><strong>TOTAL AMOUNT</strong></td>
                        <td style="text-align: right;"><strong>৳{{ number_format($booking->final_amount * 110, 0) }}</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Payment Information -->
        <div class="section">
            <div class="section-title">Payment Information</div>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Payment Method</div>
                    <div class="info-value">
                        @php
                            $paymentMethods = [
                                'bkash' => 'bKash',
                                'nagad' => 'Nagad',
                                'rocket' => 'Rocket',
                                'upay' => 'Upay',
                                'credit_card' => 'Credit Card',
                                'debit_card' => 'Debit Card',
                                'cash' => 'Cash'
                            ];
                        @endphp
                        {{ $paymentMethods[$booking->payment_method] ?? ucfirst(str_replace('_', ' ', $booking->payment_method)) }}
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-label">Payment Status</div>
                    <div class="info-value">{{ ucfirst($booking->payment_status) }}</div>
                </div>
                @if($booking->transaction_id)
                <div class="info-item">
                    <div class="info-label">Transaction ID</div>
                    <div class="info-value">{{ $booking->transaction_id }}</div>
                </div>
                @endif
            </div>
        </div>

        @if($booking->special_requirements)
        <div class="section">
            <div class="section-title">Special Requirements</div>
            <div style="padding: 15px; background: #f8f9fa; border-left: 3px solid #007bff;">
                {{ $booking->special_requirements }}
            </div>
        </div>
        @endif

        <div class="footer">
            <p><strong>Thank you for choosing Caravel Car Rental!</strong></p>
            <p>For any queries, please contact us at: support@caravel.com | +880-1234-567890</p>
            <p style="margin-top: 10px; font-size: 12px;">
                This is a computer-generated receipt. No signature required.
            </p>
        </div>
    </div>
</body>
</html>
