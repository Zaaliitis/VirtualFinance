<x-app-layout>
            <div class="flex justify-center">
                <div class="p-6">
                    @if (session('message'))
                        <div class="{{ session('message')['type'] }} text-xl">
                            {{ session('message')['text'] }}
                        </div>
                    @endif
                    <h2 class="text-2xl font-semibold text-center">Withdraw Funds</h2>
                        <p class="text-center text-gray-600">Wallet balance: {{number_format($wallet->balance, 2)}} EUR</p>
                    <div class="mt-4">
                        <form action="{{ route('crypto.withdraw') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="amount" class="block text-sm font-medium text-gray-700">Amount to withdraw:</label>
                                <input type="text" name="amount" id="amount" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>
                            <div class="mb-4">
                                <label for="account" class="block text-sm font-medium text-gray-700">Choose an EUR account:</label>
                                <select id="account" name="account" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    @foreach ($accounts as $account)
                                        @if ($account->currency == 'EUR')
                                            <option value="{{ $account->id }}">{{ $account->name }} - Balance: {{ $account->balance }} {{ $account->currency }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <div class="text-center">
                                <x-button type="submit">
                                    Withdraw
                                </x-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

</x-app-layout>
