

@extends('layouts.dashboard')

@section('content')
    <livewire:church-admin-dashboard.member-edit :member="$member" />
@endsection