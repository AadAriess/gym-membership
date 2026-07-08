@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Master Data Member</h3>
        @can('access-admin')
            <a href="{{ route('members.create') }}" class="btn btn-primary">Tambah Member</a>
        @endcan
    </div>

    <div class="card shadow-sm">
        <table class="table table-striped table-hover mb-0">
            <thead class="table-dark">
                <tr>
                    <th>Nama</th>
                    <th>Telepon</th>
                    <th>Paket</th>
                    <th>Tanggal Join</th>
                    <th>Status</th>
                    <th></th>
                    @can('access-admin')
                        <th>Aksi</th>
                    @endcan
                </tr>
            </thead>
            <tbody>
                @foreach ($members as $member)
                    <tr>
                        <td>{{ $member->name }}</td>
                        <td>{{ $member->phone }}</td>
                        <td>{{ $member->membership->name }}</td>
                        <td>{{ $member->join_date }}</td>
                        <td>
                            <span class="badge {{ $member->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                                {{ $member->status }}
                            </span>
                        </td>

                        <td>
                            <a href="{{ route('members.show', $member->id) }}"
                                class="btn btn-sm btn-info text-white">Detail</a>
                            @can('access-admin')
                                <a href="{{ route('members.edit', $member->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('members.destroy', $member->id) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Hapus?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            @endcan
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
