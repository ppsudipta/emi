<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Loan Details
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- Page Title -->

                    <!-- Table Container -->
                    <div class="overflow-hidden rounded-lg shadow-lg border border-gray-200">
                        <table class="min-w-full text-sm text-left">
                            <thead class="bg-gradient-to-r from-indigo-500 to-purple-600">
                                <tr>
                                    <th class="px-6 py-3 font-semibold uppercase tracking-wider">Client ID</th>
                                    <th class="px-6 py-3 font-semibold uppercase tracking-wider">Num of Payments</th>
                                    <th class="px-6 py-3 font-semibold uppercase tracking-wider">First Payment Date</th>
                                    <th class="px-6 py-3 font-semibold uppercase tracking-wider">Last Payment Date</th>
                                    <th class="px-6 py-3 font-semibold uppercase tracking-wider">Loan Amount</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @foreach($loanDetails as $loan)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 text-gray-800">{{ $loan->clientid }}</td>
                                    <td class="px-6 py-4 text-gray-800">{{ $loan->num_of_payment }}</td>
                                    <td class="px-6 py-4 text-gray-800">{{ $loan->first_payment_date }}</td>
                                    <td class="px-6 py-4 text-gray-800">{{ $loan->last_payment_date }}</td>
                                    <td class="px-6 py-4 font-semibold text-gray-900">
                                        ₹ {{ number_format($loan->loan_amount, 2) }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>


                    <div class="h-12"></div>

                    <!-- Button -->
                    <div class="mt-16 flex justify-end">
                        <a href="{{ route('process.page') }}"
                           class="inline-block px-10 py-3 
                                  bg-gradient-to-r from-purple-500 via-pink-500 to-red-500 
                                 font-bold uppercase tracking-wide
                                  rounded-full shadow-xl 
                                  hover:from-purple-600 hover:via-pink-600 hover:to-red-600
                                  focus:outline-none focus:ring-2 focus:ring-pink-400 focus:ring-offset-2
                                  transition-all duration-300 ease-in-out">
                           🚀 Start EMI Process
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
