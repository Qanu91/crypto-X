<div class="transactions-wrapper mt-4">

    <div class="transactions-card">

        <div class="transactions-header">

            <div>
                <h4>Recent Transactions</h4>
                <p>Your latest crypto activities</p>
            </div>

            <a href="#">View All</a>

        </div>

        <div class="table-responsive">

            <table class="table transactions-table align-middle">

                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Asset</th>
                        <th>Amount</th>
                        <th>Value</th>
                        <th>Status</th>
                    </tr>
                </thead>

            <tbody>

    @foreach($transactions as $transaction)

        <tr>

            <td>
                <span class="txn-badge {{ strtolower($transaction->type) }}">
                    {{ $transaction->type }}
                </span>
            </td>

            <td>
                {{ $transaction->currency }}
            </td>

            <td>
                {{ number_format($transaction->amount, 2) }}
                {{ $transaction->currency }}
            </td>

            <td>
                {{ number_format($transaction->amount, 2) }}
            </td>

            <td>
                <span class="status {{ $transaction->status == 'Completed' ? 'success-status' : 'pending-status' }}">
                    {{ $transaction->status }}
                </span>
            </td>

        </tr>

    @endforeach

</tbody>

            </table>

        </div>

    </div>

</div>