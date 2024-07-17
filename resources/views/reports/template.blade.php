<!DOCTYPE html>
<html>
<head>
    <title>Report</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .report-header, .report-section {
            margin-bottom: 20px;
        }
        .report-header h1 {
            margin: 0;
        }
        .report-section h2 {
            margin-top: 0;
        }
        ul {
            list-style-type: none;
            padding-left: 0;
        }
        ul li {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="report-header mt-5">
            <h1>Report from {{ $startDate }} to {{ $endDate }}</h1>
            <h2>UserId: {{ $userId }}</h2>
            <p><strong>Total Expenses:</strong> {{ $totalExpenses }}</p>
            <p><strong>Total Incomes:</strong> {{ $totalIncomes }}</p>
        </div>

        <div class="report-section">
            <h2>Expenses by Category</h2>
            @if($expensesByCategory->isEmpty())
                <p>No expenses recorded.</p>
            @else
                <ul class="list-group">
                    @foreach($expensesByCategory as $categoryId => $amount)
                        <li class="list-group-item">{{ $expenseCategoryNames[$categoryId] }}: {{ $amount }}</li>
                    @endforeach
                </ul>
            @endif
        </div>

        <div class="report-section">
            <h2>Incomes by Category</h2>
            @if($incomesByCategory->isEmpty())
                <p>No incomes recorded.</p>
            @else
                <ul class="list-group">
                    @foreach($incomesByCategory as $categoryId => $amount)
                        <li class="list-group-item">{{ $incomeCategoryNames[$categoryId] }}: {{ $amount }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</body>
</html>
