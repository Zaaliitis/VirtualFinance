<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-customWhite overflow-hidden shadow-xl sm:rounded-lg flex justify-center">
                <div class="p-6">
                    @if (session('message'))
                        <div class="{{ session('message')['type'] }} text-xl">
                            {{ session('message')['text'] }}
                        </div>
                    @endif
                    <h2 class="text-2xl font-semibold text-center">Deposit Funds</h2>
                    <div class="mt-4">
                        <form action="{{ route('crypto.deposit') }}" method="POST">
                            @csrf
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
                            <div class="mb-4">
                                <label for="amount" class="block text-sm font-medium text-gray-700">Amount to deposit:</label>
                                <input type="text" name="amount" id="amount" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>
                            <div class="text-center">
                                <x-button type="submit">
                                    Deposit
                                </x-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
