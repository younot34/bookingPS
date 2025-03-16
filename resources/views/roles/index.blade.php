@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Daftar Role</h2>
    <a href="{{ route('roles.create') }}" class="btn btn-primary">Tambah Role</a>

    @if(session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
    @endif

    <table class="table mt-3">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Role</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($roles as $role)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $role->name }}</td>
                <td>
                    <a href="{{ route('roles.edit', $role) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('roles.destroy', $role) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
