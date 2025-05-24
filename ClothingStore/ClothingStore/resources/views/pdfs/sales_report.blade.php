<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sales Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            font-size: 12px;
        }
        h1, h2 {
            text-align: center;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .date {
            text-align: right;
            margin-bottom: 20px;
        }
        .charts {
            margin-bottom: 30px;
            text-align: center;
        }
        .chart-container {
            margin-bottom: 30px;
        }
        .chart-placeholder {
            border: 1px dashed #ccc;
            padding: 20px;
            text-align: center;
            background-color: #f9f9f9;
            margin-bottom: 20px;
        }
        .summary {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .summary-box {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
            margin: 0 5px;
            flex: 1;
        }
        .summary-box h3 {
            margin-top: 0;
            color: #555;
        }
        .summary-box p {
            font-size: 18px;
            font-weight: bold;
            margin: 5px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .status {
            display: inline-block;
            padding: 3px 6px;
            border-radius: 3px;
            font-size: 10px;
            color: white;
        }
        .status-completed {
            background-color: #28a745;
        }
        .status-pending {
            background-color: #ffc107;
            color: #212529;
        }
        .status-processing {
            background-color: #17a2b8;
        }
        .status-cancelled {
            background-color: #dc3545;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 10px;
            color: #777;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Sales Report</h1>
    </div>
    
    <div class="date">
        <p>Generated on: {{ date('F d, Y') }}</p>
    </div>
    
    <div class="summary">
        <div class="summary-box">
            <h3>Total Sales</h3>
            <p>${{ number_format($sales->sum('total_amount'), 2) }}</p>
        </div>
        <div class="summary-box">
            <h3>Total Orders</h3>
            <p>{{ $sales->count() }}</p>
        </div>
        <div class="summary-box">
            <h3>Average Order Value</h3>
            <p>${{ $sales->count() > 0 ? number_format($sales->sum('total_amount') / $sales->count(), 2) : '0.00' }}</p>
        </div>
    </div>
    
    <div class="charts">
        <div class="chart-container">
            <h2>Monthly Sales</h2>
            <div class="chart-placeholder">
                <p>Monthly Sales Chart</p>
                <p><small>Note: Charts are only visible in the web view.</small></p>
                @foreach($chartLabels as $index => $label)
                    <p>{{ $label }}: ${{ number_format($chartData[$index], 2) }}</p>
                @endforeach
            </div>
        </div>
        
        <div class="chart-container">
            <h2>Sales by Status</h2>
            <div class="chart-placeholder">
                <p>Sales by Status Chart</p>
                <p><small>Note: Charts are only visible in the web view.</small></p>
                @foreach($salesByStatus as $status)
                    <p>{{ ucfirst($status->status) }}: {{ $status->count }} orders</p>
                @endforeach
            </div>
        </div>
    </div>
    
    <div class="page-break"></div>
    
    <h2>Detailed Sales Data</h2>
    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Total Amount</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sales as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->user->name ?? 'N/A' }}</td>
                    <td>${{ number_format($order->total_amount, 2) }}</td>
                    <td>
                        <span class="status status-{{ $order->status }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td>{{ $order->created_at->format('Y-m-d') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="footer">
        <p>This report is confidential and intended for authorized personnel only.</p>
        <p>&copy; {{ date('Y') }} E-Commerce Store. All rights reserved.</p>
    </div>
</body>
</html>
