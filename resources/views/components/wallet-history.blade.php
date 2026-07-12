<div class="row mt-4">

    <div class="col-12">

        <div class="card">

            <div class="card-header d-flex justify-content-between align-items-center">

                <h4 class="mb-0">
                    My Wallets
                </h4>

            </div>

            <div class="card-body p-0">
            
            <div class="table-responsive">
                <table class="table mb-0">

                    <thead>

                        <tr>

                            <th>Currency</th>

                            <th>Balance</th>

                            <th>Action</th>

                        </tr>

                    </thead>

                    <tbody>

                        <tr>

                            <td>USDT</td>

                            <td>${{ number_format($usdtWallet->balance ?? 0, 2) }}</td>

                            <td>

                                <div class="wallet-actions">
        <a href="{{ route('deposit.index') }}" class="btn btn-success btn-sm">
            Deposit
        </a>

        <a href="{{ route('withdrawal.index') }}" class="btn btn-danger btn-sm">
            Withdraw
        </a>

                            </td>

                        </tr>

                        <tr>

                            <td>TRX</td>

                            <td>{{ number_format($trxWallet->balance ?? 0, 8) }} TRX</td>

                            <td>

                               <div class="wallet-actions">
        <a href="{{ route('deposit.index') }}" class="btn btn-success btn-sm">
            Deposit
        </a>

        <a href="{{ route('withdrawal.index') }}" class="btn btn-danger btn-sm">
            Withdraw
        </a>

                            </td>

                        </tr>

                        <tr>

                            <td>PKR</td>

                            <td>₨ {{ number_format($pkrWallet->balance ?? 0, 2) }}</td>

                            <td>

                                <div class="wallet-actions">
        <a href="{{ route('deposit.index') }}" class="btn btn-success btn-sm">
            Deposit
        </a>

        <a href="{{ route('withdrawal.index') }}" class="btn btn-danger btn-sm">
            Withdraw
        </a>

                            </td>

                        </tr>

                    </tbody>

                </table>
              </div>

            </div>

        </div>

    </div>

</div>