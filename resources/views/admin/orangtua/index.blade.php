@extends('admin.layouts.app')

@section('title', 'Data Orangtua')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Data Orangtua</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Data Orangtua</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Data Orangtua
            <a href="{{ route('admin.orangtua.create') }}" class="btn btn-primary btn-sm float-end">Tambah Orangtua</a>
        </div>
        <div class="card-body">
            <table id="datatablesSimple" class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Orangtua</th>
                        <th>Hubungan</th>
                        <th>Siswa</th>
                        <th>Pekerjaan</th>
                        <th>No Telp</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orangtua as $index => $o)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $o->nama_orangtua }}</td>
                        <td>{{ ucfirst($o->hubungan) }}</td>
                        <td>{{ $o->siswa->nama_siswa ?? '-' }}</td>
                        <td>{{ $o->pekerjaan }}</td>
                        <td>{{ $o->no_telp }}</td>
                        <td>
                            <a href="{{ route('admin.orangtua.edit', $o->orangtua_id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('admin.orangtua.destroy', $o->orangtua_id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection