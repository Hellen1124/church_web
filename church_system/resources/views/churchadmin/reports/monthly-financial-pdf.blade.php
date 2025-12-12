<!DOCTYPE html>
<html>
<head>
    <title>Financial Report - {{ $monthName }}</title>
    <style>
        /* BASE STYLES */
        body { 
            font-family: sans-serif; 
            font-size: 10px; 
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 15px; 
        }
        th, td { 
            border: 1px solid #e0e0e0; /* Lighter border for clean look */
            padding: 8px; /* Slightly more padding */
            text-align: right; 
        }
        th { 
            background-color: #f5f5f5; 
            text-align: left; 
            font-weight: bold;
        }
        .text-left { text-align: left; }
        
        /* HEADER STYLES */
        .header { 
            text-align: center; 
            margin-bottom: 25px; 
            padding-bottom: 10px;
            border-bottom: 2px solid #000; /* Separator line */
        }
        .logo { 
            max-width: 80px; /* Control logo size */
            height: auto; 
            margin-bottom: 10px;
        }
        .church-name { 
            font-size: 16px; 
            font-weight: bold; 
            margin: 0; 
            color: #333;
        }
        .report-title { 
            font-size: 22px; 
            margin: 5px 0; 
            color: #1a1a1a;
        }
        .period-info {
            font-size: 14px;
            color: #555;
            font-style: italic;
        }

        /* TABLE SPECIFIC STYLES */
        .section-title { 
            font-size: 14px; 
            margin-top: 20px; 
            margin-bottom: 8px; 
            color: #444; 
            border-left: 4px solid #3f51b5; /* Blue accent */
            padding-left: 8px;
        }
        .summary td { font-weight: bold; }
        .net-position td { 
            background-color: #e3f2fd; /* Light Blue */
            font-size: 12px; 
            font-weight: bolder; 
            border-top: 2px solid #2196f3; 
            border-bottom: 2px solid #2196f3; 
        }
        .income-total td { background-color: #e8f5e9; border-top: 2px solid #4caf50; }
        .expense-total td { background-color: #ffebee; border-top: 2px solid #f44336; }
    </style>
</head>
<body>
    <div class="header">
        {{-- LOGO Placeholder: Make sure this path is correct and accessible by Dompdf! --}}
        {{-- We use the full public path to ensure Dompdf can find it --}}
        <img src="{{ public_path('images/church_logo.png') }}" alt="Church Logo" class="logo">
        
        <p class="church-name">{{ config('app.name', 'Church Management System') }}</p>
        <h1 class="report-title">Monthly Financial Report</h1>
        <p class="period-info">Reporting Period: {{ $monthName }}</p>
    </div>

    {{-- Helper function for KSh currency formatting --}}
    @php
        $formatCurrency = fn($amount) => 'KSh ' . number_format($amount, 2);
    @endphp

    {{-- EXECUTIVE SUMMARY --}}
    <p class="section-title">1. Executive Summary</p>
    <table>
        <thead>
            <tr>
                <th class="text-left" style="width: 40%;">Item</th>
                <th>{{ $monthName }} (Actual)</th>
                <th>{{ $priorMonthName }} (Prior)</th>
            </tr>
        </thead>
        <tbody>
            <tr class="summary">
                <td class="text-left">Total Collections (Income)</td>
                <td>{{ $formatCurrency($currentReport['income']['total']) }}</td>
                <td>{{ $formatCurrency($priorReport['income']['total']) }}</td>
            </tr>
            <tr class="summary">
                <td class="text-left">Total Expenses</td>
                <td>{{ $formatCurrency($currentReport['expenses']['total']) }}</td>
                <td>{{ $formatCurrency($priorReport['expenses']['total']) }}</td>
            </tr>
            <tr class="net-position">
                <td class="text-left">Net Surplus / (Deficit)</td>
                <td>{{ $formatCurrency($currentReport['net_position']) }}</td>
                <td>{{ $formatCurrency($priorReport['net_position']) }}</td>
            </tr>
            <tr class="summary">
                <td class="text-left">Closing Cash Balance (Estimate)</td>
                <td>{{ $formatCurrency($currentReport['closing_balance']) }}</td>
                <td>N/A</td>
            </tr>
        </tbody>
    </table>

    {{-- INCOME DETAIL --}}
    <p class="section-title">2. Income Detail</p>
    <table>
        <thead>
            <tr>
                <th class="text-left" style="width: 40%;">Source</th>
                <th>Amount (KSh)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($currentReport['income'] as $key => $amount)
                @if($key !== 'total')
                <tr>
                    <td class="text-left">{{ $key }}</td>
                    <td>{{ $formatCurrency($amount) }}</td>
                </tr>
                @endif
            @endforeach
            <tr class="summary income-total">
                <td class="text-left">TOTAL COLLECTIONS</td>
                <td>{{ $formatCurrency($currentReport['income']['total']) }}</td>
            </tr>
        </tbody>
    </table>

    {{-- EXPENSE DETAIL --}}
    <p class="section-title">3. Expense Detail</p>
    <table>
        <thead>
            <tr>
                <th class="text-left" style="width: 40%;">Category Group</th>
                <th>Amount (KSh)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($currentReport['expenses'] as $groupName => $amount)
                @if($groupName !== 'total')
                <tr>
                    <td class="text-left">{{ $groupName }}</td>
                    <td>{{ $formatCurrency($amount) }}</td>
                </tr>
                @endif
            @endforeach
            <tr class="summary expense-total">
                <td class="text-left">TOTAL EXPENSES</td>
                <td>{{ $formatCurrency($currentReport['expenses']['total']) }}</td>
            </tr>
        </tbody>
    </table>

    <p style="margin-top: 30px; font-size: 8px; text-align: center; color: #777;">Report generated on {{ now()->format('Y-m-d H:i:s') }}. Data based on Banked Collections and Paid Expenses.</p>
</body>
</html>