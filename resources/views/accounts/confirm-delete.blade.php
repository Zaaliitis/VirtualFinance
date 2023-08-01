<x-app-layout>
                <div class="p-6 lg:p-8 bg-customWhite border-b border-gray-200">
                    <h1 class="text-2xl font-medium text-gray-900">Confirm Account Deletion</h1>
                    <p class="mt-4">Are you sure you want to delete the account with number: {{ $account->account_number }}?</p>
                    <form action="{{ route('accounts.destroy', $account) }}" method="POST" class="mt-6">
                        @csrf
                        @method('DELETE')
                        <x-button class="bg-red-700 hover:bg-red-500" type="submit">Delete Account</x-button>
                    </form>
                </div>
</x-app-layout>
