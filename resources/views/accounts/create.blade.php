<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-customWhite overflow-hidden shadow-xl sm:rounded-lg ">
                <h1 class="flex justify-center mt-8 text-2xl font-medium text-gray-900">
                    Create an account!
                </h1>
                <div class="p-4 mb-9 lg:p-4 bg-customWhite flex justify-center">

                    <form method="POST" action="{{ route('accounts.store') }}" class="flex items-center mt-4">
                        @csrf
                        <div>
                            <x-label for="name"></x-label>
                            <x-input class="block mt-1" type="text" name="name" id="name" placeholder="Name your account" required autofocus autocomplete="account" />
                        </div>

                        <div class="ml-4">
                            <label for="currency">Currency:</label>
                            <select class='rounded-md shadow-sm h-10' name="currency" id="currency">
                                <option value="EUR" selected>EUR</option>
                                @foreach ($currencies as $currency)
                                    <option value="{{ $currency }}">{{ $currency }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="ml-4">
                            <x-button type="submit" class="mt-3 h-10">Create an Account</x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
