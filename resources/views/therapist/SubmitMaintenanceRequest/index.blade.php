@extends('layouts.therapist')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Maintenance Request</h2>

        <a href="{{ route('therapist.maintenance.create') }}" class="btn btn-primary">
            + Add New Maintenance Request
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form method="GET" action="{{ route('therapist.maintenance.index') }}" class="d-flex gap-2 mb-3">
        <input type="text" name="q" value="{{ $q }}" class="form-control" placeholder="Search by Request ID / Status / Issue">
        <button class="btn btn-outline-primary">Search</button>
    </form>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width:110px;">Req ID</th>
                        <th>Issue (includes Equipment)</th>
                        <th style="width:180px;">Date</th>
                        <th style="width:140px;">Status</th>
                        <th style="width:120px;" class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rows as $r)
                        <tr>
                            <td>#{{ $r->requestID }}</td>
                            <td class="text-truncate" style="max-width: 420px;">
                                {{ $r->itemIssue ?? '-' }}
                            </td>
                            <td>{{ \Carbon\Carbon::parse($r->dateSubmitted)->format('d M Y') }}</td>
                            <td class="text-capitalize">{{ $r->status }}</td>
                            <td class="text-end">
                                <a class="btn btn-sm btn-outline-secondary"
                                   href="{{ route('therapist.maintenance.show', $r->requestID) }}">
                                    View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">No maintenance request history yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $rows->links() }}
    </div>
</div>
@endsection
