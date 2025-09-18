<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p>
                    Welcome to your Loan Management and EMI Processing Application! 
                    Here, you can manage loan details, calculate EMIs automatically, 
                    and view structured monthly payment tables for each client.
                </p>

                <a href="{{ route('loan-details') }}" 
                   class="inline-block px-10 py-3 
                                  bg-gradient-to-r from-purple-500 via-pink-500 to-red-500 
                                 font-bold uppercase tracking-wide
                                  rounded-full shadow-xl 
                                  hover:from-purple-600 hover:via-pink-600 hover:to-red-600
                                  focus:outline-none focus:ring-2 focus:ring-pink-400 focus:ring-offset-2
                                  transition-all duration-300 ease-in-out">
                   View Loan Details
                </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
