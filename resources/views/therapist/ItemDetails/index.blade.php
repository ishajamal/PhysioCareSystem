@extends('layouts.therapist')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Item Details</h2>

        <form method="GET" action="{{ route('therapist.items.index') }}" class="d-flex gap-2">
            <input
                type="text"
                name="q"
                value="{{ $q ?? '' }}"
                class="form-control"
                placeholder="Search item name / category / ID"
                style="width: 340px;"
            >
            <button class="btn btn-primary">Search</button>
        </form>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width:80px;">No.</th>
                        <th style="width:110px;">Item ID</th>
                        <th>Item Name</th>
                        <th style="width:180px;">Category</th>
                        <th style="width:110px;">Qty</th>
                        <th style="width:160px;">Stock Level</th>
                        <th style="width:140px;">Status</th>
                        <th style="width:140px;" class="text-end">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($items as $index => $item)
                        <tr>
                            <td>{{ $items->firstItem() + $index }}</td>
                            <td>{{ $item->itemID }}</td>
                            <td class="fw-semibold">{{ $item->itemName }}</td>
                            <td class="text-capitalize">{{ $item->category }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td class="text-capitalize">{{ $item->stockLevel }}</td>
                            <td class="text-capitalize">{{ $item->status }}</td>
                            <td class="text-end">
                                <a href="{{ route('therapist.items.show', $item->itemID) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                No items found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4 d-flex justify-content-center">
        {{ $items->links() }}
    </div>
</div>
@endsection
