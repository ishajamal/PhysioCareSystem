@extends('layouts.therapist')

@section('content')
<style>
@import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap");

.mr-page {
    max-width: 1100px;
    margin: 0 auto;
    padding: 40px 20px;
    font-family: 'Inter', sans-serif;
}

.mr-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 16px;
    flex-wrap: wrap;
    margin-bottom: 18px;
}

.mr-title {
    font-size: 28px;
    font-weight: 800;
    color: #111827;
    margin: 0;
    letter-spacing: -0.5px;
}

.back-btn {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 10px 18px;
    border-radius: 999px;
    border: 1px solid #e5e7eb;
    background: #f9fafb;
    color: #1f2937;
    text-decoration: none;
    font-weight: 600;
    font-size: 13px;
    transition: all 0.25s ease;
}
.back-btn:hover {
    background: #ffffff;
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37,99,235,0.12), 0 8px 20px rgba(0,0,0,0.05);
    transform: translateY(-1px);
}

/* Card */
.mr-card {
    background: #ffffff;
    border-radius: 18px;
    padding: 22px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08), 0 1px 4px rgba(0,0,0,0.04);
    margin-bottom: 16px;
}

/* Sections */
.section-title {
    font-size: 12px;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.6px;
    font-weight: 800;
    margin-bottom: 12px;
}

.meta-grid {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap: 12px;
}

@media (max-width: 900px) {
    .meta-grid { grid-template-columns: 1fr; }
}

.meta-item {
    background: #f9fafb;
    border: 1px solid #f1f5f9;
    border-radius: 14px;
    padding: 14px 16px;
}

.meta-label {
    font-size: 12px;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.6px;
    font-weight: 800;
    margin-bottom: 6px;
}

.meta-value {
    font-size: 14px;
    color: #111827;
    font-weight: 700;
}

/* Evidence images */
.image-grid {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 12px;
}

@media (max-width: 1000px) { .image-grid { grid-template-columns: repeat(3, 1fr); } }
@media (max-width: 700px) { .image-grid { grid-template-columns: repeat(2, 1fr); } }

.image-grid a {
    display: block;
    border-radius: 12px;
    overflow: hidden;
    border: 1px solid #eef2ff;
    background: #f9fafb;
    transition: all 0.2s ease;
}
.image-grid a:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.08);
}
.image-grid img {
    width: 100%;
    height: 160px;
    object-fit: cover;
    display: block;
}

.no-image {
    color: #6b7280;
    font-style: italic;
    font-size: 14px;
    padding: 6px 0 0;
}
</style>

<div class="mr-page">

    <div class="mr-header">
        <h1 class="mr-title">Maintenance Request Details</h1>
        <a href="{{ route('therapist.maintenance.index') }}" class="back-btn">
            <span style="font-size:16px; line-height:0;">&larr;</span> Back
        </a>
    </div>

    <!-- META CARD -->
    <div class="mr-card">
        <div class="section-title">Request Info</div>

        <div class="meta-grid">
            <div class="meta-item">
                <div class="meta-label">Request ID</div>
                <div class="meta-value">#{{ $req->requestID }}</div>
            </div>

            <div class="meta-item">
                <div class="meta-label">Date</div>
                <div class="meta-value">
                    {{ \Carbon\Carbon::parse($req->dateSubmitted)->format('d M Y, h:i A') }}
                </div>
            </div>

            <div class="meta-item">
                <div class="meta-label">Status</div>
                <div class="meta-value" style="text-transform: capitalize;">
                    {{ $req->status }}
                </div>
            </div>
        </div>
    </div>

    <!-- ISSUE CARD -->
    <div class="mr-card">
        <div class="section-title">Issue & Details</div>

        <div style="margin-bottom:10px;">
            <div class="meta-label" style="margin-bottom:6px;">Issue</div>
            <div class="meta-value" style="font-weight:600;">
                {{ $details->itemIssue ?? '-' }}
            </div>
        </div>

        <div>
            <div class="meta-label" style="margin-bottom:6px;">Details</div>
            <div style="white-space: pre-line; color:#374151; font-size:14px; line-height:1.6;">
                {{ $details->detailsMaintenance ?? '-' }}
            </div>
        </div>
    </div>

    <!-- EVIDENCE CARD -->
    <div class="mr-card">
        <div class="section-title">Evidence Images</div>

        @if($images->count() === 0)
            <div class="no-image">No images uploaded.</div>
        @else
            <div class="image-grid">
                @foreach($images as $img)
                    <a href="{{ asset($img->imagePath) }}" target="_blank" rel="noopener">
                        <img src="{{ asset($img->imagePath) }}" alt="Evidence">
                    </a>
                @endforeach
            </div>
        @endif
    </div>

</div>
@endsection