@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">History Aktivitas</h1>
    
    <div class="card mb-4">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Aksi</th>
                        <th>Model</th>
                        <th>Deskripsi</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($activities as $key => $activity)
                    <tr>
                        <td>{{ $activities->firstItem() + $key }}</td>
                        <td>
                            <span class="badge bg-{{ $activity->action == 'create' ? 'success' : ($activity->action == 'update' ? 'warning' : 'danger') }}">
                                {{ ucfirst($activity->action) }}
                            </span>
                        </td>
                        <td>{{ $activity->model }}</td>
                        <td>{{ $activity->description }}</td>
                        <td>{{ $activity->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Belum ada aktivitas</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            
            {{ $activities->links() }}
        </div>
    </div>
</div>
@endsection