<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-customWhite overflow-hidden shadow-xl sm:rounded-lg">
                <div class="flex justify-center items-center flex-col">
                    @if (session('message'))
                        <div class="{{ session('message')['type'] }} text-xl">
                            {{ session('message')['text'] }}
                        </div>
                    @endif
                    <img src="{{ asset('images/icons/' . mb_strtolower($cryptoCurrency->symbol) . '.png') }}" alt="{{ $cryptoCurrency->symbol }}" class="h-32 mt-8">
                    <table class="min-w-full border border-gray-300 mt-8 mb-2">
                        <tbody>
                        <tr>
                            <td class="py-3 px-6 border-b border-gray-300 text-center font-bold">Symbol</td>
                            <td class="py-3 px-6 border-b border-gray-300 text-center">{{ $cryptoCurrency->symbol }}</td>
                        </tr>
                        <tr>
                            <td class="py-3 px-6 border-b border-gray-300 text-center font-bold">Name</td>
                            <td class="py-3 px-6 border-b border-gray-300 text-center">{{ $cryptoCurrency->name }}</td>
                        </tr>
                        <tr>
                            <td class="py-3 px-6 border-b border-gray-300 text-center font-bold">Price</td>
                            <td class="py-3 px-6 border-b border-gray-300 text-center">{{ number_format($cryptoCurrency->quote->EUR->price, 5 )}} €</td>
                        </tr>
                        <tr>
                            <td class="py-3 px-6 border-b border-gray-300 text-center font-bold">Volume (24h)</td>
                            <td class="py-3 px-6 border-b border-gray-300 text-center">{{ number_format($cryptoCurrency->quote->EUR->volume_24h, 2 )}}</td>
                        </tr>
                        <tr>
                            <td class="py-3 px-6 border-b border-gray-300 text-center font-bold">Market Cap</td>
                            <td class="py-3 px-6 border-b border-gray-300 text-center">{{ number_format($cryptoCurrency->quote->EUR->market_cap, 2) }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                @if ($wallet)
                <div class="flex flex-col items-center justify-center mt-8 mb-8">
                    <p class="text-lg mb-4">Wallet Balance: {{ number_format($wallet->balance, 2)}} EUR</p>

                    <form action="/crypto/{{ $cryptoCurrency->id }}/buy" method="POST" class="flex items-center mb-4">
                        @csrf
                        <input type="number" min="0" step=".00001" name="quantity" required placeholder="Amount to Buy" class="bg-white border border-gray-300 rounded py-2 px-4 mr-4">
                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
                            Buy
                        </button>
                    </form>

                    @if ($ownedCurrency = $ownedCurrencies->firstWhere('symbol', $cryptoCurrency->symbol))
                        <p class="text-lg mb-4">Coins in Wallet: {{ number_format($ownedCurrency->amount, 2) }} {{$cryptoCurrency->symbol}}</p>
                    @endif

                    <form action="/crypto/{{ $cryptoCurrency->id }}/sell" method="POST" class="flex items-center">
                        @csrf
                        <input type="number" min="0" step=".00001" name="quantity" required placeholder="Amount to Sell" class="bg-white border border-gray-300 rounded py-2 px-4 mr-4">
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">
                            Sell
                        </button>
                    </form>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
