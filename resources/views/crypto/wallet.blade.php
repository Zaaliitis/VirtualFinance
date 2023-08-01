<x-app-layout>
            <div class="flex justify-center">
                <div class="p-6">
                    @if (session('message'))
                        <div class="{{ session('message')['type'] }} text-xl">
                            {{ session('message')['text'] }}
                        </div>
                    @endif
                    <h2 class="text-2xl font-semibold text-center">Wallet Information</h2>
                    <div class="mt-4">
                        <p class="text-xl"><strong>Name:</strong> {{ $wallet->name }}</p>
                        <p class="text-xl"><strong>Account Number:</strong> {{ $wallet->wallet_number }}</p>
                        <p class="text-xl"><strong>Balance:</strong> {{ number_format($wallet->balance, 2) }} EUR</p>
                        <p class="text-xl"><strong>Wallet Coin Value: </strong>{{ number_format($totalValue, 2) }} EUR</p>

                    </div>
                    <div class="flex justify-center">
                        <div class="mt-6">
                            <a href="/crypto/deposit">
                                <x-button class="mr-4">
                                    Deposit Funds
                                </x-button>
                            </a>
                            <a href="/crypto/withdraw">
                                <x-button>
                                    Withdraw Funds
                                </x-button>
                            </a>
                            <div class="flex justify-center">
                                <form action="{{ route('crypto.delete', ['id' => $wallet->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <x-button type="submit" class="bg-red-500 hover:bg-red-600">
                                        Delete Wallet
                                    </x-button>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="p-6">
                    @if ($ownedCurrencies->isEmpty())
                        <p class="text-center text-xl font-semibold">No Currencies</p>
                    @else
                        <h2 class="text-2xl font-semibold text-center">Currencies</h2>
                        <table class="min-w-full border-collapse mt-4">
                            <thead>
                            <tr>
                                <th class="py-3 px-6 text-center">Currency</th>
                                <th class="py-3 px-6 text-center">Amount</th>
                                <th class="py-3 px-6 text-center">Price</th>
                                <th class="py-3 px-6 text-center">Value</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($ownedCurrencies as $currency)
                                <tr>
                                    <td class="py-3 px-6 border-b hover:underline">
                                        <a href="{{ route('crypto.show', ['id' => $currency->id]) }}">
                                        <img src="{{ asset('images/icons/' . mb_strtolower($currency->symbol) . '.png') }}" alt="{{ $currency->symbol }}" class="h-6 inline-block">
                                            {{ $currency->symbol }}
                                        </a>
                                    </td>
                                    <td class="py-3 px-6 border-b">{{ number_format($currency->amount) }}</td>
                                    @foreach ($currencyRepository as $cryptoCurrency)
                                        @if ($cryptoCurrency->symbol === $currency->symbol)
                                            <td class="py-3 px-6 border-b">{{ number_format($cryptoCurrency->quote->EUR->price, 2) }}</td>
                                            <td class="py-3 px-6 border-b">{{ number_format($cryptoCurrency->quote->EUR->price * $currency->amount, 2) }} EUR</td>

                                    <td class="py-3 px-6 border-b">
                                        <a href="{{ route('crypto.show', ['id' => $cryptoCurrency->id]) }}">
                                            <x-button>
                                                Buy/Sell
                                            </x-button>
                                        </a>
                                    </td>
                                            @break
                                        @endif
                                    @endforeach
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
