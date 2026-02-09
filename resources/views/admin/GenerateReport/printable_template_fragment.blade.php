<!-- Printable template fragment for reuse -->
<div style="font-family: 'Inter', Arial, sans-serif; padding: 28px; color:#111;">
    <div style="text-align:center; margin-bottom:24px;">
        <img src="{{ asset('images/physiocare-logo.png') }}" alt="PhysioCare" style="height:32px; object-fit:contain; display:block; margin:0 auto; margin-bottom:16px;">
        <div style="font-size:18px; font-weight:700; margin-bottom:20px;">PhysioCare Inventory System</div>
        <div style="margin-bottom:12px; text-align:left; margin-left:0;">Date: <strong>{{ $report->generatedAt->format('Y-m-d') }}</strong></div>
        <div style="text-align:left; margin-left:0; margin-bottom:20px; color:#666;">Report ID: #{{ $report->reportID }}</div>
    </div>

    <div style="margin-top:20px;">
        @if(strtolower($report->reportType) === 'usage')
            <table style="width:100%; border-collapse:collapse; font-size:12px;">
                <thead>
                    <tr>
                        <th style="padding:8px; border-bottom:1px solid #ddd; text-align:left;">No</th>
                        <th style="padding:8px; border-bottom:1px solid #ddd; text-align:left;">Usage ID</th>
                        <th style="padding:8px; border-bottom:1px solid #ddd; text-align:left;">Item ID</th>
                        <th style="padding:8px; border-bottom:1px solid #ddd; text-align:left;">Item Name</th>
                        <th style="padding:8px; border-bottom:1px solid #ddd; text-align:left;">Quantity</th>
                        <th style="padding:8px; border-bottom:1px solid #ddd; text-align:left;">Used By</th>
                        <th style="padding:8px; border-bottom:1px solid #ddd; text-align:left;">Used Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reportData as $record)
                        @foreach($record->itemUsages as $index => $usage)
                            <tr>
                                <td style="padding:8px; vertical-align:top;">{{ $loop->parent->iteration }}.{{ $index + 1 }}</td>
                                <td style="padding:8px; vertical-align:top;">#{{ $record->usageID }}</td>
                                <td style="padding:8px; vertical-align:top;">{{ $usage->item->itemID ?? 'N/A' }}</td>
                                <td style="padding:8px; vertical-align:top;">{{ $usage->item->product_name ?? 'N/A' }}</td>
                                <td style="padding:8px; vertical-align:top;">{{ $usage->quantity ?? 'N/A' }}</td>
                                <td style="padding:8px; vertical-align:top;">{{ $record->user->name ?? 'N/A' }}</td>
                                <td style="padding:8px; vertical-align:top;">{{ $record->usageDate?->format('Y-m-d H:i') ?? 'N/A' }}</td>
                            </tr>
                        @endforeach
                    @empty
                        <tr><td colspan="7" style="padding:18px; text-align:center; color:#666;">No usage data</td></tr>
                    @endforelse
                </tbody>
            </table>
        @elseif(strtolower($report->reportType) === 'maintenance')
            <table style="width:100%; border-collapse:collapse; font-size:12px;">
                <thead>
                    <tr>
                        <th style="padding:8px; border-bottom:1px solid #ddd; text-align:left;">No</th>
                        <th style="padding:8px; border-bottom:1px solid #ddd; text-align:left;">Request ID</th>
                        <th style="padding:8px; border-bottom:1px solid #ddd; text-align:left;">Item ID</th>
                        <th style="padding:8px; border-bottom:1px solid #ddd; text-align:left;">Equipment Name</th>
                        <th style="padding:8px; border-bottom:1px solid #ddd; text-align:left;">Item Issue</th>
                        <th style="padding:8px; border-bottom:1px solid #ddd; text-align:left;">Submitted By</th>
                        <th style="padding:8px; border-bottom:1px solid #ddd; text-align:left;">Status</th>
                        <th style="padding:8px; border-bottom:1px solid #ddd; text-align:left;">Date Submitted</th>
                        <th style="padding:8px; border-bottom:1px solid #ddd; text-align:left;">Details</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reportData as $request)
                        @foreach($request->itemMaintenances as $index => $maintenance)
                            <tr>
                                <td style="padding:8px; vertical-align:top;">{{ $loop->parent->iteration }}.{{ $index + 1 }}</td>
                                <td style="padding:8px; vertical-align:top;">#{{ $request->requestID }}</td>
                                <td style="padding:8px; vertical-align:top;">{{ $maintenance->itemInfo->itemID ?? 'N/A' }}</td>
                                <td style="padding:8px; vertical-align:top;">{{ $maintenance->itemInfo->product_name ?? 'N/A' }}</td>
                                <td style="padding:8px; vertical-align:top;">{{ $maintenance->itemIssue ?? 'N/A' }}</td>
                                <td style="padding:8px; vertical-align:top;">{{ $request->submitter->name ?? 'N/A' }}</td>
                                <td style="padding:8px; vertical-align:top;">{{ ucfirst($request->status) }}</td>
                                <td style="padding:8px; vertical-align:top;">{{ $request->dateSubmitted?->format('Y-m-d H:i') ?? 'N/A' }}</td>
                                <td style="padding:8px; vertical-align:top;">{{ $maintenance->detailsMaintenance ?? 'N/A' }}</td>
                            </tr>
                        @endforeach
                    @empty
                        <tr><td colspan="9" style="padding:18px; text-align:center; color:#666;">No maintenance data</td></tr>
                    @endforelse
                </tbody>
            </table>
        @endif
    </div>

    <div style="margin-top:28px; text-align:right; color:#777; font-size:12px;">
        &copy; {{ date('Y') }} PhysioCare Inventory System
    </div>
</div>
