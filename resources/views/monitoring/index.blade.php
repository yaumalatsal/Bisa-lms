<!DOCTYPE html>
@extends('dashboard_template/index')



<html>
<head>
    @section('content')
    <title>Business Process Monitoring</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background-color: #f8f9fa; 
        }
        .container {
            max-width: 900px;
        }
        .card-header {
            background-color: #343a40;
            color: white;
        }
        /* .form-control, .btn {
            border-radius: 0.25rem;
        } */
        .form-group label {
            font-weight: bold;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .alert {
            margin-top: 20px;
        }
        .card {
            margin-bottom: 20px;
        }
        canvas {
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="card mb-4">
        <div class="card-header text-center">
            <h4>Enter Monitoring Data</h4>
        </div>
        <div class="card-body">
            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ $message }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <form action="{{ route('monitoring.store') }}" method="POST">
                @csrf
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="business_process">Business Process</label>
                        <input type="text" class="form-control" id="business_process" name="business_process" placeholder="e.g., Sales" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="value">Total Sales</label>
                        <input type="number" step="0.01" class="form-control" id="value" name="value" placeholder="e.g., 100.50" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="product">Product</label>
                        <input type="text" class="form-control" id="product" name="product" placeholder="e.g., Laptop" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="quantity">Production Quantity</label>
                        <input type="number" step="1" class="form-control" id="quantity" name="quantity" placeholder="e.g., 10" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="price">Price</label>
                        <input type="number" step="0.01" class="form-control" id="price" name="price" placeholder="e.g., 999.99" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="date">Date</label>
                        <input type="date" class="form-control" id="date" name="date" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="file">Upload file bukti RAB:</label>
                        <input type="file" class="form-control-file" id="file" name="file">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Submit</button>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header text-center">
            <h4>Monitoring Data</h4>
        </div>
        <div class="card-body">
            <canvas id="monitoringChart"></canvas>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var ctx = document.getElementById('monitoringChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($data->pluck('business_process')),
                datasets: [{
                    label: 'Monitoring Data',
                    data: @json($data->pluck('value')),
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2,
                    fill: false,
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                }
            }
        });
    });
</script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@endsection
</body>
</html>



