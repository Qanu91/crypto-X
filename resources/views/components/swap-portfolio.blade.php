<div class="row g-4 mt-1">

    <!-- SWAP PANEL -->
    <div class="col-lg-5">

        <div class="swap-card">
            <form action="{{ route('swap.store') }}" method="POST">
    @csrf

            <div class="section-header">
                <h4>Quick Swap</h4>
                <p>Exchange crypto instantly</p>
            </div>

            <!-- FROM -->
            <div class="swap-box">

                <div class="swap-label">
                    From
                </div>

                <div class="swap-flex">

                    <select name="from_currency" id="from_currency" class="form-select">

    @foreach($wallets as $wallet)
        <option value="{{ $wallet->currency }}"
    {{ old('from_currency') == $wallet->currency ? 'selected' : '' }}>
    {{ $wallet->currency }}
</option>
    @endforeach

</select>
                   <input
    type="number"
    step="0.00000001"
    name="amount"
    id="from_amount"
    value="{{ old('amount', '0.245') }}"
    >

                </div>

            </div>

            <!-- SWAP ICON -->
            <div class="swap-center">

                <div class="swap-icon">
                    <i class="ti ti-arrows-exchange"></i>
                </div>

            </div>

            <!-- TO -->
            <div class="swap-box">

                <div class="swap-label">
                    To
                </div>

                <div class="swap-flex">

                  <select name="to_currency" id="to_currency" class="form-select">

    @foreach($wallets as $wallet)
       <option value="{{ $wallet->currency }}"
    {{ old('to_currency') == $wallet->currency ? 'selected' : '' }}>
    {{ $wallet->currency }}
</option>
    @endforeach

</select>

                    <input
    type="number"
    step="0.00000001"
    name="amount"
    id="to_amount"
    readonly
    value="0">

                </div>

            </div>

            <!-- RATE -->
            <div class="swap-rate" id="swap_rate">

                1 BTC = 218,042 TRX

            </div>

            <!-- BUTTON -->
            <button type="submit" class="swap-btn">
                Swap Now
            </button>
</form>

        </div>

    </div>

    <!-- PORTFOLIO -->
    <div class="col-lg-7">

        <div class="portfolio-card">

            <div class="section-header">

                <div>
                    <h4>Portfolio Overview</h4>
                    <p>Your asset distribution</p>
                </div>

                <button class="portfolio-btn">
                    Analytics
                </button>

            </div>

            <!-- CHART -->
            <div class="portfolio-chart">

                <div class="chart-circle">

                    <div class="chart-inner">
                        72%
                    </div>

                </div>

            </div>

            <!-- ASSETS -->
            <div class="portfolio-assets">

    @foreach($portfolioWallets as $wallet)

        <div class="asset-row">

            <div class="asset-left">

                <div class="asset-dot"></div>

                {{ $wallet->currency }}

            </div>

            <div class="asset-percent">
                {{ number_format($wallet->balance, 2) }}
            </div>

        </div>

    @endforeach

</div>
        </div>

    </div>

</div>

<script>

const rates = @json($swapRates);

function updateSwap() {

    const fromCurrency =
        document.getElementById('from_currency').value;

    const toCurrency =
        document.getElementById('to_currency').value;

    const amount =
        parseFloat(document.getElementById('from_amount').value) || 0;

    const rateBox =
        document.getElementById('swap_rate');

    const toAmount =
        document.getElementById('to_amount');
        if (fromCurrency === toCurrency) {

    document.getElementById('to_amount').value = '';

    document.getElementById('swap_rate').innerHTML =
        'Choose different currencies';

    return;
}

    if (fromCurrency === toCurrency) {

        toAmount.value = amount;

        rateBox.innerHTML =
            `1 ${fromCurrency} = 1 ${toCurrency}`;

        return;
    }

    const rate =
        rates[fromCurrency]?.[toCurrency] || 1;

    toAmount.value =
        (amount * rate).toFixed(2);

    rateBox.innerHTML =
        `1 ${fromCurrency} = ${rate} ${toCurrency}`;
}

document.getElementById('from_amount')
    .addEventListener('input', updateSwap);

document.getElementById('from_currency')
    .addEventListener('change', updateSwap);

document.getElementById('to_currency')
    .addEventListener('change', updateSwap);

updateSwap();

</script>