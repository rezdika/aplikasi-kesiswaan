@extends('admin.layouts.app')

@section('title', 'Tahun Ajaran')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Tahun Ajaran</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Tahun Ajaran</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Data Tahun Ajaran
            <a href="{{ route('admin.tahun-ajaran.create') }}" class="btn btn-primary btn-sm float-end">Tambah Tahun Ajaran</a>
        </div>
        <div class="card-body">
            <table id="datatablesSimple" class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tahun Ajaran</th>
                        <th>Semester</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tahunAjaran as $index => $ta)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $ta->tahun_ajaran }}</td>
                        <td>{{ $ta->semester }}</td>
                        <td>
                            @if($ta->status_aktif)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary">Tidak Aktif</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.tahun-ajaran.edit', $ta) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('admin.tahun-ajaran.destroy', $ta) }}" method="POST" class="d-inline">
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