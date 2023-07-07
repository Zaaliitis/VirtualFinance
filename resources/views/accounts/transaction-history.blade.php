<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-customWhite overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-customWhite border-b border-gray-200 text-center">
                    <h1 class="mt-8 text-2xl font-medium text-gray-900">
                        Transaction History
                    </h1>

                    <div class="mt-6">
                        <form action="{{ route('transaction-history', ['account' => $account]) }}" method="GET">
                            <div class="flex justify-center space-x-4">
                                <div class="m-2">
                                    <label for="start_date" class="block font-medium text-gray-700">Start Date:</label>
                                    <input type="date" name="start_date" id="start_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div class="m-2">
                                    <label for="end_date" class="block font-medium text-gray-700">End Date:</label>
                                    <input type="date" name="end_date" id="end_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div class="m-2">
                                    <label for="search" class="block font-medium text-gray-700">Search:</label>
                                    <input type="text" name="search" id="search" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                            </div>
                            <div class="self-center">
                                <x-button type="submit">Apply Filter</x-button>
                            </div>
                        </form>
                    </div>

                @if ($transactions->isEmpty())
                        <p class="mt-4">No transactions found.</p>
                    @else
                        <div class="mt-4 overflow-x-auto">
                            <table class="table w-full border border-gray-200">
                                <thead>
                                <tr>
                                    <th class="py-2 px-4 border-b">Sender</th>
                                    <th class="py-2 px-4 border-b">Receiver</th>
                                    <th class="py-2 px-4 border-b">Amount</th>
                                    <th class="py-2 px-4 border-b">Description</th>
                                    <th class="py-2 px-4 border-b">Date</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($transactions as $transaction)
                                    <tr>
                                        <td class="py-2 px-4 border-b">{{ $transaction->senderAccount->account_number }}</td>
                                        <td class="py-2 px-4 border-b">{{ $transaction->name }} | {{ $transaction->receiverAccount->account_number }}</td>
                                        <td class="py-2 px-4 border-b">
                                            @if ($transaction->sender_account_id == $account->id)
                                                -{{ $transaction->amount }} {{$transaction->currency}}
                                            @else
                                                +{{ $transaction->amount }} {{$transaction->currency}}
                                            @endif
                                        </td>
                                        <td class="py-2 px-4 border-b">{{ $transaction->description }}</td>
                                        <td class="py-2 px-4 border-b">{{ $transaction->created_at }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
