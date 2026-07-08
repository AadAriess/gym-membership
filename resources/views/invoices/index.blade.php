@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Sistem Tagihan & Invoice</h3>
        @can('access-admin')
            <form action="{{ route('billing.trigger-generate') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-dark">Run Billing Engine (Generate)</button>
            </form>
        @endcan
    </div>

    <div class="d-flex gap-2 mb-2">
        @can('access-admin')
            <form action="{{ route('billing.mass-suspend') }}" method="POST"
                onsubmit="return confirm('Jalankan suspensi massal untuk semua member menunggak?')">
                @csrf
                <button type="submit" class="btn btn-danger">Jalankan Suspended Massive</button>
            </form>
        @endcan
    </div>

    <div class="card shadow-sm">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>No Invoice</th>
                    <th>Member</th>
                    <th>Periode</th>
                    <th>Harga Paket</th>
                    <th>Tax (11%)</th>
                    <th>Total</th>
                    <th>Status</th>
                    @can('access-admin')
                        <th>Aksi</th>
                    @endcan
                </tr>
            </thead>
            <tbody>
                @foreach ($invoices as $inv)
                    <tr>
                        <td><code>{{ $inv->invoice_number }}</code></td>
                        <td>{{ $inv->member->name }}</td>
                        <td>Bulan {{ $inv->billing_month }} / {{ $inv->billing_year }}</td>
                        <td>Rp {{ number_format($inv->base_price) }}</td>
                        <td>Rp {{ number_format($inv->tax) }}</td>
                        <td><strong>Rp {{ number_format($inv->total_amount) }}</strong></td>
                        <td>
                            <span class="badge {{ $inv->status == 'paid' ? 'bg-success' : 'bg-warning text-dark' }}">
                                {{ $inv->status }}
                            </span>
                        </td>
                        @can('access-admin')
                            <td>
                                @if ($inv->status == 'unpaid')
                                    <form action="{{ route('payments.store', $inv->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success">Bayar Manual</button>
                                    </form>
                                @else
                                    <span class="text-muted">Lunas</span>
                                @endif
                            </td>
                        @endcan
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
