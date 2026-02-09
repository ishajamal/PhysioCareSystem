<?php

namespace App\Http\Controllers\admin\GenerateReport;

use App\Http\Controllers\Controller;
use App\Models\itemUsage;
use App\Models\ReportLog;
use App\Models\usageRecord;
use App\Models\maintenanceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Added for clarity

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $perPage = (int) $request->get('perPage', 10);
        if (! in_array($perPage, [10,25,50,100])) {
            $perPage = 10;
        }

        // ReportLog uses the standard 'user' relationship
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
            $reportLog = ReportLog::create([
                'reportType' => ucfirst($validated['reportType']),
                // FIX: Use auth()->id() to get current logged in user ID.
                // Do NOT use 'usedByUser' here; that is only for the UsageRecord model.
                'generatedBy' => Auth::id(), 
                'generatedAt' => now(),
                'dateStart' => $validated['dateStart'] ?? null,
                'dateEnd' => $validated['dateEnd'] ?? null,
            ]);

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
        
        if (strtolower($report->reportType) === 'usage') {
            // REVERTED to usageRecord. 
            // This fixes the "Unknown column 'usageDate'" error natively.
            // This also fixes the "foreach" error if your view expects a list of records.
            $query = \App\Models\usageRecord::with('usedByUser', 'itemUsages.itemMaintenanceInfo');
            
            if ($report->dateStart) {
                $query->whereDate('usageDate', '>=', $report->dateStart);
            }
            if ($report->dateEnd) {
                $query->whereDate('usageDate', '<=', $report->dateEnd);
            }
            
            $reportData = $query->get();
        } 
        elseif (strtolower($report->reportType) === 'maintenance') {
            $query = maintenanceRequest::with('submitter', 'itemMaintenances.itemInfo');
            
            if ($report->dateStart) {
                $query->whereDate('dateSubmitted', '>=', $report->dateStart);
            }
            if ($report->dateEnd) {
                $query->whereDate('dateSubmitted', '<=', $report->dateEnd);
            }
            
            $reportData = $query->get();
        }
        //dd($reportData->first()->itemUsages->first()->itemMaintenanceInfo);
        return view('admin.GenerateReport.reportDetails', compact('report', 'reportData', 'reportColumns'));
    }

    public function download($id)
    {
        $report = ReportLog::findOrFail($id);

        return response()->json([
            'message' => 'Download feature to be implemented',
            'reportID' => $report->reportID,
            'reportType' => $report->reportType,
        ]);
    }

    public function printable($id)
    {
        $report = ReportLog::with('user')->findOrFail($id);

        $reportData = [];
        $reportColumns = session('report_columns_' . $id, []);

        if (strtolower($report->reportType) === 'usage') {
            // FIX: Using 'usedByUser' here as well
            $query = usageRecord::with('usedByUser', 'itemUsages.item');

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