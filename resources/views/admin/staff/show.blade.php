@extends('admin.layouts.app')

@section('title', 'Staff Application - ' . $staffApplication->full_name)

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.staff.index') }}" class="text-indigo-600 hover:text-indigo-700 text-sm font-medium">
        ← Back to Staff Applications
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Info -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Application Details Card -->
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
            <div class="px-6 py-4 
                @if($staffApplication->status === 'approved') bg-gradient-to-r from-green-500 to-emerald-500
                @elseif($staffApplication->status === 'rejected') bg-gradient-to-r from-red-500 to-pink-500
                @else bg-gradient-to-r from-orange-500 to-yellow-500
                @endif">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <span class="text-3xl">👤</span>
                        <div>
                            <h1 class="text-xl font-bold text-white">{{ $staffApplication->full_name }}</h1>
                            <p class="text-white/80 text-sm">{{ $staffApplication->position_label }} • Application #{{ $staffApplication->id }}</p>
                        </div>
                    </div>
                    <span class="px-3 py-1.5 rounded-full text-sm font-bold
                        @if($staffApplication->status === 'approved') bg-white text-green-700
                        @elseif($staffApplication->status === 'rejected') bg-white text-red-700
                        @else bg-white text-orange-700
                        @endif">
                        {{ ucfirst($staffApplication->status) }}
                    </span>
                </div>
            </div>

            <div class="p-6 space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="text-xs text-gray-500 uppercase tracking-wide">Email</p>
                        <p class="font-semibold text-gray-900 mt-1">{{ $staffApplication->email }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="text-xs text-gray-500 uppercase tracking-wide">Phone</p>
                        <p class="font-semibold text-gray-900 mt-1">{{ $staffApplication->phone }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="text-xs text-gray-500 uppercase tracking-wide">NIC Number</p>
                        <p class="font-semibold text-gray-900 mt-1">{{ $staffApplication->nic }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="text-xs text-gray-500 uppercase tracking-wide">Applied On</p>
                        <p class="font-semibold text-gray-900 mt-1">{{ $staffApplication->created_at->format('M d, Y h:i A') }}</p>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-xs text-gray-500 uppercase tracking-wide">Address</p>
                    <p class="text-gray-900 mt-1">{{ $staffApplication->address }}</p>
                </div>

                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-xs text-gray-500 uppercase tracking-wide">Desired Position</p>
                    <p class="font-semibold text-gray-900 mt-1">{{ $staffApplication->position_label }}</p>
                </div>

                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-xs text-gray-500 uppercase tracking-wide">Experience & Skills</p>
                    <p class="text-gray-900 mt-1 whitespace-pre-wrap">{{ $staffApplication->experience }}</p>
                </div>

                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-xs text-gray-500 uppercase tracking-wide">Motivation</p>
                    <p class="text-gray-900 mt-1 whitespace-pre-wrap">{{ $staffApplication->motivation }}</p>
                </div>

                @if($staffApplication->resume)
                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                        <p class="text-xs text-blue-500 uppercase tracking-wide mb-2">Resume / CV</p>
                        <a href="{{ Storage::url($staffApplication->resume) }}" target="_blank" class="inline-flex items-center text-blue-700 hover:text-blue-800 font-medium">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Download Resume
                        </a>
                    </div>
                @endif

                @if($staffApplication->reviewed_at)
                    <div class="border-t border-gray-100 pt-4">
                        <h3 class="text-sm font-semibold text-gray-700 mb-3">Review Info</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-gray-50 rounded-xl p-3">
                                <p class="text-xs text-gray-500">Reviewed By</p>
                                <p class="text-sm font-medium text-gray-900 mt-0.5">{{ $staffApplication->reviewer?->name ?? 'Admin' }}</p>
                            </div>
                            <div class="bg-gray-50 rounded-xl p-3">
                                <p class="text-xs text-gray-500">Reviewed At</p>
                                <p class="text-sm font-medium text-gray-900 mt-0.5">{{ $staffApplication->reviewed_at->format('M d, Y h:i A') }}</p>
                            </div>
                        </div>
                        @if($staffApplication->admin_notes)
                            <div class="bg-gray-50 rounded-xl p-3 mt-3">
                                <p class="text-xs text-gray-500">Admin Notes</p>
                                <p class="text-sm text-gray-900 mt-0.5">{{ $staffApplication->admin_notes }}</p>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        <!-- Generated Credentials (shown after approval) -->
        @if($staffApplication->isApproved() && $staffApplication->generated_username)
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-2 border-green-300 rounded-2xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 bg-green-600">
                    <h2 class="text-lg font-bold text-white flex items-center">
                        <span class="mr-2">🔑</span> Generated Staff Credentials
                    </h2>
                    <p class="text-green-100 text-sm mt-1">Share these credentials with the applicant so they can log in to the admin panel.</p>
                </div>
                <div class="p-6">
                    <div class="bg-white rounded-xl p-6 border border-green-200 space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold mb-1">Username (Login Email)</p>
                                <div class="flex items-center space-x-2">
                                    <code class="bg-gray-100 px-4 py-2 rounded-lg text-lg font-mono font-bold text-gray-900">{{ $staffApplication->email }}</code>
                                </div>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold mb-1">Generated Username</p>
                                <div class="flex items-center space-x-2">
                                    <code class="bg-gray-100 px-4 py-2 rounded-lg text-lg font-mono font-bold text-indigo-700">{{ $staffApplication->generated_username }}</code>
                                </div>
                            </div>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold mb-1">Generated Password</p>
                            <div class="flex items-center space-x-2">
                                <code class="bg-yellow-50 border border-yellow-300 px-4 py-2 rounded-lg text-lg font-mono font-bold text-yellow-800">{{ $staffApplication->generated_password_plain }}</code>
                            </div>
                        </div>
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 mt-2">
                            <p class="text-sm text-yellow-800">
                                <strong>Important:</strong> Please share these credentials securely with the staff member. They should use their <strong>email</strong> and the <strong>generated password</strong> to log in at the <a href="{{ route('admin.login') }}" class="underline font-semibold">Admin Login</a> page. They should change their password after first login.
                            </p>
                        </div>
                    </div>
                    <div class="mt-4 bg-gray-50 rounded-lg p-3 text-center">
                        <p class="text-sm text-gray-500">Login URL: <code class="bg-gray-200 px-2 py-1 rounded text-gray-800">{{ route('admin.login') }}</code></p>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Applicant Quick Info -->
        <div class="bg-white rounded-2xl shadow-sm p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Applicant Info</h3>
            <div class="space-y-3">
                <div class="flex items-center space-x-3">
                    <div class="w-14 h-14 bg-indigo-100 rounded-full flex items-center justify-center">
                        <span class="text-indigo-600 font-bold text-xl">{{ strtoupper(substr($staffApplication->full_name, 0, 2)) }}</span>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-900">{{ $staffApplication->full_name }}</p>
                        <p class="text-sm text-gray-500">{{ $staffApplication->email }}</p>
                    </div>
                </div>
                <div class="border-t border-gray-100 pt-3 space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Phone</span>
                        <span class="text-gray-900">{{ $staffApplication->phone }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">NIC</span>
                        <span class="text-gray-900">{{ $staffApplication->nic }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Position</span>
                        <span class="text-gray-900 font-medium">{{ $staffApplication->position_label }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Admin Actions -->
        <div class="bg-white rounded-2xl shadow-sm p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Actions</h3>
            
            @if($staffApplication->isPending())
                <!-- Approve -->
                <form action="{{ route('admin.staff.approve', $staffApplication) }}" method="POST" class="mb-3">
                    @csrf
                    @method('PATCH')
                    <textarea name="admin_notes" rows="2" placeholder="Admin notes (optional)..." 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 mb-2"></textarea>
                    <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2.5 rounded-lg font-semibold transition"
                        onclick="return confirm('Approve this application? A staff account with random credentials will be created.')">
                        ✓ Approve & Generate Credentials
                    </button>
                </form>

                <!-- Reject -->
                <form action="{{ route('admin.staff.reject', $staffApplication) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="admin_notes" value="">
                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2.5 rounded-lg font-semibold transition"
                        onclick="return confirm('Are you sure you want to reject this application?')">
                        ✕ Reject Application
                    </button>
                </form>
            @elseif($staffApplication->isApproved())
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 text-center">
                    <span class="text-3xl block mb-2">✅</span>
                    <p class="text-green-800 font-semibold">Application Approved</p>
                    <p class="text-sm text-green-600 mt-1">Staff account has been created</p>
                </div>
            @elseif($staffApplication->isRejected())
                <div class="bg-red-50 border border-red-200 rounded-lg p-4 text-center">
                    <span class="text-3xl block mb-2">❌</span>
                    <p class="text-red-800 font-semibold">Application Rejected</p>
                    @if($staffApplication->reviewed_at)
                        <p class="text-sm text-red-600 mt-1">On {{ $staffApplication->reviewed_at->format('M d, Y') }}</p>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
