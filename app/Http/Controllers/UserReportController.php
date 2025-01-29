<?php

namespace App\Http\Controllers;

use App\Models\UserReport;
use Illuminate\Http\Request;

class UserReportController extends Controller
{
    public static $menu_label = "User Reports";
    public static $menu_icon = 'bi bi-exclamation-triangle';
    public static $base_route = 'user-reports';

    public static $actions = [
        [
            'label' => 'Users Reports',
            'icon' => 'bi bi-exclamation-triangle',
            'route' => 'user-reports.index',
        ],
    ];

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $sortBy = $request->get('sortBy', 'id');
        $sortDirection = $request->get('sortDirection', 'asc');

        $sortableColumns = ['reporter_name', 'target_name', 'report_date', 'review_date', 'status'];

        $columns = [
            'reporter_name' => 'Complainant',
            'target_name' => 'Defendant',
            'created_at' => 'Report Date',
            'review_date' => 'Review Date',
            'report' => 'Report',
            'answer' => 'Answer',
            'status' => 'Status',

        ];

        // Check if the column to sort by is valid
        if (!in_array($sortBy, $sortableColumns)) {
            $sortBy = 'id'; // default column
        }

        $records = UserReport::with(['reporter', 'target'])
            ->search($search)
            ->orWhere('report', 'like', "%{$search}%")
            ->sortBy($sortBy, $sortDirection) // مرتب‌سازی
            ->paginate();

        //dd($records);
        return view('UserReports.index', [
            'records' => $records,
            'sortBy' => $sortBy,
            'columns' => $columns,
            'sortDirection' => $sortDirection,
            'sortableColumns' => $sortableColumns,
            'search' => $search, // ارسال متغیر search به ویو
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'target_id' => 'required|exists:users,id',
                'report' => 'required|string|min:20',
            ]);


            UserReport::create([
                'user_id' => auth()->id(),
                'target_id' => $validated['target_id'],
                'report' => $validated['report'],
                'page_url' => url()->previous(),
                'user_agent' => $request->header('User-Agent'),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'The user has been reported successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while reporting the user.'.$e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(UserReport $userReport)
    {
        return view('UserReports.view', ['report' => $userReport]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserReport $userReport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserReport $userReport)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserReport $userReport)
    {
        //
    }

    public function accept(UserReport $report, Request $request)
    {
        try {
            // بررسی وضعیت فعلی گزارش
            if ($report->status !== 'pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'This report has already been processed.'
                ], 400);
            }

            // به‌روزرسانی وضعیت
            $report->update([
                'status' => 'accepted',
                'answer' => $request->input('answer'),
                'review_date' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Report accepted successfully.'
            ], 200);
        } catch (\Exception $e) {
            // کنترل خطاها
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing the report. Please try again.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function reject(UserReport $report, Request $request)
    {
        try {
            // بررسی وضعیت فعلی گزارش
            if ($report->status !== 'pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'This report has already been processed.'
                ], 400);
            }

            // به‌روزرسانی وضعیت
            $report->update([
                'status' => 'rejected',
                'answer' => $request->input('answer'),
                'review_date' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Report rejected successfully.'
            ], 200);
        } catch (\Exception $e) {
            // کنترل خطاها
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing the report. Please try again.' . $e->getMessage(),
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
