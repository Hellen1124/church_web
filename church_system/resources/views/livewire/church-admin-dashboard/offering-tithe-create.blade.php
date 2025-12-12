<div class="p-6 bg-stone-50 min-h-screen">
    <div class="max-w-4xl mx-auto space-y-10">
        <div class="flex items-center justify-between gap-6 pb-6 border-b border-amber-100">
            <h2 class="text-3xl font-bold text-amber-900 flex items-center gap-4">
                <x-lucide-receipt-text class="w-10 h-10 text-amber-600" />
                Record New Contribution
            </h2>
            <a href="{{ route('church.offerings.index') }}"
               class="text-sm font-medium text-amber-600 hover:text-amber-800 flex items-center gap-2 transition">
                <x-lucide-arrow-left class="w-4 h-4" /> Back to Ledger
            </a>
        </div>

        <form wire:submit.prevent="save" class="bg-white rounded-2xl shadow-xl border border-amber-100/50 p-8 space-y-6">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Amount (KSh) <span class="text-red-500">*</span></label>
                    <input wire:model.defer="amount" type="number" step="0.01" placeholder="e.g., 500.00"
                           class="w-full py-3 border border-gray-300 rounded-xl focus:ring-amber-500 focus:border-amber-500 transition">
                    @error('amount') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Date Recorded <span class="text-red-500">*</span></label>
                    <input wire:model.defer="recorded_at" type="date" max="{{ now()->format('Y-m-d') }}"
                           class="w-full py-3 border border-gray-300 rounded-xl focus:ring-amber-500 focus:border-amber-500 transition">
                    @error('recorded_at') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Type <span class="text-red-500">*</span></label>
                    <select wire:model.defer="type"
                            class="w-full py-3 border border-gray-300 rounded-xl focus:ring-amber-500 focus:border-amber-500 transition">
                        @foreach($types as $option)
                            <option value="{{ $option }}">{{ $option }}</option>
                        @endforeach
                    </select>
                    @error('type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Payment Method <span class="text-red-500">*</span></label>
                    <select wire:model.defer="payment_method"
                            class="w-full py-3 border border-gray-300 rounded-xl focus:ring-amber-500 focus:border-amber-500 transition">
                        @foreach($paymentMethods as $method)
                            <option value="{{ $method }}">{{ $method }}</option>
                        @endforeach
                    </select>
                    @error('payment_method') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Notes (Optional)</label>
                <textarea wire:model.defer="notes" rows="3"
                          placeholder="E.g., Contributed by Member X"
                          class="w-full py-3 border border-gray-300 rounded-xl focus:ring-amber-500 focus:border-amber-500 transition"></textarea>
                @error('notes') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="pt-4 flex justify-end">
                <button type="submit"
                        class="inline-flex items-center gap-3 bg-amber-600 hover:bg-amber-700 text-white font-medium px-8 py-4 rounded-full shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-0.5 disabled:bg-gray-400"
                        wire:loading.attr="disabled">
                    <span wire:loading.remove>Save Contribution</span>
                    <span wire:loading>Saving...</span>
                </button>
            </div>
        </form>
    </div>
</div>


