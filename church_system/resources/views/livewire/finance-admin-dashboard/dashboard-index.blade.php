<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="md:flex md:items-center md:justify-between mb-8">
            <div class="flex-1 min-w-0">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                    <i data-lucide="shield-check" class="w-8 h-8 text-emerald-600 inline-block mr-3"></i>
                    Treasurer Dashboard
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    Financial oversight for {{ auth()->user()->tenant->name ?? 'your church' }}
                </p>
            </div>
            <div class="mt-4 flex md:mt-0 md:ml-4 space-x-3">
                <button wire:click="loadStats" 
                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                    <i data-lucide="refresh-cw" class="w-4 h-4 mr-2"></i>
                    Refresh
                </button>
            </div>
        </div>

        <!-- Key Metrics - TREASURER SPECIFIC -->
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 mb-8">
            <!-- Pending Approvals -->
            <div class="bg-white overflow-hidden shadow rounded-lg border-l-4 border-amber-500">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-amber-100 rounded-md p-3">
                            <i data-lucide="alert-circle" class="w-6 h-6 text-amber-600"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Pending Approvals
                                </dt>
                                <dd class="text-lg font-semibold text-gray-900">
                                    {{ $pendingApprovals }}
                                </dd>
                            </dl>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="#" 
                           class="text-sm font-medium text-amber-600 hover:text-amber-500">
                            Review Now →
                        </a>
                    </div>
                </div>
            </div>

            <!-- Pending Deposits -->
            <div class="bg-white overflow-hidden shadow rounded-lg border-l-4 border-purple-500">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-purple-100 rounded-md p-3">
                            <i data-lucide="banknote" class="w-6 h-6 text-purple-600"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Pending Bank Deposits
                                </dt>
                                <dd class="text-lg font-semibold text-gray-900">
                                    {{ $pendingDeposits }}
                                </dd>
                            </dl>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('church.offerings.index') }}?status=counted" 
                           class="text-sm font-medium text-purple-600 hover:text-purple-500">
                            Process Now →
                        </a>
                    </div>
                </div>
            </div>

            <!-- This Month's Net -->
            <div class="bg-white overflow-hidden shadow rounded-lg border-l-4 {{ $netBalance >= 0 ? 'border-emerald-500' : 'border-red-500' }}">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 {{ $netBalance >= 0 ? 'bg-emerald-100' : 'bg-red-100' }} rounded-md p-3">
                            <i data-lucide="{{ $netBalance >= 0 ? 'trending-up' : 'trending-down' }}" 
                               class="w-6 h-6 {{ $netBalance >= 0 ? 'text-emerald-600' : 'text-red-600' }}"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    This Month's Net
                                </dt>
                                <dd class="text-lg font-semibold {{ $netBalance >= 0 ? 'text-emerald-700' : 'text-red-700' }}">
                                    {{ number_format($netBalance, 2) }}
                                </dd>
                            </dl>
                        </div>
                    </div>
                    <div class="mt-2 text-sm text-gray-500">
                        {{ number_format($currentMonthCollections, 2) }} in • {{ number_format($currentMonthExpenses, 2) }} out
                    </div>
                </div>
            </div>

            <!-- YTD Balance -->
            <div class="bg-white overflow-hidden shadow rounded-lg border-l-4 border-blue-500">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-blue-100 rounded-md p-3">
                            <i data-lucide="calendar" class="w-6 h-6 text-blue-600"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    YTD Balance
                                </dt>
                                <dd class="text-lg font-semibold {{ $ytdStats['balance'] >= 0 ? 'text-emerald-700' : 'text-red-700' }}">
                                    {{ number_format($ytdStats['balance'] ?? 0, 2) }}
                                </dd>
                            </dl>
                        </div>
                    </div>
                    <div class="mt-2">
                        @php
                            $health = $ytdStats['health'] ?? 100;
                            $status = $health >= 120 ? 'Excellent' : ($health >= 100 ? 'Good' : ($health >= 80 ? 'Fair' : 'Watch'));
                            $color = $health >= 120 ? 'emerald' : ($health >= 100 ? 'green' : ($health >= 80 ? 'amber' : 'red'));
                        @endphp
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-{{ $color }}-100 text-{{ $color }}-800">
                            {{ $status }} Health
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Two Column Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Left Column: Recent Activity & Quick Actions -->
            <div class="space-y-8">
                <!-- Recent Critical Transactions -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                        <h3 class="text-lg font-medium leading-6 text-gray-900 flex items-center">
                            <i data-lucide="activity" class="w-5 h-5 text-emerald-600 mr-2"></i>
                            Recent Activity
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Latest collections & pending expenses
                        </p>
                    </div>
                    <div class="px-4 py-5 sm:p-6">
                        @if(empty($recentTransactions))
                            <div class="text-center py-8">
                                <i data-lucide="inbox" class="w-12 h-12 text-gray-400 mx-auto"></i>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No recent activity</h3>
                                <p class="mt-1 text-sm text-gray-500">Transactions will appear here.</p>
                            </div>
                        @else
                            <div class="flow-root">
                                <ul class="-my-5 divide-y divide-gray-200">
                                    @foreach($recentTransactions as $transaction)
                                    <li class="py-4">
                                        <div class="flex items-center space-x-4">
                                            <div class="flex-shrink-0">
                                                <div class="h-10 w-10 rounded-full bg-{{ $transaction['color'] }}-100 flex items-center justify-center">
                                                    <i data-lucide="{{ $transaction['icon'] }}" class="w-5 h-5 text-{{ $transaction['color'] }}-600"></i>
                                                </div>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-900 truncate">
                                                    {{ $transaction['description'] }}
                                                </p>
                                                <div class="flex items-center mt-1">
                                                    <span class="text-sm text-gray-500">
                                                        {{ $transaction['date']->format('M d, Y') }}
                                                    </span>
                                                    @if($transaction['type'] === 'expense')
                                                    <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-amber-100 text-amber-800">
                                                        {{ ucfirst($transaction['status']) }}
                                                    </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="flex items-center">
                                                <span class="text-sm font-semibold {{ $transaction['type'] === 'collection' ? 'text-emerald-600' : 'text-amber-600' }}">
                                                    {{ $transaction['type'] === 'collection' ? '+' : '-' }}{{ number_format($transaction['amount'], 2) }}
                                                </span>
                                            </div>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-gradient-to-r from-emerald-50 to-amber-50 border border-emerald-200 rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                        <i data-lucide="zap" class="w-5 h-5 text-amber-600 mr-2"></i>
                        Quick Actions
                    </h3>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <a href="#" 
                           class="relative rounded-lg border border-gray-300 bg-white px-4 py-4 shadow-sm flex items-center space-x-3 hover:border-gray-400">
                            <div class="flex-shrink-0">
                                <div class="h-10 w-10 rounded-full bg-amber-100 flex items-center justify-center">
                                    <i data-lucide="check-circle" class="w-5 h-5 text-amber-600"></i>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900">Review Expenses</p>
                                <p class="text-sm text-gray-500">{{ $pendingApprovals }} pending</p>
                            </div>
                        </a>
                        
                        <a href="{{ route('church.offerings.index') }}?status=counted" 
                           class="relative rounded-lg border border-gray-300 bg-white px-4 py-4 shadow-sm flex items-center space-x-3 hover:border-gray-400">
                            <div class="flex-shrink-0">
                                <div class="h-10 w-10 rounded-full bg-purple-100 flex items-center justify-center">
                                    <i data-lucide="banknote" class="w-5 h-5 text-purple-600"></i>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900">Process Deposits</p>
                                <p class="text-sm text-gray-500">{{ $pendingDeposits }} pending</p>
                            </div>
                        </a>
                        
                        <a href="{{ route('church.financialreports.index') }}" 
                           class="relative rounded-lg border border-gray-300 bg-white px-4 py-4 shadow-sm flex items-center space-x-3 hover:border-gray-400">
                            <div class="flex-shrink-0">
                                <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                    <i data-lucide="file-bar-chart" class="w-5 h-5 text-blue-600"></i>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900">Generate Report</p>
                                <p class="text-sm text-gray-500">Monthly financials</p>
                            </div>
                        </a>
                        
                        <a href="{{ route('church.offerings.create') }}" 
                           class="relative rounded-lg border border-gray-300 bg-white px-4 py-4 shadow-sm flex items-center space-x-3 hover:border-gray-400">
                            <div class="flex-shrink-0">
                                <div class="h-10 w-10 rounded-full bg-emerald-100 flex items-center justify-center">
                                    <i data-lucide="plus-circle" class="w-5 h-5 text-emerald-600"></i>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900">New Collection</p>
                                <p class="text-sm text-gray-500">Record Sunday offering</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right Column: Trends & Analysis -->
            <div class="space-y-8">
                <!-- Weekly Trend -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                        <h3 class="text-lg font-medium leading-6 text-gray-900 flex items-center">
                            <i data-lucide="trending-up" class="w-5 h-5 text-emerald-600 mr-2"></i>
                            Weekly Trend (Last 4 Weeks)
                        </h3>
                    </div>
                    <div class="px-4 py-5 sm:p-6">
                        <div class="space-y-4">
                            @foreach($weeklyTrend as $week)
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-sm font-medium text-gray-700">{{ $week['week'] }}</span>
                                    <span class="text-xs text-gray-500">{{ $week['date_range'] }}</span>
                                </div>
                                <div class="grid grid-cols-3 gap-4">
                                    <div class="text-center">
                                        <div class="text-sm font-semibold text-emerald-600">
                                            {{ number_format($week['collections'], 2) }}
                                        </div>
                                        <div class="text-xs text-gray-500">Collections</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-sm font-semibold text-amber-600">
                                            {{ number_format($week['expenses'], 2) }}
                                        </div>
                                        <div class="text-xs text-gray-500">Expenses</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-sm font-semibold {{ $week['net'] >= 0 ? 'text-emerald-600' : 'text-red-600' }}">
                                            {{ number_format($week['net'], 2) }}
                                        </div>
                                        <div class="text-xs text-gray-500">Net</div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Top Expense Categories -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                        <h3 class="text-lg font-medium leading-6 text-gray-900 flex items-center">
                            <i data-lucide="pie-chart" class="w-5 h-5 text-amber-600 mr-2"></i>
                            Top Expense Categories (This Month)
                        </h3>
                    </div>
                    <div class="px-4 py-5 sm:p-6">
                        @if($topExpenseCategories->isEmpty())
                            <div class="text-center py-8">
                                <i data-lucide="pie-chart" class="w-12 h-12 text-gray-400 mx-auto"></i>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No expenses this month</h3>
                            </div>
                        @else
                            <div class="space-y-4">
                                @foreach($topExpenseCategories as $category)
                                <div>
                                    <div class="flex items-center justify-between mb-1">
                                        <span class="text-sm font-medium text-gray-700 truncate">
                                            {{ $category['name'] }}
                                        </span>
                                        <span class="text-sm font-semibold text-gray-900">
                                            {{ number_format($category['amount'], 2) }}
                                        </span>
                                    </div>
                                    <div class="flex items-center">
                                        <div class="w-full bg-gray-200 rounded-full h-2 mr-2">
                                            <div class="bg-amber-600 h-2 rounded-full" 
                                                 style="width: {{ min($category['percentage'], 100) }}%"></div>
                                        </div>
                                        <span class="text-xs text-gray-500 whitespace-nowrap">
                                            {{ number_format($category['percentage'], 1) }}%
                                        </span>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="mt-8 grid grid-cols-1 gap-5 sm:grid-cols-3">
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-emerald-100 rounded-md p-3">
                            <i data-lucide="church" class="w-6 h-6 text-emerald-600"></i>
                        </div>
                        <div class="ml-5">
                            <dt class="text-sm font-medium text-gray-500 truncate">
                                This Month's Collections
                            </dt>
                            <dd class="text-lg font-semibold text-gray-900">
                                {{ number_format($currentMonthCollections, 2) }}
                            </dd>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-amber-100 rounded-md p-3">
                            <i data-lucide="receipt" class="w-6 h-6 text-amber-600"></i>
                        </div>
                        <div class="ml-5">
                            <dt class="text-sm font-medium text-gray-500 truncate">
                                This Month's Expenses
                            </dt>
                            <dd class="text-lg font-semibold text-gray-900">
                                {{ number_format($currentMonthExpenses, 2) }}
                            </dd>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-blue-100 rounded-md p-3">
                            <i data-lucide="target" class="w-6 h-6 text-blue-600"></i>
                        </div>
                        <div class="ml-5">
                            <dt class="text-sm font-medium text-gray-500 truncate">
                                Approval Rate Target
                            </dt>
                            <dd class="text-lg font-semibold text-gray-900">
                                48 Hours
                            </dd>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Auto-refresh every 60 seconds -->
    <script>
        setInterval(() => {
            Livewire.dispatch('refreshDashboard');
        }, 60000);
    </script>
</div>