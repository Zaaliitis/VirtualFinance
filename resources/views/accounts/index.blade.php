<x-app-layout>
                <div class="p-6 lg:p-8 bg-customWhite">
                    @if (session('message'))
                        <div class="{{ session('message')['type'] }} text-xl">
                            {{ session('message')['text'] }}
                        </div>
                    @endif
                    <h1 class=" flex justify-center mt-4 text-2xl font-medium text-gray-900">
                        Welcome to Account page!
                    </h1>
                </div>

                <div class="p-2 mb-6 lg:p-2 bg-customWhite flex justify-center">
                    <form method="GET" action="{{ route('accounts.create') }}">
                        <x-button class="h-12 mt-3" type="submit">Create New Account</x-button>
                    </form>

                    <form action="{{ route('accounts.show') }}" method="GET" class="ml-4 mt-3">
                        <label for="account"></label>
                        <select name="account" id="account" onchange="this.form.submit()" class="w-full py-3 px-4 bg-white border border-gray-300 rounded-md shadow-sm">
                            <option value="" {{ !$selectedAccount ? 'selected' : '' }}>Select an account</option>
                            @foreach ($userAccounts as $account)
                                <option value="{{ $account->id }}" {{ $selectedAccount && $selectedAccount->id == $account->id ? 'selected' : '' }}>
                                    {{ $account->name }} {{ $account->account_number }}
                                </option>
                            @endforeach
                        </select>

                    </form>
                    <form method="GET" action="{{ route('accounts.transfer') }}">
                        <x-button class='ml-6 h-12 mt-3' type="submit">Transfer Funds</x-button>
                    </form>
                </div>
                <div class="flex flex-col items-center">
                    @if ($selectedAccount)
                        <div>
                            <p class="font-bold text-center text-xl">Account Details</p>
                            <table class="border border-gray-300 mt-2">
                                <tr>
                                    <td class="py-2 px-4 border-b border-gray-300"><strong>Name:</strong></td>
                                    <td class="py-2 px-4 border-b border-gray-300">{{ $selectedAccount->name }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 px-4 border-b border-gray-300"><strong>Account Number:</strong></td>
                                    <td class="py-2 px-4 border-b border-gray-300">{{ $selectedAccount->account_number }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 px-4 border-b border-gray-300"><strong>Balance:</strong></td>
                                    <td class="py-2 px-4 border-b border-gray-300">{{ $selectedAccount->balance }} {{ $selectedAccount->currency }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 px-4 border-b border-gray-300"><strong>Created at:</strong></td>
                                    <td class="py-2 px-4 border-b border-gray-300">{{ $selectedAccount->created_at }}</td>
                                </tr>
                            </table>
                        </div>

                        <div class="mt-4 mb-4 flex">
                            <form action="{{ route('transaction-history', ['account' => $selectedAccount->id]) }}" method="POST">
                                @csrf
                                <input type="hidden" name="_method" value="POST">
                                <x-button type="submit">View Transaction History</x-button>
                            </form>


                            <form action="{{ route('accounts.confirm-delete', $selectedAccount) }}" method="GET">
                                @csrf
                                <x-button class="bg-red-700 hover:bg-red-500" type="submit">Delete Account</x-button>
                            </form>
                        </div>
                    @endif
                </div>

</x-app-layout>
