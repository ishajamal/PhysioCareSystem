@extends('layouts.therapist')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">Maintenance Request Details</h2>
        <a href="{{ route('therapist.maintenance.index') }}" class="text-decoration-none">&larr; Back</a>
    </div>

    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <div><b>Request ID:</b> #{{ $req->requestID }}</div>
            <div><b>Date:</b> {{ \Carbon\Carbon::parse($req->dateSubmitted)->format('d M Y, h:i A') }}</div>
            <div><b>Status:</b> <span class="text-capitalize">{{ $req->status }}</span></div>
        </div>
    </div>

    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <h5 class="mb-3">Issue & Details</h5>
            <div class="mb-2"><b>Issue:</b> {{ $details->itemIssue ?? '-' }}</div>
            <div style="white-space: pre-line;"><b>Details:</b> {{ $details->detailsMaintenance ?? '-' }}</div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="mb-3">Evidence Images</h5>

            @if($images->count() === 0)
                <div class="text-muted">No images uploaded.</div>
            @else
                <div class="row g-3">
                    @foreach($images as $img)
                        <div class="col-md-3">
                            <img src="{{ asset($img->imagePath) }}" class="img-fluid rounded border" alt="Evidence">
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection