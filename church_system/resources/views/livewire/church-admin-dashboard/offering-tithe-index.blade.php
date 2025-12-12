<div class="p-6 bg-stone-50 min-h-screen">
    <div class="max-w-7xl mx-auto space-y-10">

        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6 pb-6 border-b border-amber-100">
            
            <h2 class="text-4xl font-bold text-amber-900 flex items-center gap-4">
                <x-lucide-hand-coins class="w-12 h-12 text-amber-600" />
                Offerings & Tithes Ledger
            </h2>

            @can('manage finance')
                <a href="{{ route('church.offerings.create') }}"
                   
                   class="inline-flex items-center gap-3 bg-amber-600 hover:bg-amber-700 text-white font-medium px-7 py-4 rounded-full shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                    <x-lucide-plus class="w-6 h-6" />
                    Record New Offering
                </a>
            @endcan
        </div>

        <div class="bg-white rounded-2xl shadow-lg border border-amber-100/60 p-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-5 items-center">
                
                <div class="md:col-span-1 relative">
                    <x-lucide-search class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" />
                    <input wire:model.live.debounce.300ms="search"
                        type="text"
                        placeholder="Search notes or contributor..."
                        class="w-full pl-12 pr-5 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition text-base">
                </div>

                <select wire:model.live="filterType" class="w-full py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition">
                    <option value="">-- All Types --</option>
                    @foreach($availableTypes as $type)
                        <option value="{{ $type }}">{{ $type }}</option>
                    @endforeach
                </select>

                <input wire:model.live="startDate"
                    type="date"
                    class="w-full py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition">

                <input wire:model.live="endDate"
                    type="date"
                    class="w-full py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition">
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-xl overflow-x-auto border border-amber-100/50">
            <table class="min-w-full divide-y divide-amber-100">
                <thead class="bg-amber-50">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-amber-800 uppercase tracking-wider">
                            Date
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-amber-800 uppercase tracking-wider">
                            Amount
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-amber-800 uppercase tracking-wider">
                            Type
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-amber-800 uppercase tracking-wider">
                            Pmt. Method
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-amber-800 uppercase tracking-wider">
                            Notes
                        </th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-amber-800 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($offerings as $offering)
                        <tr class="hover:bg-amber-50/50 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $offering->recorded_at->format('Y-m-d') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-green-700">
                                KSh {{ number_format($offering->amount, 2) }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $offering->type }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $offering->payment_method }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 truncate max-w-xs">
                                {{ $offering->notes ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium flex gap-2 justify-center">
                                @can('manage finance')
                                    <a href="#"
                                       class="text-amber-600 hover:text-amber-800 transition" title="Edit" wire:navigate>
                                        <x-lucide-edit class="w-4 h-4" />
                                    </a>
                                @endcan

                                @can('manage finance')
                                    <button wire:click="confirmOfferingDeletion({{ $offering->id }})"
                                            class="text-red-600 hover:text-red-800 transition" title="Delete">
                                        <x-lucide-trash-2 class="w-4 h-4" />
                                    </button>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-20 text-center text-gray-500 text-lg">
                                <x-lucide-banknote class="w-16 h-16 mx-auto mb-4 text-gray-300" />
                                No offerings or tithes found matching your criteria.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="flex justify-center pt-4">
            {{ $offerings->links() }}
        </div>
        
    </div>
</div>
