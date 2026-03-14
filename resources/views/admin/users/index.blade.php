@extends('admin.layouts.app')

@section('title', 'All Users')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">All User Accounts</h1>
    <p class="text-gray-600 mt-1">View and manage all users across every role.</p>
</div>

<!-- Role Filter Tabs -->
<div class="mb-6">
    <div class="border-b border-gray-200">
        <nav class="-mb-px flex space-x-6 overflow-x-auto">
            <a href="{{ route('admin.users.index', ['role' => 'all', 'status' => 'all']) }}" 
               class="py-4 px-1 border-b-2 font-medium text-sm whitespace-nowrap {{ $role === 'all' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                All Users
                <span class="ml-2 bg-gray-100 text-gray-600 py-0.5 px-2 rounded-full text-xs">{{ $counts['all'] }}</span>
            </a>
            <a href="{{ route('admin.users.index', ['role' => 'donor', 'status' => 'all']) }}" 
               class="py-4 px-1 border-b-2 font-medium text-sm whitespace-nowrap {{ $role === 'donor' ? 'border-orange-500 text-orange-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                🤝 Donors
                <span class="ml-2 bg-orange-100 text-orange-600 py-0.5 px-2 rounded-full text-xs">{{ $counts['donor'] }}</span>
            </a>
            <a href="{{ route('admin.users.index', ['role' => 'ngo', 'status' => 'all']) }}" 
               class="py-4 px-1 border-b-2 font-medium text-sm whitespace-nowrap {{ $role === 'ngo' ? 'border-purple-500 text-purple-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                🏢 NGOs
                <span class="ml-2 bg-purple-100 text-purple-600 py-0.5 px-2 rounded-full text-xs">{{ $counts['ngo'] }}</span>
            </a>
            <a href="{{ route('admin.users.index', ['role' => 'user', 'status' => 'all']) }}" 
               class="py-4 px-1 border-b-2 font-medium text-sm whitespace-nowrap {{ $role === 'user' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                🙋 Recipients
                <span class="ml-2 bg-blue-100 text-blue-600 py-0.5 px-2 rounded-full text-xs">{{ $counts['user'] }}</span>
            </a>
            <a href="{{ route('admin.users.index', ['role' => 'admin', 'status' => 'all']) }}" 
               class="py-4 px-1 border-b-2 font-medium text-sm whitespace-nowrap {{ $role === 'admin' ? 'border-red-500 text-red-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                🛡️ Admins
                <span class="ml-2 bg-red-100 text-red-600 py-0.5 px-2 rounded-full text-xs">{{ $counts['admin'] }}</span>
            </a>
            <a href="{{ route('admin.users.index', ['role' => 'staff', 'status' => 'all']) }}" 
               class="py-4 px-1 border-b-2 font-medium text-sm whitespace-nowrap {{ $role === 'staff' ? 'border-teal-500 text-teal-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                👤 Staff
                <span class="ml-2 bg-teal-100 text-teal-600 py-0.5 px-2 rounded-full text-xs">{{ $counts['staff'] }}</span>
            </a>
        </nav>
    </div>
</div>

<!-- Recipient Status Sub-filters (only when viewing recipients) -->
@if($role === 'user')
<div class="mb-4 flex space-x-3">
    <a href="{{ route('admin.users.index', ['role' => 'user', 'status' => 'all']) }}" 
       class="px-4 py-2 rounded-lg text-sm font-medium {{ $status === 'all' ? 'bg-indigo-600 text-white' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200' }}">
        All
    </a>
    <a href="{{ route('admin.users.index', ['role' => 'user', 'status' => 'pending']) }}" 
       class="px-4 py-2 rounded-lg text-sm font-medium {{ $status === 'pending' ? 'bg-orange-500 text-white' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200' }}">
        Pending ({{ $counts['pending'] }})
    </a>
    <a href="{{ route('admin.users.index', ['role' => 'user', 'status' => 'approved']) }}" 
       class="px-4 py-2 rounded-lg text-sm font-medium {{ $status === 'approved' ? 'bg-green-600 text-white' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200' }}">
        Approved ({{ $counts['approved'] }})
    </a>
    <a href="{{ route('admin.users.index', ['role' => 'user', 'status' => 'rejected']) }}" 
       class="px-4 py-2 rounded-lg text-sm font-medium {{ $status === 'rejected' ? 'bg-red-600 text-white' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200' }}">
        Rejected ({{ $counts['rejected'] }})
    </a>
</div>
@endif

<!-- Users List -->
<div class="bg-white rounded-2xl shadow-sm overflow-hidden">
    @if($users->count() > 0)
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Details</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Registered</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($users as $user)
                    @php
                        $roleColors = [
                            'donor' => ['bg' => 'bg-orange-100', 'text' => 'text-orange-700', 'label' => '🤝 Donor'],
                            'ngo' => ['bg' => 'bg-purple-100', 'text' => 'text-purple-700', 'label' => '🏢 NGO'],
                            'user' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-700', 'label' => '🙋 Recipient'],
                            'admin' => ['bg' => 'bg-red-100', 'text' => 'text-red-700', 'label' => '🛡️ Admin'],
                            'staff' => ['bg' => 'bg-teal-100', 'text' => 'text-teal-700', 'label' => '👤 Staff'],
                        ];
                        $rc = $roleColors[$user->user_type] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-700', 'label' => ucfirst($user->user_type)];
                    @endphp
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-10 h-10 {{ $rc['bg'] }} rounded-full flex items-center justify-center">
                                    <span class="{{ $rc['text'] }} font-semibold text-sm">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $rc['bg'] }} {{ $rc['text'] }}">
                                {{ $rc['label'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">
                                @if($user->user_type === 'donor')
                                    <span class="text-gray-500">Phone:</span> {{ $user->donorProfile->phone ?? 'N/A' }}<br>
                                    <span class="text-gray-500">Donated:</span> Rs. {{ number_format($user->donorProfile->total_donated ?? 0, 2) }}
                                @elseif($user->user_type === 'ngo')
                                    <span class="text-gray-500">Org:</span> {{ $user->ngoProfile->organization_name ?? 'N/A' }}<br>
                                    <span class="text-gray-500">Phone:</span> {{ $user->ngoProfile->phone ?? 'N/A' }}
                                @elseif($user->user_type === 'user')
                                    <span class="text-gray-500">Phone:</span> {{ $user->recipientProfile->phone ?? 'N/A' }}<br>
                                    <span class="text-gray-500">Location:</span> {{ $user->recipientProfile->location ?? 'N/A' }}
                                @else
                                    <span class="text-gray-400">—</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($user->user_type === 'user')
                                @if($user->recipientProfile?->status === 'approved')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">✅ Approved</span>
                                @elseif($user->recipientProfile?->status === 'rejected')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">❌ Rejected</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">⏳ Pending</span>
                                @endif
                            @elseif($user->user_type === 'ngo')
                                @if($user->ngoProfile?->verification_status === 'verified')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">✅ Verified</span>
                                @elseif($user->ngoProfile?->verification_status === 'rejected')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">❌ Rejected</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">⏳ Pending</span>
                                @endif
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">✅ Active</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $user->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end space-x-2">
                                <a href="{{ route('admin.users.show', $user) }}" class="text-indigo-600 hover:text-indigo-900 font-medium">View</a>
                                
                                @if($user->user_type === 'user' && $user->recipientProfile?->status === 'pending')
                                    <form action="{{ route('admin.users.approve', $user) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-green-600 hover:text-green-900">Approve</button>
                                    </form>
                                @endif
                                
                                @if($user->user_type === 'user' && $user->recipientProfile?->status !== 'rejected')
                                    <button type="button" onclick="openRejectModal({{ $user->id }})" class="text-red-600 hover:text-red-900">Reject</button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $users->appends(['status' => $status, 'role' => $role])->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No users found</h3>
            <p class="mt-1 text-sm text-gray-500">No users match the selected filters.</p>
        </div>
    @endif
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-2xl bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-900">Reject Account</h3>
                <button type="button" onclick="closeRejectModal()" class="text-gray-400 hover:text-gray-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <form id="rejectForm" method="POST">
                @csrf
                @method('PATCH')
                <div class="mb-4">
                    <label for="rejection_reason" class="block text-sm font-medium text-gray-700 mb-2">Reason for Rejection</label>
                    <textarea name="rejection_reason" id="rejection_reason" rows="4" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
                        placeholder="Please provide a reason for rejecting this account..."></textarea>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeRejectModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                        Reject Account
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function openRejectModal(userId) {
        document.getElementById('rejectForm').action = '/admin/users/' + userId + '/reject';
        document.getElementById('rejectModal').classList.remove('hidden');
    }
    
    function closeRejectModal() {
        document.getElementById('rejectModal').classList.add('hidden');
        document.getElementById('rejection_reason').value = '';
    }
</script>
@endpush
@endsection
