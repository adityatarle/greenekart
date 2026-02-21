@extends('admin.layout')

@section('title', 'Contact Messages - Admin')
@section('page-title', 'Contact Messages')

@section('content')
<div class="container-fluid">
    <!-- Stats -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card stat-card border-left-primary h-100">
                <div class="card-body">
                    <div class="stat-number">{{ $stats['total'] }}</div>
                    <div class="stat-label">Total Messages</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <a href="{{ route('admin.contact-messages.index', ['read' => '0']) }}" class="text-decoration-none">
                <div class="card stat-card border-left-warning h-100">
                    <div class="card-body">
                        <div class="stat-number">{{ $stats['unread'] }}</div>
                        <div class="stat-label">Unread</div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('admin.contact-messages.index', ['read' => '1']) }}" class="text-decoration-none">
                <div class="card stat-card border-left-success h-100">
                    <div class="card-body">
                        <div class="stat-number">{{ $stats['read'] }}</div>
                        <div class="stat-label">Read</div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Filters & List -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h5 class="mb-0">Contact form submissions</h5>
            <form action="{{ route('admin.contact-messages.index') }}" method="GET" class="d-flex flex-wrap gap-2 align-items-center">
                <input type="text" name="search" class="form-control form-control-sm" style="width: 180px;" placeholder="Search name, email, subject..." value="{{ request('search') }}">
                <select name="read" class="form-select form-select-sm" style="width: 120px;">
                    <option value="">All</option>
                    <option value="0" {{ request('read') === '0' ? 'selected' : '' }}>Unread</option>
                    <option value="1" {{ request('read') === '1' ? 'selected' : '' }}>Read</option>
                </select>
                <button type="submit" class="btn btn-sm btn-primary">Filter</button>
                @if(request()->hasAny(['search', 'read']))
                    <a href="{{ route('admin.contact-messages.index') }}" class="btn btn-sm btn-outline-secondary">Clear</a>
                @endif
            </form>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>From</th>
                            <th>Subject</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($messages as $msg)
                        <tr class="{{ $msg->read_at ? '' : 'table-active' }}">
                            <td>
                                <strong>{{ $msg->name }}</strong><br>
                                <small class="text-muted">{{ $msg->email }}</small>
                            </td>
                            <td>{{ Str::limit($msg->subject, 40) }}</td>
                            <td>{{ $msg->created_at->format('M d, Y H:i') }}</td>
                            <td>
                                @if($msg->read_at)
                                    <span class="badge bg-success">Read</span>
                                @else
                                    <span class="badge bg-warning">Unread</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.contact-messages.show', $msg) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i> View
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">No contact messages yet.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($messages->hasPages())
        <div class="card-footer">
            {{ $messages->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
