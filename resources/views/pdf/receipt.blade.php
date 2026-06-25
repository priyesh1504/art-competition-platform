<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            padding: 20px;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }

        .details {
            margin-top: 20px;
            line-height: 1.7;
        }

        .total {
            text-align: right;
            font-size: 18px;
            font-weight: bold;
            margin-top: 20px;
        }

        .footer {
            margin-top: 50px;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>RangKala Art Academy</h1>
        <p>Official Payment Receipt</p>
    </div>

    <div class="details">
        <p><strong>Receipt ID:</strong> {{ $data['receipt_id'] }}</p>
        <p><strong>Date & Time:</strong> {{ \Carbon\Carbon::parse($data['date'])->format('d M Y, h:i A') }}</p>
        <p><strong>Student:</strong> {{ $data['user']->name }} ({{ $data['user']->email }})</p>
        <p><strong>Competition:</strong> {{ $data['competition']->title }}</p>
    </div>

    <div class="total">
        Total Amount: &#8377; {{ number_format($data['amount'], 2) }}
    </div>

    <p class="footer">
        This is a computer-generated receipt.
    </p>

</body>
</html>