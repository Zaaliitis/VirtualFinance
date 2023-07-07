<div class="p-6 lg:p-8 bg-customWhite border-b border-gray-200">
    <form action="{{ route('accounts.transfer') }}" method="POST">
        @csrf
        <div>
            <label for="sender_account">Sender Account:</label>
            <select name="sender_account" id="sender_account">
                @foreach ($userAccounts as $account)
                    <option value="{{ $account->id }}">{{ $account->account_number }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="receiver_account">Receiver Account:</label>
            <input type="text" name="receiver_account" id="receiver_account">
        </div>
        <div>
            <label for="amount">Amount:</label>
            <input type="number" name="amount" id="amount">
        </div>
        <div>
            <label for="description">Description:</label>
            <input type="text" name="description" id="description">
        </div>
        <div>
            <button type="submit">Transfer</button>
        </div>
    </form>
</div>

