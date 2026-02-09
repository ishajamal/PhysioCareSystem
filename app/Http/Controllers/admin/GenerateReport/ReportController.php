<?php

namespace App\Http\Controllers\admin\GenerateReport;

use App\Http\Controllers\Controller;
use App\Models\ReportLog;
use App\Models\usageRecord;
use App\Models\maintenanceRequest;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $perPage = (int) $request->get('perPage', 10);
        if (! in_array($perPage, [10,25,50,100])) {
            $perPage = 10;
        }

        $items = ReportLog::with('user')
            ->orderBy('generatedAt', 'desc')
            ->paginate($perPage)
            ->appends($request->query());

        return view('admin.GenerateReport.reportDashboard', compact('items'));
    }

    public function create()
    {
        return view('admin.GenerateReport.reportCreate');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'reportType' => 'required|in:usage,maintenance',
            'dateStart' => 'nullable|date',
            'dateEnd' => 'nullable|date',
            'usage_columns' => 'nullable|array',
            'maintenance_columns' => 'nullable|array',
        ]);

        try {
            // Create report log entry
            $reportLog = ReportLog::create([
                'reportType' => ucfirst($validated['reportType']),
                'generatedBy' => auth()->user()->userID ?? auth()->user()->id,
                'generatedAt' => now(),
                'dateStart' => $validated['dateStart'] ?? null,
                'dateEnd' => $validated['dateEnd'] ?? null,
            ]);

            // Store selected columns in session for later use
            session([
                'report_columns_' . $reportLog->reportID => [
                    'type' => $validated['reportType'],
                    'usage_columns' => $validated['usage_columns'] ?? [],
                    'maintenance_columns' => $validated['maintenance_columns'] ?? [],
                ]
            ]);

            return redirect()->route('admin.reports.show', $reportLog->reportID)
                ->with('success', 'Report generated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error generating report: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $report = ReportLog::with('user')->findOrFail($id);
        
        $reportData = [];
        $reportColumns = session('report_columns_' . $id, []);
        
        // Fetch data based on report type
        if (strtolower($report->reportType) === 'usage') {
            // Fetch usage records with related data
            $query = usageRecord::with('user', 'itemUsages.item');
            
            // Filter by date range if available
            if ($report->dateStart) {
                $query->whereDate('usageDate', '>=', $report->dateStart);
            }
            if ($report->dateEnd) {
                $query->whereDate('usageDate', '<=', $report->dateEnd);
            }
            
            $reportData = $query->get();
        } 
        elseif (strtolower($report->reportType) === 'maintenance') {
            // Fetch maintenance requests with related data
            $query = maintenanceRequest::with('submitter', 'itemMaintenances.itemInfo');
            // 
            // Filter by date range if available
            if ($report->dateStart) {
                $query->whereDate('dateSubmitted', '>=', $report->dateStart);
            }
            if ($report->dateEnd) {
                $query->whereDate('dateSubmitted', '<=', $report->dateEnd);
            }
            
            $reportData = $query->get();
        }
        
        return view('admin.GenerateReport.reportDetails', compact('report', 'reportData', 'reportColumns'));
    }

    public function download($id)
    {
        $report = ReportLog::findOrFail($id);

        // TODO: Implement actual report generation based on reportType
        // For now, return a placeholder response
        // You can generate PDF, Excel, or JSON based on reportType

        return response()->json([
            'message' => 'Download feature to be implemented',
            'reportID' => $report->reportID,
            'reportType' => $report->reportType,
        ]);
    }

    // Return printable HTML fragment for a report (used by AJAX print from dashboard)
    public function printable($id)
    {
        $report = ReportLog::with('user')->findOrFail($id);

        $reportData = [];
        $reportColumns = session('report_columns_' . $id, []);

        if (strtolower($report->reportType) === 'usage') {
            $query = usageRecord::with('user', 'itemUsages.item');
            if ($report->dateStart) {
                $query->whereDate('usageDate', '>=', $report->dateStart);
            }
            if ($report->dateEnd) {
                $query->whereDate('usageDate', '<=', $report->dateEnd);
            }
            $reportData = $query->get();
        } elseif (strtolower($report->reportType) === 'maintenance') {
            $query = maintenanceRequest::with('submitter', 'itemMaintenances.itemInfo');
            if ($report->dateStart) {
                $query->whereDate('dateSubmitted', '>=', $report->dateStart);
            }
            if ($report->dateEnd) {
                $query->whereDate('dateSubmitted', '<=', $report->dateEnd);
            }
            $reportData = $query->get();
        }

        return view('admin.GenerateReport.printable_template_fragment', compact('report', 'reportData', 'reportColumns'));
    }
}


