@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Notifikasi</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('kesiswaan.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Notifikasi</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-bell me-1"></i>
            Daftar Notifikasi
        </div>
        <div class="card-body">
            @if($notifications->count() > 0)
                @foreach($notifications as $notification)
                    <div class="alert {{ $notification->is_read ? 'alert-light' : 'alert-info' }} notification-item d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
                            <div class="d-flex align-items-center mb-2">
                                <h6 class="alert-heading mb-0 me-2">{{ $notification->title }}</h6>
                                <span class="notification-type-badge type-{{ $notification->type }}">{{ ucfirst($notification->type) }}</span>
                            </div>
                            <p class="mb-1">{{ $notification->message }}</p>
                            <small class="notification-time">{{ $notification->created_at->diffForHumans() }}</small>
                        </div>
                        <div class="ms-3">
                            @if(!$notification->is_read)
                                <form action="{{ route('kesiswaan.notifications.read', $notification->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-sm btn-primary">Baca</button>
                                </form>
                            @else
                                <span class="badge bg-secondary">Dibaca</span>
                            @endif
                        </div>
                    </div>
                @endforeach

                {{ $notifications->links() }}
            @else
                <div class="text-center py-4">
                    <i class="fas fa-bell-slash fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Tidak ada notifikasi</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection