@extends('admin.layouts.app')

@section('title', 'NGO Verification')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">NGO Verification</h1>
    <p class="text-gray-600 mt-1">Review and verify NGO applications</p>
</div>

<!-- Status Tabs -->
<div class="mb-6">
    <div class="border-b border-gray-200">
        <nav class="-mb-px flex space-x-8">
            <a href="{{ route('admin.ngos.index', ['status' => 'all']) }}" 
               class="py-4 px-1 border-b-2 font-medium text-sm {{ $status === 'all' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                All NGOs
                <span class="ml-2 bg-gray-100 text-gray-600 py-0.5 px-2 rounded-full text-xs">{{ $counts['all'] }}</span>
            </a>
            <a href="{{ route('admin.ngos.index', ['status' => 'pending']) }}" 
               class="py-4 px-1 border-b-2 font-medium text-sm {{ $status === 'pending' ? 'border-orange-500 text-orange-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                Pending
                <span class="ml-2 bg-orange-100 text-orange-600 py-0.5 px-2 rounded-full text-xs">{{ $counts['pending'] }}</span>
            </a>
            <a href="{{ route('admin.ngos.index', ['status' => 'verified']) }}" 
               class="py-4 px-1 border-b-2 font-medium text-sm {{ $status === 'verified' ? 'border-green-500 text-green-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                Verified
                <span class="ml-2 bg-green-100 text-green-600 py-0.5 px-2 rounded-full text-xs">{{ $counts['verified'] }}</span>
            </a>
            <a href="{{ route('admin.ngos.index', ['status' => 'rejected']) }}" 
               class="py-4 px-1 border-b-2 font-medium text-sm {{ $status === 'rejected' ? 'border-red-500 text-red-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                Rejected
                <span class="ml-2 bg-red-100 text-red-600 py-0.5 px-2 rounded-full text-xs">{{ $counts['rejected'] }}</span>
            </a>
        </nav>
    </div>
</div>

<!-- NGO List -->
<div class="bg-white rounded-2xl shadow-sm overflow-hidden">
    @if($ngos->count() > 0)
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Organization</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Registration #</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Registered</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($ngos as $ngo)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center">
                                    <span class="text-indigo-600 font-semibold text-sm">{{ strtoupper(substr($ngo->ngoProfile->organization_name ?? $ngo->name, 0, 2)) }}</span>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $ngo->ngoProfile->organization_name ?? 'N/A' }}</div>
                                    <div class="text-sm text-gray-500">{{ $ngo->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $ngo->ngoProfile->contact_person ?? $ngo->name }}</div>
                            <div class="text-sm text-gray-500">{{ $ngo->ngoProfile->phone ?? 'N/A' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $ngo->ngoProfile->registration_number ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($ngo->ngoProfile?->verification_status === 'verified')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    Verified
                                </span>
                            @elseif($ngo->ngoProfile?->verification_status === 'rejected')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                    </svg>
                                    Rejected
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                    </svg>
                                    Pending
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $ngo->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end space-x-2">
                                <a href="{{ route('admin.ngos.show', $ngo) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                
                                @if($ngo->ngoProfile?->verification_status !== 'verified')
                                    <form action="{{ route('admin.ngos.verify', $ngo) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-green-600 hover:text-green-900">Verify</button>
                                    </form>
                                @endif
                                
                                @if($ngo->ngoProfile?->verification_status !== 'rejected')
                                    <button type="button" onclick="openRejectModal({{ $ngo->id }})" class="text-red-600 hover:text-red-900">Reject</button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $ngos->appends(['status' => $status])->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No NGOs found</h3>
            <p class="mt-1 text-sm text-gray-500">
                @if($status === 'pending')
                    No pending NGO applications at the moment.
                @elseif($status === 'verified')
                    No verified NGOs yet.
                @elseif($status === 'rejected')
                    No rejected NGO applications.
                @else
                    No NGOs have registered yet.
                @endif
            </p>
        </div>
    @endif
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-2xl bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-900">Reject NGO Application</h3>
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
                        placeholder="Please provide a reason for rejecting this NGO application..."></textarea>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeRejectModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                        Reject NGO
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function openRejectModal(ngoId) {
        document.getElementById('rejectForm').action = '/admin/ngos/' + ngoId + '/reject';
        document.getElementById('rejectModal').classList.remove('hidden');
    }
    
    function closeRejectModal() {
        document.getElementById('rejectModal').classList.add('hidden');
        document.getElementById('rejection_reason').value = '';
    }
</script>
@endpush
@endsection
