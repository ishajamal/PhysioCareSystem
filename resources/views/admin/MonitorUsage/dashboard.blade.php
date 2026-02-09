@extends('layouts.app')

@section('title', 'Monitor Usage')

@section('content')
<style>
@import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap");

.usage-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 40px 20px;
    min-height: 80vh;
    font-family: 'Inter', sans-serif;
}

.usage-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    flex-wrap: wrap;
    gap: 20px;
}

.usage-title {
    font-size: 34px;
    font-weight: 700;
    color: #1f2937;
    margin: 0;
    letter-spacing: -0.5px;
}

.usage-card {
    background: white;
    border-radius: 18px;
    padding: 40px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    text-align: center;
}

.placeholder-icon {
    font-size: 64px;
    margin-bottom: 20px;
}

.placeholder-text {
    color: #6b7280;
    font-size: 18px;
    margin-bottom: 10px;
}

.placeholder-subtext {
    color: #9ca3af;
    font-size: 14px;
    margin-bottom: 30px;
}

.btn-primary {
    background: #26599F;
    color: white;
    border: none;
    padding: 12px 24px;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
    transition: all 0.2s ease;
}

.btn-primary:hover {
    background: #1a4070;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(38, 89, 159, 0.3);
}
</style>

<div class="usage-container">
    <h1 class="usage-title">Monitor Usage</h1>

    <div class="usage-card">
        <div class="placeholder-icon">📊</div>
        <p class="placeholder-text">Usage Monitoring Dashboard</p>
        <p class="placeholder-subtext">View and track equipment and item usage statistics across your facility.</p>
        <p style="color: #9ca3af; font-style: italic;">This page is under development and will display comprehensive usage metrics soon.</p>
    </div>
</div>
@endsection
