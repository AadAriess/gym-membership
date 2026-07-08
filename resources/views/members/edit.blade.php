@extends('layouts.app')

@section('content')
    <div class="card shadow-sm mx-auto" style="max-width: 600px;">
        <div class="card-header bg-dark text-white">
            <h5>Edit Data Member</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('members.update', $member->id) }}" method="POST">
                @csrf @method('PUT')
                <div class="mb-3">
                    <label>Nama Lengkap</label>
                    <input type="text" name="name" class="form-control" value="{{ $member->name }}" required>
                </div>
                <div class="mb-3">
                    <label>No. HP</label>
                    <input type="text" name="phone" class="form-control" value="{{ $member->phone }}" required>
                </div>
                <div class="mb-3">
                    <label>Alamat</label>
                    <textarea name="address" class="form-control" required>{{ $member->address }}</textarea>
                </div>
                <div class="mb-3">
                    <label>Pilih Paket</label>
                    <select name="membership_id" class="form-select" required>
                        @foreach ($memberships as $m)
                            <option value="{{ $m->id }}" {{ $member->membership_id == $m->id ? 'selected' : '' }}>
                                {{ $m->name }} - Rp {{ number_format($m->monthly_price) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label>Status</label>
                    <select name="status" class="form-select" required>
                        <option value="active" {{ $member->status == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="suspended" {{ $member->status == 'suspended' ? 'selected' : '' }}>Suspended</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label>Tanggal Join</label>
                    <input type="date" name="join_date" class="form-control" value="{{ $member->join_date }}" required>
                </div>
                <button type="submit" class="btn btn-warning w-100">Perbarui Data</button>
            </form>
        </div>
    </div>
@endsection
