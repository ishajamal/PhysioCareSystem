@extends('layouts.therapist')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Item Details</h2>

        <form method="GET" action="{{ route('therapist.items.index') }}" class="d-flex gap-2">
            <input type="text" name="q" value="{{ $q }}" class="form-control" placeholder="Search item name / category / ID">
            <button class="btn btn-primary">Search</button>
        </form>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row g-4">
        @forelse($items as $item)
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <div class="mb-2">
                            <strong>{{ $item->itemName }}</strong><br>
                            <small class="text-muted">ID: {{ $item->itemID }}</small>
                        </div>

                        <div class="mb-2">
                            <span class="badge bg-secondary">{{ $item->category }}</span>
                            <span class="badge bg-info text-dark">{{ $item->status }}</span>
                        </div>

                        <div class="small mb-3">
                            <div><b>Qty:</b> {{ $item->quantity }}</div>
                            <div><b>Stock Level:</b> {{ $item->stockLevel }}</div>
                        </div>

                        <a href="{{ route('therapist.items.show', $item->itemID) }}" class="btn btn-outline-primary w-100">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <p>No items found.</p>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $items->links() }}
    </div>
</div>
@endsection
