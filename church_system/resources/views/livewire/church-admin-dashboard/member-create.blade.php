<div class="p-6 bg-stone-50 min-h-screen">
    <div class="max-w-4xl mx-auto">

        <div class="flex items-center justify-between mb-8">
            <h1 class="text-3xl font-extrabold text-amber-900 flex items-center gap-3">
                <i class="fa fa-user-plus text-amber-600"></i>
                Register New Member
            </h1>
            <a href="{{ route('church.members.index') }}" class="text-amber-600 hover:text-amber-700 font-medium transition">
                <i class="fa fa-arrow-left mr-2"></i> Back to Members List
            </a>
        </div>

        @if (session()->has('success'))
            <div class="bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded-xl relative mb-6" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        @if (session()->has('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl relative mb-6" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <form wire:submit.prevent="saveMember" class="bg-white rounded-2xl shadow-xl border border-amber-100 p-8 space-y-8">
            
            <fieldset class="border-b border-gray-200 pb-6">
                <legend class="text-xl font-bold text-amber-800 mb-4">1. Personal Details</legend>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">First Name <span class="text-red-500">*</span></label>
                        <input wire:model.defer="first_name" type="text" id="first_name" class="form-input w-full rounded-lg border-gray-300 focus:border-amber-500 focus:ring-amber-500" required>
                        @error('first_name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">Last Name <span class="text-red-500">*</span></label>
                        <input wire:model.defer="last_name" type="text" id="last_name" class="form-input w-full rounded-lg border-gray-300 focus:border-amber-500 focus:ring-amber-500" required>
                        @error('last_name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="gender" class="block text-sm font-medium text-gray-700 mb-1">Gender <span class="text-red-500">*</span></label>
                        <select wire:model.defer="gender" id="gender" class="form-select w-full rounded-lg border-gray-300 focus:border-amber-500 focus:ring-amber-500">
                            @foreach($genders as $g)
                                <option value="{{ $g }}">{{ $g }}</option>
                            @endforeach
                        </select>
                        @error('gender') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-1">Date of Birth</label>
                        <input wire:model.defer="date_of_birth" type="date" id="date_of_birth" class="form-input w-full rounded-lg border-gray-300 focus:border-amber-500 focus:ring-amber-500">
                        @error('date_of_birth') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>
            </fieldset>

            <fieldset class="border-b border-gray-200 pb-6">
                <legend class="text-xl font-bold text-amber-800 mb-4">2. Contact Details</legend>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number <span class="text-red-500">*</span></label>
                        <input wire:model.defer="phone" type="text" id="phone" class="form-input w-full rounded-lg border-gray-300 focus:border-amber-500 focus:ring-amber-500" required>
                        @error('phone') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                        <input wire:model.defer="email" type="email" id="email" class="form-input w-full rounded-lg border-gray-300 focus:border-amber-500 focus:ring-amber-500">
                        @error('email') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                        <textarea wire:model.defer="address" id="address" rows="2" class="form-textarea w-full rounded-lg border-gray-300 focus:border-amber-500 focus:ring-amber-500"></textarea>
                        @error('address') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>
            </fieldset>

            <fieldset class="pb-6">
                <legend class="text-xl font-bold text-amber-800 mb-4">3. Church Status</legend>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <div>
                        <label for="department_id" class="block text-sm font-medium text-gray-700 mb-1">Department</label>
                        <select wire:model.defer="department_id" id="department_id" class="form-select w-full rounded-lg border-gray-300 focus:border-amber-500 focus:ring-amber-500">
                            <option value="null" selected>-- Select Department (Optional) --</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        </select>
                        @error('department_id') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                    

                    <div>
                        <label for="date_joined" class="block text-sm font-medium text-gray-700 mb-1">Date Joined <span class="text-red-500">*</span></label>
                        <input wire:model.defer="date_joined" type="date" id="date_joined" class="form-input w-full rounded-lg border-gray-300 focus:border-amber-500 focus:ring-amber-500" required>
                        @error('date_joined') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Membership Status <span class="text-red-500">*</span></label>
                        <select wire:model.defer="status" id="status" class="form-select w-full rounded-lg border-gray-300 focus:border-amber-500 focus:ring-amber-500">
                            @foreach($statuses as $s)
                                <option value="{{ $s }}">{{ $s }}</option>
                            @endforeach
                        </select>
                        @error('status') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Role in Church <span class="text-red-500">*</span></label>
                        <select wire:model.defer="role" id="role" class="form-select w-full rounded-lg border-gray-300 focus:border-amber-500 focus:ring-amber-500">
                            @foreach($roles as $r)
                                <option value="{{ $r }}">{{ $r }}</option>
                            @endforeach
                        </select>
                        @error('role') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label for="baptism_date" class="block text-sm font-medium text-gray-700 mb-1">Baptism Date</label>
                        <input wire:model.defer="baptism_date" type="date" id="baptism_date" class="form-input w-full rounded-lg border-gray-300 focus:border-amber-500 focus:ring-amber-500">
                        @error('baptism_date') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label for="confirmed_at" class="block text-sm font-medium text-gray-700 mb-1">Confirmation Date</label>
                        <input wire:model.defer="confirmed_at" type="date" id="confirmed_at" class="form-input w-full rounded-lg border-gray-300 focus:border-amber-500 focus:ring-amber-500">
                        @error('confirmed_at') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>
            </fieldset>

            <div class="pt-6 border-t border-gray-200 flex justify-end">
                <button type="submit" class="w-full md:w-auto bg-amber-600 hover:bg-amber-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transition duration-300 transform hover:scale-105 flex items-center justify-center">
                    <i class="fa fa-save mr-2"></i> Save New Member
                </button>
            </div>
            
        </form>

    </div>
</div>