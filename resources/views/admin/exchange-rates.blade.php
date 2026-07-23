@extends('layouts.admin')

@section('title', 'Exchange Rates')

@section('content')

<div class="row g-4">

    {{-- Set Rate Form --}}
    <div class="col-lg-5">
        <div class="card">
            <div class="card-header py-3 px-4">
                <h4>Set Exchange Rate</h4>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.exchange-rates.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Currency</label>
                        <select name="currency" class="form-select" required>
                            <option value="">Select Currency</option>
                            <option value="USDT">USDT — Tether</option>
                            <option value="TRX">TRX — Tron</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Buy Rate (PKR)</label>
                        <div class="input-group">
                            <span class="input-group-text">₨</span>
                            <input type="number" step="0.00000001" name="buy_rate"
                                   class="form-control" placeholder="e.g. 278.50" required>
                        </div>
                        <div class="form-text">Price admin pays user per unit when buying crypto.</div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Sell Rate (PKR)</label>
                        <div class="input-group">
                            <span class="input-group-text">₨</span>
                            <input type="number" step="0.00000001" name="sell_rate"
                                   class="form-control" placeholder="e.g. 275.00" required>
                        </div>
                        <div class="form-text">Price user pays admin per unit when selling crypto.</div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="ti ti-device-floppy me-1"></i> Save Rate
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Current Rates Table --}}
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header py-3 px-4">
                <h4>Current Rates</h4>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Currency</th>
                            <th>Buy Rate (PKR)</th>
                            <th>Sell Rate (PKR)</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($rates as $rate)
                        <tr>
                            <td>
                                <span class="fw-semibold">{{ $rate->currency }}</span>
                            </td>
                            <td>₨ {{ number_format($rate->buy_rate, 2) }}</td>
                            <td>₨ {{ number_format($rate->sell_rate, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted py-4">No rates set yet.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

@endsection
