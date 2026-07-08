@extends('layouts.app')

@section('content')
    <div class="card shadow-sm mx-auto" style="max-width: 600px;">
        <div class="card-header bg-dark text-white">
            <h5>Registrasi Member Baru</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('members.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label>Nama Lengkap</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>No. HP</label>
                    <input type="text" name="phone" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Alamat</label>
                    <textarea name="address" class="form-control" required></textarea>
                </div>
                <div class="mb-3">
                    <label>Pilih Paket</label>
                    <select name="membership_id" class="form-select" required>
                        @foreach ($memberships as $m)
                            <option value="{{ $m->id }}">{{ $m->name }} - Rp
                                {{ number_format($m->monthly_price) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label>Tanggal Join</label>
                    <input type="date" name="join_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>
                <button type="submit" class="btn btn-success w-100">Simpan Member</button>
            </form>
        </div>
    </div>
@endsection
