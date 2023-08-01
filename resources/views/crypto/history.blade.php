<x-app-layout>

            <div class="flex justify-center">
                <div class="p-6">
                    <h2 class="text-2xl font-semibold text-center">Crypto Transaction History</h2>
                    @if ($transactions->isEmpty())
                        <p class="text-center text-xl font-semibold mt-4">No transactions found.</p>
                    @else
                        <table class="min-w-full border-collapse mt-4">
                            <thead>
                            <tr>
                                <th class="py-3 px-6 text-left">Type</th>
                                <th class="py-3 px-6 text-left">Currency</th>
                                <th class="py-3 px-6 text-left">Quantity</th>
                                <th class="py-3 px-6 text-left">Price</th>
                                <th class="py-3 px-6 text-left">Sum</th>
                                <th class="py-3 px-6 text-left">Transaction time</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($transactions as $transaction)
                                <tr>
                                    <td class="py-3 px-6 border-b">{{ $transaction->type }}</td>
                                    <td class="py-3 px-6 border-b">{{ $transaction->symbol }}</td>
                                    <td class="py-3 px-6 border-b">{{ $transaction->amount }}</td>
                                    <td class="py-3 px-6 border-b">{{ $transaction->price }}</td>
                                    <td class="py-3 px-6 border-b">{{ number_format($transaction->sum, 2) }}</td>
                                    <td class="py-3 px-6 border-b">{{ $transaction->created_at }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>

</x-app-layout>
