<div class="p-6 md:p-10 bg-gray-50 min-h-screen">

    {{-- 1. Header, Filters, and Actions (Amber Focus) --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 border-b border-amber-100 pb-4">
        
        {{-- Title and Current Period --}}
        <div>
            <h1 class="text-4xl font-extrabold text-gray-900 mb-1">
                <i class="fas fa-chart-line mr-2 text-amber-600"></i> Financial Performance Report
            </h1>
            <p class="text-xl font-semibold text-amber-700 mt-2">
                Reporting Period: <span class="text-gray-800">{{ $monthName }}</span>
            </p>
        </div>

        {{-- Filters and Download --}}
        <div class="flex items-center space-x-4 mt-4 md:mt-0">
            
            {{-- Filter Group --}}
            <div class="flex space-x-2 bg-white p-2 rounded-xl shadow-inner border border-amber-200">
                <span class="text-sm font-medium text-gray-600 self-center">View:</span>
                <select wire:model.live="reportMonth" class="bg-gray-50 rounded-lg border-gray-200 text-sm focus:ring-amber-500 focus:border-amber-500" wire:change="generateReport">
                    @foreach(range(1, 12) as $m)
                        <option value="{{ $m }}">{{ date('F', mktime(0, 0, 0, $m, 10)) }}</option>
                    @endforeach
                </select>
                <select wire:model.live="reportYear" class="bg-gray-50 rounded-lg border-gray-200 text-sm focus:ring-amber-500 focus:border-amber-500" wire:change="generateReport">
                    @foreach(range(date('Y') - 5, date('Y')) as $y)
                        <option value="{{ $y }}">{{ $y }}</option>
                    @endforeach
                </select>
            </div>
            
            {{-- Download Button --}}
            <button wire:click="downloadPdfReport" class="px-5 py-2.5 bg-amber-600 text-white rounded-xl shadow-lg hover:bg-amber-700 transition duration-150 focus:outline-none focus:ring-4 focus:ring-amber-300 font-medium">
                <i class="fas fa-file-download mr-1"></i> Download PDF
            </button>
        </div>
    </div>
    
    {{-- Flash Message (Amber/Green/Red) --}}
    @if (session()->has('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl relative mb-6 shadow-md" role="alert">
            <span class="font-semibold block sm:inline">Success!</span>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @elseif (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl relative mb-6 shadow-md" role="alert">
            <span class="font-semibold block sm:inline">Error:</span>
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    {{-- Helper functions remain the same --}}
    @php
        $formatCurrency = fn($amount) => 'KSh ' . number_format($amount, 2);
        $getVariance = fn($current, $prior) => $current - $prior;
        // Financial Health Indicator Colors (Green for Positive, Red for Negative)
        $getVarianceClass = fn($variance, $positiveIsGood = true) => 
            'text-' . (
                ($variance > 0 && $positiveIsGood) || ($variance < 0 && !$positiveIsGood) 
                ? 'green' : (
                    ($variance < 0 && $positiveIsGood) || ($variance > 0 && !$positiveIsGood) 
                    ? 'red' : 'gray'
                )
            ) . '-600';
    @endphp

    {{-- 2. Executive Summary Card (KSh) --}}
    <div class="bg-white shadow-2xl rounded-xl p-8 mb-10 border border-gray-100">
        <h2 class="text-2xl font-bold mb-6 text-amber-700 border-b border-amber-100 pb-2">
            Executive Financial Summary
        </h2>
        
        <table class="min-w-full divide-y divide-gray-100">
            <thead class="bg-amber-50">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">Item</th>
                    <th class="px-6 py-3 text-right text-sm font-bold text-gray-700 uppercase tracking-wider">{{ $monthName }} (Actual)</th>
                    <th class="px-6 py-3 text-right text-sm font-bold text-gray-700 uppercase tracking-wider">{{ $priorMonthName }} (Prior)</th>
                    <th class="px-6 py-3 text-right text-sm font-bold text-gray-700 uppercase tracking-wider">Variance</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @php
                    $incomeVariance = $getVariance($currentReport['income']['total'], $priorReport['income']['total']);
                    $expenseVariance = $getVariance($currentReport['expenses']['total'], $priorReport['expenses']['total']);
                    $netVariance = $getVariance($currentReport['net_position'], $priorReport['net_position']);
                @endphp
                
                {{-- Income Row --}}
                <tr class="hover:bg-gray-50 transition duration-100">
                    <td class="px-6 py-4 whitespace-nowrap font-semibold text-gray-900">Total Collections (Income)</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right font-medium">{{ $formatCurrency($currentReport['income']['total']) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right font-medium">{{ $formatCurrency($priorReport['income']['total']) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right font-bold {{ $getVarianceClass($incomeVariance) }}">{{ $formatCurrency($incomeVariance) }}</td>
                </tr>
                
                {{-- Expenses Row --}}
                <tr class="hover:bg-gray-50 transition duration-100">
                    <td class="px-6 py-4 whitespace-nowrap font-semibold text-gray-900">Total Expenses</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right font-medium">{{ $formatCurrency($currentReport['expenses']['total']) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right font-medium">{{ $formatCurrency($priorReport['expenses']['total']) }}</td>
                    {{-- Expenses variance: False means a negative number (more expense) is bad (red) --}}
                    <td class="px-6 py-4 whitespace-nowrap text-right font-bold {{ $getVarianceClass($expenseVariance, false) }}">{{ $formatCurrency($expenseVariance) }}</td>
                </tr>
                
                {{-- Net Position (The Highlight) --}}
                <tr class="bg-amber-100/50 font-extrabold text-xl border-t-2 border-amber-300">
                    <td class="px-6 py-4 whitespace-nowrap text-amber-800">NET SURPLUS / (DEFICIT)</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-amber-800">{{ $formatCurrency($currentReport['net_position']) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-amber-800">{{ $formatCurrency($priorReport['net_position']) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right {{ $getVarianceClass($netVariance) }}">{{ $formatCurrency($netVariance) }}</td>
                </tr>
                
                {{-- Closing Balance --}}
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap font-bold text-gray-700">Closing Cash Balance (Estimate)</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right font-extrabold text-amber-700">{{ $formatCurrency($currentReport['closing_balance']) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-gray-500">N/A</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-gray-500">N/A</td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- 3. Detailed Income and Expense Sections --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        {{-- Detailed Income Card --}}
        <div class="bg-white shadow-xl rounded-xl p-6 border border-gray-100">
            <h3 class="text-xl font-bold mb-4 text-gray-700 border-b border-gray-200 pb-2">
                <i class="fas fa-arrow-circle-up mr-2 text-green-500"></i> Detailed Income Sources
            </h3>
            <table class="min-w-full divide-y divide-gray-100">
                <tbody class="divide-y divide-gray-100">
                    @foreach($currentReport['income'] as $key => $amount)
                        @if($key !== 'total')
                        <tr class="hover:bg-green-50/50 transition duration-100">
                            <td class="px-4 py-3 text-left font-medium">{{ $key }}</td>
                            <td class="px-4 py-3 text-right font-medium">{{ $formatCurrency($amount) }}</td>
                        </tr>
                        @endif
                    @endforeach
                    <tr class="bg-green-100 font-extrabold text-gray-800">
                        <td class="px-4 py-3 text-left uppercase">Total Collections</td>
                        <td class="px-4 py-3 text-right">{{ $formatCurrency($currentReport['income']['total']) }}</td>
                    </tr>
                </tbody>
            </table>
            <p class="mt-4 text-sm text-gray-500 italic">Data includes only Banked collections.</p>
        </div>

        {{-- Detailed Expense Card --}}
        <div class="bg-white shadow-xl rounded-xl p-6 border border-gray-100">
            <h3 class="text-xl font-bold mb-4 text-gray-700 border-b border-gray-200 pb-2">
                <i class="fas fa-arrow-circle-down mr-2 text-red-500"></i> Detailed Expense Spending
            </h3>
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-bold text-gray-600 uppercase">Category Group</th>
                        <th class="px-4 py-2 text-right text-xs font-bold text-gray-600 uppercase">Amount (KSh)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($currentReport['expenses'] as $groupName => $amount)
                        @if($groupName !== 'total')
                        <tr class="hover:bg-red-50/50 transition duration-100">
                            <td class="px-4 py-3 text-left font-medium">{{ $groupName }}</td>
                            <td class="px-4 py-3 text-right font-medium">{{ $formatCurrency($amount) }}</td>
                        </tr>
                        @endif
                    @endforeach
                    <tr class="bg-red-100 font-extrabold text-gray-800">
                        <td class="px-4 py-3 text-left uppercase">Total Expenses</td>
                        <td class="px-4 py-3 text-right">{{ $formatCurrency($currentReport['expenses']['total']) }}</td>
                    </tr>
                </tbody>
            </table>
            <p class="mt-4 text-sm text-gray-500 italic">Data includes only Paid expenses.</p>
        </div>
    </div>
</div>