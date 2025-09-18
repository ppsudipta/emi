<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Process EMI') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- Display success message --}}
                    @if(session('success'))
                        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                            {{ session('success') }}
                        </div>
                    @endif



                {{-- Process Data Button OR Loan Details Link --}}
                    @if(isset($emiResults) && !empty($emiResults['data']))
                        <a href="{{ route('loan-details') }}" 
                         class="inline-block px-10 py-3 
                                  bg-gradient-to-r from-purple-500 via-pink-500 to-red-500 
                                 font-bold uppercase tracking-wide
                                  rounded-full shadow-xl 
                                  hover:from-purple-600 hover:via-pink-600 hover:to-red-600
                                  focus:outline-none focus:ring-2 focus:ring-pink-400 focus:ring-offset-2
                                  transition-all duration-300 ease-in-out">
                            Process Data || Loan Details
                        </a>
                    @else
                        <form method="POST" action="{{ route('process.do') }}">
                            @csrf
                            <button type="submit" 
                                 class="inline-block px-10 py-3 
                                  bg-gradient-to-r from-purple-500 via-pink-500 to-red-500 
                                 font-bold uppercase tracking-wide
                                  rounded-full shadow-xl 
                                  hover:from-purple-600 hover:via-pink-600 hover:to-red-600
                                  focus:outline-none focus:ring-2 focus:ring-pink-400 focus:ring-offset-2
                                  transition-all duration-300 ease-in-out">
                                Process Data
                            </button>
                        </form>
                    @endif

                    <!-- {{-- Process Data Button --}}
                    <form method="POST" action="{{ route('process.do') }}">
                        @csrf
                        <button type="submit" 
                            class="px-4 py-2 bg-blue-600  font-semibold rounded hover:bg-blue-700">
                            Process Data
                        </button>
                    </form> -->

                    {{-- Display EMI table if data exists --}}
                    @isset($emiResults)
                        <div class="mt-6 overflow-auto border rounded" style="overflow: auto;">
                            <table class="table-auto border-collapse border border-gray-200 min-w-full">
                                <thead class="bg-gray-50 sticky top-0 z-10">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase whitespace-nowrap">
                                            Client ID
                                        </th>
                                        @foreach($emiResults['months'] as $month)
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase whitespace-nowrap">
                                                {{ $month }}
                                            </th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($emiResults['data'] as $row)
                                        <tr>
                                            <td class="px-4 py-2 text-sm text-gray-900 whitespace-nowrap">{{ $row->clientid }}</td>
                                            @foreach($emiResults['months'] as $month)
                                                <td class="px-4 py-2 text-sm text-gray-900 whitespace-nowrap">
                                                    {{ number_format($row->$month ?? 0, 2) }}
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endisset

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
