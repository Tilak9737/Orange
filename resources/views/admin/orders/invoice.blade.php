<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Invoice #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</title>
    <style>
        @page {
            margin: 0;
        }

        body {
            font-family: 'Helvetica', sans-serif;
            margin: 0;
            padding: 0;
            background: #ffffff;
            color: #333333;
        }

        .header {
            background: #FF6600;
            padding: 40px;
            color: #ffffff;
        }

        .header-content {
            width: 100%;
        }

        .logo {
            font-size: 32px;
            font-weight: 800;
            letter-spacing: -1px;
            text-transform: uppercase;
        }

        .invoice-label {
            float: right;
            font-size: 40px;
            font-weight: 900;
            text-transform: uppercase;
        }

        .content {
            padding: 40px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }

        th {
            text-align: left;
            padding: 15px 10px;
            border-bottom: 2px solid #FF6600;
            color: #FF6600;
            font-size: 12px;
            text-transform: uppercase;
        }

        td {
            padding: 15px 10px;
            border-bottom: 1px solid #eeeeee;
            font-size: 14px;
        }

        .info-grid {
            margin-top: 10px;
            width: 100%;
        }

        .info-box {
            width: 48%;
            display: inline-block;
            vertical-align: top;
        }

        .label {
            color: #888888;
            font-size: 11px;
            text-transform: uppercase;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .value {
            font-size: 14px;
            font-weight: bold;
        }

        .totals {
            margin-top: 30px;
            float: right;
            width: 300px;
        }

        .total-row {
            padding: 10px 0;
            border-bottom: 1px solid #eeeeee;
        }

        .total-row.grand-total {
            border-bottom: none;
            background: #fff8f3;
            padding: 15px 10px;
            border-left: 4px solid #FF6600;
        }

        .total-label {
            display: inline-block;
            width: 180px;
            font-size: 14px;
        }

        .total-value {
            display: inline-block;
            width: 100px;
            text-align: right;
            font-weight: bold;
            font-size: 16px;
        }

        .grand-total .total-label {
            font-weight: 800;
            color: #FF6600;
        }

        .grand-total .total-value {
            font-size: 24px;
            color: #FF6600;
        }

        .footer {
            position: absolute;
            bottom: 40px;
            left: 40px;
            right: 40px;
            text-align: center;
            font-size: 11px;
            color: #aaaaaa;
            border-top: 1px solid #eeeeee;
            padding-top: 20px;
        }

        .status-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            background: #eee;
        }

        .product-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 4px;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="header-content">
            <span class="logo">ORANGE.</span>
            <span class="invoice-label">Invoice</span>
        </div>
        <div style="margin-top: 40px; font-size: 14px; opacity: 0.9;">
            ID: #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }} | Date: {{ $order->created_at->format('M d, Y') }}
        </div>
    </div>

    <div class="content">
        <div class="info-grid">
            <div class="info-box">
                <div class="label">Billed To</div>
                <div class="value">{{ $order->user->name }}</div>
                <div style="font-size: 13px; color: #555; margin-top: 4px;">{{ $order->user->email }}</div>
            </div>
            @if(isset($order->shipping_address['address']))
                <div class="info-box" style="text-align: right;">
                    <div class="label">Shipping Address</div>
                    <div class="value">{{ $order->shipping_address['first_name'] ?? '' }}
                        {{ $order->shipping_address['last_name'] ?? '' }}
                    </div>
                    <div style="font-size: 13px; color: #555; margin-top: 4px;">
                        {{ $order->shipping_address['address'] ?? '' }}<br>
                        {{ $order->shipping_address['city'] ?? '' }}, {{ $order->shipping_address['state'] ?? '' }}
                        {{ $order->shipping_address['zip'] ?? '' }}<br>
                        {{ strtoupper($order->shipping_address['country'] ?? '') }}
                    </div>
                </div>
            @endif
        </div>

        <table>
            <thead>
                <tr>
                    <th style="width: 50%;">Product Details</th>
                    <th style="text-align: center; width: 15%;">Quantity</th>
                    <th style="text-align: right; width: 15%;">Price</th>
                    <th style="text-align: right; width: 20%;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                    <tr>
                        <td>
                            <div style="font-weight: bold; margin-bottom: 2px;">{{ $item->product->name }}</div>
                            <div style="font-size: 11px; color: #888;">SKU:
                                {{ strtoupper(substr(md5($item->product->id), 0, 8)) }}
                            </div>
                        </td>
                        <td style="text-align: center;">{{ $item->quantity }}</td>
                        <td style="text-align: right;">${{ number_format($item->price, 2) }}</td>
                        <td style="text-align: right; font-weight: bold;">
                            ${{ number_format($item->price * $item->quantity, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="totals">
            <div class="total-row">
                <span class="total-label">Subtotal</span>
                <span class="total-value">${{ number_format($order->total, 2) }}</span>
            </div>
            <div class="total-row">
                <span class="total-label">Shipping & Taxes</span>
                <span class="total-value">$0.00</span>
            </div>
            @if($order->coupon)
                <div class="total-row" style="color: #10b981;">
                    <span class="total-label">Discount ({{ $order->coupon->code }})</span>
                    <span class="total-value">-${{ number_format($order->coupon->value, 2) }}</span>
                </div>
            @endif
            <div class="total-row grand-total">
                <span class="total-label">Grand Total</span>
                <span class="total-value">${{ number_format($order->total, 2) }}</span>
            </div>
        </div>

        <div
            style="clear: both; margin-top: 50px; font-size: 12px; color: #555; background: #fafafa; padding: 20px; border-radius: 8px;">
            <div class="label" style="margin-bottom: 10px;">Payment Information</div>
            <p style="margin: 0;">Payment Method: <strong>Card / Demo</strong></p>
            <p style="margin: 4px 0 0 0;">Transaction Status: <strong>Paid</strong></p>
        </div>
    </div>

    <div class="footer">
        <strong>ORANGE. E-Commerce Store</strong> | Thank you for your business! | Visit us at orange.store
    </div>
</body>

</html>