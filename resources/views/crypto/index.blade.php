<x-app-layout>
                <div class="flex justify-center items-center px-4 py-3">
                    @if ($userHasWallet)
                        <form method="GET" action="{{ url('/crypto/history') }}">
                            <x-button class="ml-52" type="submit">
                                Show investment history
                            </x-button>
                        </form>
                    @endif
                    @if (!$userHasWallet)
                        <form method="GET" action="{{ url('/crypto/create') }}">
                            <x-button class="">
                                Create Investment Wallet
                            </x-button>
                        </form>
                    @endif
                    @if ($userHasWallet)
                        <form method="GET" action="{{ url('/crypto/wallet') }}">
                            <x-button class="mr-52">
                                Wallet
                            </x-button>
                        </form>
                    @endif

                </div>

                <div class="flex justify-center">
                    <table class="min-w-full border-collapse">
                        <thead>
                        <tr>
                            <th class="py-3 px-6 border-b text-center" colspan="3">
                                <form method="GET" action="{{ url('/crypto') }}">
                                    <div class="flex">
                                        <input type="text" name="search" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Search by symbol">
                                        <x-button type="submit">Search</x-button>
                                    </div>
                                </form>
                            </th>
                            <th class="py-3 px-6 border-b text-center" colspan="4">Price Changes*</th>
                        </tr>
                        <tr>
                            <th class="py-3 px-6 border-b text-center">Name</th>
                            <th class="py-3 px-6 border-b text-center">Symbol</th>
                            <th class="py-3 px-6 border-b text-center">Price*</th>
                            <th class="py-3 px-4 border-b text-center">24h</th>
                            <th class="py-3 px-4 border-b text-center">7d</th>
                            <th class="py-3 px-4 border-b text-center">30d</th>
                            <th class="py-3 px-4 border-b text-center">90d</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($cryptoCurrencies as $cryptoCurrency)
                            <tr>
                                <td class="py-3 px-6 border-b text-center hover:underline">
                                    <a href="{{ route('crypto.show', ['id' => $cryptoCurrency->id]) }}">
                                        {{ $cryptoCurrency->name }}
                                    </a>
                                </td>
                                <td class="py-3 px-6 border-b text-center">
                                    <a href="{{ route('crypto.show', ['id' => $cryptoCurrency->id]) }}">
                                        @if (file_exists(public_path('images/icons/' . mb_strtolower($cryptoCurrency->symbol) . '.png')))
                                            <img
                                                src="{{ asset('images/icons/' . mb_strtolower($cryptoCurrency->symbol) . '.png') }}"
                                                alt="{{ $cryptoCurrency->symbol }}" class="h-6 mr-3 inline-block">
                                        @endif
                                        {{ $cryptoCurrency->symbol }}
                                    </a>
                                </td>
                                <td class="py-3 px-6 border-b text-center">{{ number_format($cryptoCurrency->quote->EUR->price, 5) }}
                                    €
                                </td>
                                <td class="py-3 px-4 border-b text-center">{{ number_format($cryptoCurrency->quote->EUR->percent_change_24h, 2) }}
                                    %
                                </td>
                                <td class="py-3 px-4 border-b text-center">{{ number_format($cryptoCurrency->quote->EUR->percent_change_7d, 2) }}
                                    %
                                </td>
                                <td class="py-3 px-4 border-b text-center">{{ number_format($cryptoCurrency->quote->EUR->percent_change_30d, 2) }}
                                    %
                                </td>
                                <td class="py-3 px-4 border-b text-center">{{ number_format($cryptoCurrency->quote->EUR->percent_change_90d, 2) }}
                                    %
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="flex justify-center mt-4">
                    {{ $cryptoCurrencies->links() }}
                </div>
                <p class="text-gray-400 flex justify-center mb-4">*Price and price changes are updated every 10 minutes,
                    purchasing a currency will use real time data</p>

</x-app-layout>
