@extends('admin.layout')

@section('title', 'Contact Message - Admin')
@section('page-title', 'Contact Message')

@section('content')
<div class="container-fluid">
    <div class="mb-3">
        <a href="{{ route('admin.contact-messages.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Back to list
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Message</h5>
                    @if($contactMessage->read_at)
                        <span class="badge bg-success">Read {{ $contactMessage->read_at->format('M d, Y H:i') }}</span>
                    @else
                        <span class="badge bg-warning">Unread</span>
                    @endif
                </div>
                <div class="card-body">
                    <p class="text-muted small mb-2">Received {{ $contactMessage->created_at->format('F d, Y \a\t H:i') }}</p>
                    <h6 class="border-bottom pb-2 mb-3">{{ $contactMessage->subject }}</h6>
                    <div class="message-body" style="white-space: pre-wrap;">{{ $contactMessage->message }}</div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Sender</h5>
                </div>
                <div class="card-body">
                    <p class="mb-2"><strong>Name:</strong> {{ $contactMessage->name }}</p>
                    <p class="mb-2"><strong>Email:</strong> <a href="mailto:{{ $contactMessage->email }}">{{ $contactMessage->email }}</a></p>
                    <p class="mb-0 small text-muted"><strong>IP:</strong> {{ $contactMessage->ip ?? 'N/A' }}</p>
                    @if($contactMessage->user_agent)
                        <p class="mb-0 small text-muted mt-1" title="{{ $contactMessage->user_agent }}"><strong>User agent:</strong> {{ Str::limit($contactMessage->user_agent, 50) }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
