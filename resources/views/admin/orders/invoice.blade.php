<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Order #{{ $order->order_number }}</title>
    <style>
        body {
            /* DejaVu Sans renders Unicode (₹) correctly in Dompdf */
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            line-height: 1.55;
            color: #222;
        }
        .container {
            max-width: 820px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            display: table;
            width: 100%;
            border-bottom: 2px solid #4CAF50;
            padding-bottom: 14px;
            margin-bottom: 18px;
        }
        .header-left, .header-right {
            display: table-cell;
            vertical-align: top;
        }
        .brand {
            font-size: 22px;
            font-weight: 700;
            color: #4CAF50;
            letter-spacing: 0.5px;
        }
        .muted { color: #666; font-size: 11px; }
        .title {
            text-align: right;
            font-size: 18px;
            font-weight: 700;
            margin: 0;
        }
        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-weight: 700;
            font-size: 10px;
            letter-spacing: 0.3px;
            text-transform: uppercase;
        }
        .b-pending { background: #fff3cd; color: #856404; }
        .b-processing { background: #cce5ff; color: #004085; }
        .b-shipped { background: #d1ecf1; color: #0c5460; }
        .b-delivered { background: #d4edda; color: #155724; }
        .b-cancelled { background: #f8d7da; color: #721c24; }
        .b-inquiry { background: #e2e3e5; color: #383d41; }

        .grid {
            display: table;
            width: 100%;
            margin-bottom: 14px;
        }
        .col {
            display: table-cell;
            width: 50%;
            vertical-align: top;
        }
        .box {
            background: #f9f9f9;
            border: 1px solid #eee;
            border-radius: 6px;
            padding: 12px;
            margin-right: 10px;
        }
        .box.right { margin-right: 0; margin-left: 10px; }
        .box h3 {
            margin: 0 0 8px 0;
            font-size: 13px;
            color: #4CAF50;
        }
        .kv { margin: 4px 0; }
        .kv strong { display: inline-block; width: 110px; }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th {
            background: #4CAF50;
            color: #fff;
            padding: 10px;
            font-size: 11px;
            text-align: left;
        }
        td {
            padding: 9px 10px;
            border-bottom: 1px solid #eee;
            vertical-align: top;
        }
        .text-right { text-align: right; }
        .text-center { text-align: center; }

        .totals {
            margin-top: 14px;
            width: 100%;
        }
        .totals-row {
            display: table;
            width: 100%;
            margin: 3px 0;
        }
        .totals-label, .totals-value {
            display: table-cell;
            padding: 2px 0;
        }
        .totals-label {
            text-align: right;
            color: #444;
        }
        .totals-value {
            width: 140px;
            text-align: right;
            font-weight: 700;
        }
        .grand {
            border-top: 2px solid #4CAF50;
            padding-top: 8px;
            margin-top: 8px;
            font-size: 14px;
            color: #2e7d32;
        }
        .footer {
            margin-top: 24px;
            padding-top: 12px;
            border-top: 1px solid #eee;
            text-align: center;
            font-size: 11px;
            color: #666;
        }
    </style>
</head>
<body>
    @php
        $statusClass = match($order->order_status) {
            'pending' => 'b-pending',
            'processing' => 'b-processing',
            'shipped' => 'b-shipped',
            'delivered' => 'b-delivered',
            'cancelled' => 'b-cancelled',
            'inquiry' => 'b-inquiry',
            default => 'b-pending'
        };
    @endphp

    <div class="container">
        <div class="header">
            <div class="header-left">
                <div style="display: table;">
                    <div style="display: table-cell; vertical-align: middle; padding-right: 10px;">
                        <img src="{{ public_path('assets/logo/logo.png') }}" alt="Greenleaf" style="height: 44px;">
                    </div>
                    <div style="display: table-cell; vertical-align: middle;">
                        <div class="brand">GREENLEAF</div>
                        <div class="muted">Agricultural Equipment & Supplies</div>
                    </div>
                </div>
            </div>
            <div class="header-right">
                <p class="title">ORDER</p>
                <div style="text-align:right" class="muted">
                    <div><strong>Order No:</strong> {{ $order->order_number }}</div>
                    <div><strong>Date:</strong> {{ $order->created_at->format('d M, Y') }}</div>
                    <div style="margin-top:6px;">
                        <span class="badge {{ $statusClass }}">{{ $order->order_status === 'inquiry' ? 'INQUIRY' : strtoupper($order->order_status) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid">
            <div class="col">
                <div class="box">
                    <h3>Billed To</h3>
                    <div class="kv"><strong>Name:</strong> {{ $order->customer_name }}</div>
                    <div class="kv"><strong>Email:</strong> {{ $order->customer_email }}</div>
                    @if($order->customer_phone)
                        <div class="kv"><strong>Phone:</strong> {{ $order->customer_phone }}</div>
                    @endif
                </div>
            </div>
            <div class="col">
                <div class="box right">
                    <h3>Order Details</h3>
                    <div class="kv"><strong>Order No:</strong> {{ $order->order_number }}</div>
                    <div class="kv"><strong>Payment:</strong> {{ ucfirst(str_replace('_', ' ', $order->payment_status)) }}</div>
                    <div class="kv"><strong>Method:</strong> {{ $order->payment_method ? ucfirst(str_replace('_', ' ', $order->payment_method)) : 'N/A' }}</div>
                </div>
            </div>
        </div>

        @if($order->shipping_address)
            <div class="box" style="margin: 0 0 14px 0;">
                <h3>Shipping Address</h3>
                @if(is_array($order->shipping_address))
                    <div>{{ $order->shipping_address['address'] ?? implode(', ', $order->shipping_address) }}</div>
                @else
                    <div>{{ $order->shipping_address }}</div>
                @endif
            </div>
        @endif

        <table>
            <thead>
                <tr>
                    <th style="width: 5%;">#</th>
                    <th style="width: 45%;">Product</th>
                    <th style="width: 15%;">SKU</th>
                    <th style="width: 10%;" class="text-center">Qty</th>
                    <th style="width: 12%;" class="text-right">Price</th>
                    <th style="width: 13%;" class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <strong>{{ $item->product_name }}</strong>
                            @if(!empty($item->offer_details))
                                <div class="muted">Offer: {{ $item->offer_details['title'] ?? 'Applied' }}</div>
                            @endif
                        </td>
                        <td>{{ $item->product_sku }}</td>
                        <td class="text-center">{{ $item->quantity }}</td>
                        <td class="text-right">&#8377;{{ number_format($item->price, 2) }}</td>
                        <td class="text-right">&#8377;{{ number_format($item->total, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="totals">
            <div class="totals-row">
                <div class="totals-label">Subtotal</div>
                <div class="totals-value">&#8377;{{ number_format($order->subtotal, 2) }}</div>
            </div>
            <div class="totals-row">
                <div class="totals-label">Tax</div>
                <div class="totals-value">&#8377;{{ number_format($order->tax_amount, 2) }}</div>
            </div>
            <div class="totals-row">
                <div class="totals-label">Shipping</div>
                <div class="totals-value">&#8377;{{ number_format($order->shipping_amount, 2) }}</div>
            </div>
            <div class="totals-row grand">
                <div class="totals-label"><strong>Grand Total</strong></div>
                <div class="totals-value"><strong>&#8377;{{ number_format($order->total_amount, 2) }}</strong></div>
            </div>
        </div>

        <div class="footer">
            <div><strong>Thank you for your order!</strong></div>
            <div>This is an order summary. Invoice will be provided after payment integration.</div>
        </div>
    </div>
</body>
</html>
