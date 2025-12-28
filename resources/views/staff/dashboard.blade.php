<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Staff Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-3xl font-bold mb-4">Staff Dashboard</h1>
                    <p class="text-gray-600 mb-6">Welcome to the staff panel. Help manage donation requests and support users.</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
                        <div class="bg-indigo-50 p-6 rounded-lg">
                            <h3 class="font-bold text-lg mb-2">View Users</h3>
                            <p class="text-gray-600">View registered users and their activities</p>
                        </div>
                        <div class="bg-orange-50 p-6 rounded-lg">
                            <h3 class="font-bold text-lg mb-2">NGO Requests</h3>
                            <p class="text-gray-600">Review NGO donation requests</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
