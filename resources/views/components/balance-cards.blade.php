<div class="row g-4">

    <!-- USDT CARD -->
    <div class="col-lg-6">

        <div class="balance-card usd">

            <div class="bc-icon usd">
                <i class="ti ti-currency-dollar"></i>
            </div>

            <div class="bc-label">
                USDT Balance
            </div>

            <div class="bc-amount">
                ${{ number_format($usdtWallet->balance ?? 0, 2) }}
            </div>

            <span class="bc-change up">
                <i class="ti ti-trending-up"></i>
                +2.4%
            </span>

        </div>

    </div>

    <!-- TRX CARD -->
    <div class="col-lg-6">

        <div class="balance-card trx">

            <div class="bc-icon trx">
                <i class="ti ti-currency-ethereum"></i>
            </div>

            <div class="bc-label">
                TRX Balance
            </div>

            <div class="bc-amount">
                {{ number_format($trxWallet->balance ?? 0) }} TRX
            </div>

            <span class="bc-change up">
                <i class="ti ti-trending-up"></i>
                +5.1%
            </span>

        </div>

    </div>

</div>
