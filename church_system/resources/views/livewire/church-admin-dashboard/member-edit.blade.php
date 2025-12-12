<div class="max-w-4xl mx-auto py-8">
    <div class="bg-white shadow-xl rounded-2xl overflow-hidden">

        <div class="bg-gray-800 p-6 text-white border-b-4 border-amber-500">
            <h1 class="text-3xl font-extrabold flex items-center gap-3">
                <x-lucide-users class="w-8 h-8 text-amber-500" />
                Edit Member: {{ $first_name }} {{ $last_name }} 
            </h1>
            <p class="mt-1 text-gray-300">Update the personal, church, and departmental details for this member.</p>
        </div>

        <form wire:submit.prevent="updateMember" class="p-6 space-y-8">

            <fieldset class="border border-gray-200 p-6 rounded-xl shadow-inner bg-gray-50">
                <legend class="px-2 text-lg font-bold text-gray-700">Personal Information</legend>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">

                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700">First Name <span class="text-red-500">*</span></label>
                        <input type="text" id="first_name" wire:model="first_name" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500" required>
                        @error('first_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name <span class="text-red-500">*</span></label>
                        <input type="text" id="last_name" wire:model="last_name" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500" required>
                        @error('last_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="gender" class="block text-sm font-medium text-gray-700">Gender <span class="text-red-500">*</span></label>
                        <select id="gender" wire:model="gender" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500" required>
                            <option value="">Select Gender</option>
                            @foreach ($genders as $g)
                                <option value="{{ $g }}">{{ $g }}</option>
                            @endforeach
                        </select>
                        @error('gender') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="date_of_birth" class="block text-sm font-medium text-gray-700">Date of Birth</label>
                        <input type="date" id="date_of_birth" wire:model="date_of_birth" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                        @error('date_of_birth') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                </div>
            </fieldset>

            <fieldset class="border border-gray-200 p-6 rounded-xl shadow-inner">
                <legend class="px-2 text-lg font-bold text-gray-700">Contact & Address</legend>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number <span class="text-red-500">*</span></label>
                        <input type="text" id="phone" wire:model="phone" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500" required>
                        @error('phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                        <input type="email" id="email" wire:model="email" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                        @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="mt-6">
                    <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                    <textarea id="address" wire:model="address" rows="2" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500"></textarea>
                    @error('address') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </fieldset>

            <fieldset class="border border-gray-200 p-6 rounded-xl shadow-inner bg-gray-50">
                <legend class="px-2 text-lg font-bold text-gray-700">Membership Details</legend>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-4">

                    <div>
                        <label for="date_joined" class="block text-sm font-medium text-gray-700">Date Joined <span class="text-red-500">*</span></label>
                        <input type="date" id="date_joined" wire:model="date_joined" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500" required>
                        @error('date_joined') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700">Church Role <span class="text-red-500">*</span></label>
                        <select id="role" wire:model="role" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500" required>
                            <option value="">Select Role</option>
                            @foreach ($roles as $r)
                                <option value="{{ $r }}">{{ $r }}</option>
                            @endforeach
                        </select>
                        @error('role') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Membership Status <span class="text-red-500">*</span></label>
                        <select id="status" wire:model="status" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500" required>
                            <option value="">Select Status</option>
                            @foreach ($statuses as $s)
                                <option value="{{ $s }}">{{ $s }}</option>
                            @endforeach
                        </select>
                        @error('status') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-3">
                        <label for="department_id" class="block text-sm font-medium text-gray-700">Assigned Department</label>
                        <select id="department_id" wire:model="department_id" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                            <option value="">-- No Department Assigned --</option>
                            @foreach ($departments as $dept)
                                <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                            @endforeach
                        </select>
                        @error('department_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                </div>
            </fieldset>

            <fieldset class="border border-gray-200 p-6 rounded-xl shadow-inner">
                <legend class="px-2 text-lg font-bold text-gray-700">Sacrament Dates (Optional)</legend>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">

                    <div>
                        <label for="baptism_date" class="block text-sm font-medium text-gray-700">Baptism Date</label>
                        <input type="date" id="baptism_date" wire:model="baptism_date" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                        @error('baptism_date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="confirmed_at" class="block text-sm font-medium text-gray-700">Confirmation Date</label>
                        <input type="date" id="confirmed_at" wire:model="confirmed_at" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                        @error('confirmed_at') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                </div>
            </fieldset>
            
            <fieldset class="border border-gray-200 p-6 rounded-xl shadow-inner">
                <legend class="px-2 text-lg font-bold text-gray-700">Profile Photo</legend>
                <div>
                    <label for="profile_photo" class="block text-sm font-medium text-gray-700">Update Profile Photo</label>
                    <input wire:model="profile_photo" type="file" id="profile_photo" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100">
                    @error('profile_photo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </fieldset>

            <div class="pt-6 border-t border-gray-200 flex justify-end gap-4">
                <a href="{{ route('church.members.index') }}" class="px-6 py-3 border border-gray-300 shadow-sm text-base font-medium rounded-xl text-gray-700 bg-white hover:bg-gray-100 transition duration-150">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-3 border border-transparent shadow-lg text-base font-medium rounded-xl text-white bg-amber-600 hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition duration-150 disabled:opacity-50" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="updateMember">Update Member Record</span>
                    <span wire:loading wire:target="updateMember">Updating...</span>
                </button>
            </div>

        </form>
    </div>
</div>
