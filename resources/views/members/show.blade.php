@extends('layouts.app')

@section('content')
    <div class="mb-3">
        <a href="{{ route('members.index') }}" class="btn btn-secondary btn-sm">&larr; Kembali ke Daftar Member</a>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-dark text-white">
                    <h5 class="card-title mb-0">Profil Member</h5>
                </div>
                <div class="card-body">
                    <h3>{{ $member->name }}</h3>
                    <p class="text-muted mb-3">ID Member: #{{ str_pad($member->id, 5, '0', STR_PAD_LEFT) }}</p>

                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span>Status:</span>
                            <span
                                class="badge {{ $member->status == 'active' ? 'bg-success' : 'bg-danger' }}">{{ strtoupper($member->status) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span>Paket:</span>
                            <strong>{{ $member->membership->name }}</strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span>No. HP:</span>
                            {{ $member->phone }}
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span>Tanggal Join:</span>
                            {{ \Carbon\Carbon::parse($member->join_date)->format('d M Y') }}
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card bg-light shadow-sm text-center p-3 mb-4">
                <div class="row">
                    <div class="col-6 border-end">
                        <h6 class="text-muted">Total Durasi Lunas</h6>
                        <span class="fs-4 fw-bold text-success">{{ $monthsPaid }} Bulan</span>
                    </div>
                    <div class="col-6">
                        <h6 class="text-muted">Total Kontribusi</h6>
                        <span class="fs-4 fw-bold text-dark">Rp {{ number_format($totalPaidAmount) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white font-weight-bold">
                    <h5 class="mb-0">Riwayat Billing & Pembayaran</h5>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>No. Invoice</th>
                                <th>Periode</th>
                                <th>Tenggat (Due)</th>
                                <th>Total Tagihan</th>
                                <th>Status</th>
                                <th>Tgl Bayar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($member->invoices as $invoice)
                                <tr>
                                    <td><code>{{ $invoice->invoice_number }}</code></td>
                                    <td>Bulan {{ $invoice->billing_month }} / {{ $invoice->billing_year }}</td>
                                    <td><span
                                            class="text-danger">{{ \Carbon\Carbon::parse($invoice->due_date)->format('d M Y') }}</span>
                                    </td>
                                    <td>Rp {{ number_format($invoice->total_amount) }}</td>
                                    <td>
                                        <span
                                            class="badge {{ $invoice->status == 'paid' ? 'bg-success' : 'bg-warning text-dark' }}">
                                            {{ $invoice->status == 'paid' ? 'Lunas' : 'Belum Bayar' }}
                                        </span>
                                    </td>
                                    <td>
                                        @if ($invoice->status == 'paid' && $invoice->payments->first())
                                            {{ \Carbon\Carbon::parse($invoice->payments->first()->payment_date)->format('d M Y') }}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">Belum ada data tagihan untuk
                                        member ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
