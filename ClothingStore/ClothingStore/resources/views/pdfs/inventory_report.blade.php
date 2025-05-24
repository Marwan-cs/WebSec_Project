<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Inventory Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            font-size: 12px;
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .date {
            text-align: right;
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
        .status-in-stock {
            background-color: #28a745;
        }
        .status-low {
            background-color: #17a2b8;
        }
        .status-critical {
            background-color: #ffc107;
            color: #212529;
        }
        .status-out {
            background-color: #dc3545;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 10px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Inventory Report</h1>
    </div>
    
    <div class="date">
        <p>Generated on: {{ date('F d, Y') }}</p>
    </div>
    
    <div class="summary">
        <div class="summary-box">
            <h3>Total Products</h3>
            <p>{{ count($products) }}</p>
        </div>
        <div class="summary-box">
            <h3>Total Stock</h3>
            <p>{{ $products->sum('stock') }}</p>
        </div>
        <div class="summary-box">
            <h3>Low Stock Items</h3>
            <p>{{ $products->where('stock', '<', 10)->count() }}</p>
        </div>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Category</th>
                <th>Stock</th>
                <th>Price</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>${{ number_format($product->price, 2) }}</td>
                    <td>
                        @if($product->stock <= 0)
                            <span class="status status-out">Out of Stock</span>
                        @elseif($product->stock < 5)
                            <span class="status status-critical">Critical</span>
                        @elseif($product->stock < 10)
                            <span class="status status-low">Low</span>
                        @else
                            <span class="status status-in-stock">In Stock</span>
                        @endif
                    </td>
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
