<x-app-layout>
                <h1 class="flex justify-center mt-8 text-2xl font-medium text-gray-900">
                    Create an investment wallet!
                </h1>
                <div class="p-4 mb-9 lg:p-4 bg-customWhite flex justify-center">
                    <form method="POST" action="{{ route('crypto.store') }}" class="flex items-center mt-4">
                        @csrf
                        <div>
                            <x-label for="name">Wallet Name</x-label>
                            <x-input class="block mt-1" type="text" name="name" id="name" placeholder="Name your account" required autofocus autocomplete="account" />
                        </div>

                        <div class="ml-4">
                            <x-button type="submit" class="mt-3 h-10">Create Wallet</x-button>
                        </div>
                    </form>
                </div>

</x-app-layout>
