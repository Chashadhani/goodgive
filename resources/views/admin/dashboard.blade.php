@extends('admin.layouts.app')

@section('title', 'Dashboard')

@php
    use App\Models\User;
    use App\Models\NgoProfile;
    use App\Models\RecipientProfile;
    use App\Models\DonorProfile;
    
    $totalUsers = User::count();
    $totalDonors = User::where('user_type', 'donor')->count();
    $totalNgos = User::where('user_type', 'ngo')->count();
    $totalRecipients = User::where('user_type', 'user')->count();
    
    $pendingNgos = NgoProfile::where('verification_status', 'pending')->count();
    $verifiedNgos = NgoProfile::where('verification_status', 'verified')->count();
    
    $pendingRequests = RecipientProfile::where('status', 'pending')->count();
    $approvedRequests = RecipientProfile::where('status', 'approved')->count();
    $assistedRequests = RecipientProfile::where('status', 'assisted')->count();
    
    $recentNgos = User::where('user_type', 'ngo')->with('ngoProfile')->latest()->take(5)->get();
    $recentUsers = User::where('user_type', 'user')->with('recipientProfile')->latest()->take(5)->get();
@endphp

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Admin Dashboard</h1>
    <p class="text-gray-600 mt-1">Overview of platform activity and statistics</p>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-2xl shadow-sm p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 uppercase tracking-wide">Total Users</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalUsers }}</p>
            </div>
            <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
        </div>
        <div class="mt-3 flex items-center space-x-4 text-sm">
            <span class="text-blue-600">{{ $totalDonors }} Donors</span>
            <span class="text-green-600">{{ $totalNgos }} NGOs</span>
            <span class="text-pink-600">{{ $totalRecipients }} Users</span>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 uppercase tracking-wide">Pending NGOs</p>
                <p class="text-3xl font-bold text-orange-600 mt-1">{{ $pendingNgos }}</p>
            </div>
            <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
        </div>
        <p class="text-sm text-gray-500 mt-3">{{ $verifiedNgos }} verified NGOs</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 uppercase tracking-wide">Pending Requests</p>
                <p class="text-3xl font-bold text-pink-600 mt-1">{{ $pendingRequests }}</p>
            </div>
            <div class="w-12 h-12 bg-pink-100 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                </svg>
            </div>
        </div>
        <p class="text-sm text-gray-500 mt-3">{{ $approvedRequests }} approved, {{ $assistedRequests }} assisted</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 uppercase tracking-wide">People Assisted</p>
                <p class="text-3xl font-bold text-green-600 mt-1">{{ $assistedRequests }}</p>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
        <p class="text-sm text-green-600 mt-3">✓ Successfully helped</p>
    </div>
</div>

<!-- Quick Actions -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <a href="{{ route('admin.ngos.index', ['status' => 'pending']) }}" class="bg-white rounded-2xl shadow-sm p-6 hover:shadow-md transition group">
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center group-hover:bg-orange-200 transition">
                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <div>
                <h3 class="font-bold text-gray-900">Verify NGOs</h3>
                <p class="text-sm text-gray-500">{{ $pendingNgos }} pending applications</p>
            </div>
        </div>
    </a>

    <a href="{{ route('admin.users.index', ['status' => 'pending']) }}" class="bg-white rounded-2xl shadow-sm p-6 hover:shadow-md transition group">
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 bg-pink-100 rounded-full flex items-center justify-center group-hover:bg-pink-200 transition">
                <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
            <div>
                <h3 class="font-bold text-gray-900">Review Requests</h3>
                <p class="text-sm text-gray-500">{{ $pendingRequests }} pending requests</p>
            </div>
        </div>
    </a>

    <a href="{{ route('admin.requests.index') }}" class="bg-white rounded-2xl shadow-sm p-6 hover:shadow-md transition group">
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center group-hover:bg-green-200 transition">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                </svg>
            </div>
            <div>
                <h3 class="font-bold text-gray-900">Donation Requests</h3>
                <p class="text-sm text-gray-500">View all requests</p>
            </div>
        </div>
    </a>
</div>

<!-- Recent Activity -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent NGO Registrations -->
    <div class="bg-white rounded-2xl shadow-sm p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-gray-900">Recent NGO Registrations</h3>
            <a href="{{ route('admin.ngos.index') }}" class="text-indigo-600 hover:text-indigo-700 text-sm">View all →</a>
        </div>
        @if($recentNgos->count() > 0)
            <div class="space-y-4">
                @foreach($recentNgos as $ngo)
                    <div class="flex items-center justify-between py-2 border-b border-gray-100 last:border-0">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center">
                                <span class="text-indigo-600 font-semibold text-sm">{{ strtoupper(substr($ngo->ngoProfile->organization_name ?? $ngo->name, 0, 2)) }}</span>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">{{ $ngo->ngoProfile->organization_name ?? $ngo->name }}</p>
                                <p class="text-xs text-gray-500">{{ $ngo->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        @if($ngo->ngoProfile?->verification_status === 'verified')
                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Verified</span>
                        @elseif($ngo->ngoProfile?->verification_status === 'rejected')
                            <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Rejected</span>
                        @else
                            <span class="px-2 py-1 text-xs rounded-full bg-orange-100 text-orange-800">Pending</span>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8 text-gray-500">
                <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
                <p>No NGOs registered yet</p>
            </div>
        @endif
    </div>

    <!-- Recent User Requests -->
    <div class="bg-white rounded-2xl shadow-sm p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-gray-900">Recent Assistance Requests</h3>
            <a href="{{ route('admin.users.index') }}" class="text-indigo-600 hover:text-indigo-700 text-sm">View all →</a>
        </div>
        @if($recentUsers->count() > 0)
            <div class="space-y-4">
                @foreach($recentUsers as $user)
                    <div class="flex items-center justify-between py-2 border-b border-gray-100 last:border-0">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-pink-100 rounded-full flex items-center justify-center">
                                <span class="text-pink-600 font-semibold text-sm">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">{{ $user->name }}</p>
                                <p class="text-xs text-gray-500">{{ $user->recipientProfile->category_label ?? 'N/A' }} • {{ $user->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        @if($user->recipientProfile?->status === 'approved')
                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Approved</span>
                        @elseif($user->recipientProfile?->status === 'assisted')
                            <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">Assisted</span>
                        @elseif($user->recipientProfile?->status === 'rejected')
                            <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Rejected</span>
                        @else
                            <span class="px-2 py-1 text-xs rounded-full bg-orange-100 text-orange-800">Pending</span>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8 text-gray-500">
                <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <p>No assistance requests yet</p>
            </div>
        @endif
    </div>
</div>
@endsection
