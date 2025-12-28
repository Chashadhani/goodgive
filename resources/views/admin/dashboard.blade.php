<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-3xl font-bold mb-4">Admin Dashboard</h1>
                    <p class="text-gray-600 mb-6">Welcome to the admin panel. Manage all users, NGOs, and donation requests.</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
                        <div class="bg-indigo-50 p-6 rounded-lg">
                            <h3 class="font-bold text-lg mb-2">Manage Users</h3>
                            <p class="text-gray-600">View and manage all registered users</p>
                        </div>
                        <div class="bg-orange-50 p-6 rounded-lg">
                            <h3 class="font-bold text-lg mb-2">NGO Requests</h3>
                            <p class="text-gray-600">Review and approve NGO donation requests</p>
                        </div>
                        <div class="bg-green-50 p-6 rounded-lg">
                            <h3 class="font-bold text-lg mb-2">System Settings</h3>
                            <p class="text-gray-600">Configure platform settings</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
