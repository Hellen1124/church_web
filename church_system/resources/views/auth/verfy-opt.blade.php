@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-2xl mx-auto">
            <livewire:auth.verify-otp-form :phone="$phone" />
        </div>
    </div>
@endsection
