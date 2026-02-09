@extends('layouts.therapist')

@section('content')
<div class="container">
    <a href="{{ route('therapist.items.index') }}" class="text-decoration-none">&larr; Back to Item List</a>

    <div class="card shadow-sm mt-3">
        <div class="card-body">
            <h3 class="mb-1">{{ $item->itemName }}</h3>
            <div class="text-muted mb-3">Item ID: {{ $item->itemID }}</div>

            <div class="row">
                <div class="col-md-7">
                    <p><b>Category:</b> {{ $item->category }}</p>
                    <p><b>Status:</b> {{ $item->status }}</p>
                    <p><b>Condition:</b> {{ $item->condition }}</p>
                    <p><b>Quantity:</b> {{ $item->quantity }}</p>
                    <p><b>Stock Level:</b> {{ $item->stockLevel }}</p>

                    <p class="mb-0"><b>Description:</b></p>
                    <p class="text-muted">{{ $item->description }}</p>
                </div>

                <div class="col-md-5">
                    <p class="mb-2"><b>Images</b></p>

                    @if($item->images && $item->images->count())
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($item->images as $img)
                                <img src="{{ asset($img->imagePath) }}" alt="Item image" style="width:120px;height:120px;object-fit:cover;border-radius:8px;">
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">No image uploaded.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
