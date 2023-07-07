<x-app-layout>
    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-customWhite overflow-hidden shadow-xl sm:rounded-lg p-8 px-40">
                <h2 class="text-2xl font-bold mb-4 text-center">Transfer Funds</h2>
                @if (session('message'))
                    <div class="{{ session('message')['type'] }} text-xl">
                        {{ session('message')['text'] }}
                    </div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li class="text-red-700">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('accounts.transfer') }}" method="POST" class="mx-auto max-w-md">
                    @csrf
                    <div class="mb-4">
                        <label for="sender_account" class="mb-1">Sender Account:</label>
                        <select class="rounded-md shadow-sm w-full" name="sender_account_number" id="sender_account">
                            <option value="">Select an account</option>
                            @foreach ($userAccounts as $account)
                                <option value="{{ $account->account_number }}">
                                  {{$account->name}}  {{ $account->account_number }} {{$account->balance}} {{$account->currency}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="receiver_account" class="mb-1">Receiver Account:</label>
                        <input class="rounded-md shadow-sm w-full" type="text" name="receiver_account_number" id="receiver_account" value="{{ old('receiver_account_number') }}">
                    </div>
                    <div class="mb-4">
                        <label for="name" class="mb-1">Receiver name:</label>
                        <input class="rounded-md shadow-sm w-full" type="text" name="name" id="name" value="{{ old('name') }}">
                    </div>
                    <div class="mb-4">
                        <label for="amount" class="mb-1">Amount:</label>
                        <input class="rounded-md shadow-sm w-full" type="number" step=".01" name="amount" id="amount" value="{{ old('amount') }}">
                    </div>
                    <div class="mb-4">
                        <label for="description" class="mb-1">Description:</label>
                        <input class="rounded-md shadow-sm w-full" type="text" name="description" id="description" value="{{ old('description') }}">
                    </div>
                    <div class="mb-4">
                        <label for="security_code" class="mb-1">Security Code:</label>
                        <input class="rounded-md shadow-sm w-full" type="text" name="security_code" id="security_code" value="{{ old('security_code') }}">
                    </div>
                    <div class="flex justify-center">
                        <x-button type="submit">Transfer</x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="flex flex-col justify-center items-center mt-4">
        @unless ($user->otp_secret_verified)
            <div class="group">
                <span class="font-bold text-gray-700">Don't have a security code?</span>
                <div class="hidden group-hover:block bg-white w-auto mt-4 p-4 rounded-md shadow-md">
                    <div class="mb-2">
                        <p class="mb-2">Scan this QR code in an authenticator app:</p>
                        <img src="data:image/svg+xml;charset=utf-8,{{ rawurlencode($qrCode) }}" alt="QR Code">
                        <p class="text-red-700 mt-2">! QR code will disappear once verified !</p>
                    </div>
                    <form action="{{ route('verifySecurityKey') }}" method="POST">
                        @csrf
                        <div class="mb-2">
                            <label for="otp_secret" class="mb-1">Verify security key:</label>
                            <input type="text" name="otp_secret" id="otp_secret" class="rounded-md shadow-sm w-full">
                        </div>
                        <div class="flex justify-center">
                            <x-button type="submit">Verify</x-button>
                        </div>
                    </form>
                </div>
            </div>
        @endunless
    </div>
</x-app-layout>
