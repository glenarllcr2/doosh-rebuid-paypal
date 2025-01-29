<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends BaseController
{
    public static $menu_label = "settings.settings";
    public static $menu_icon = 'bi bi-gear';
    public static $base_route = 'settings';

    public static $actions = [
        [
            'label' => 'settings.index',
            'icon' => 'bi bi-gear',
            'route' => 'settings.index',
        ],

    ];
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $sortBy = $request->get('sortBy', 'plans.id');
        $sortDirection = $request->get('sortDirection', 'asc');

        $sortableColumns = ['id', 'key', 'value'];

        $columns = [
            'id' => 'ID',
            'key' => 'Key',
            'value' => 'Value',
            //'created_at' => 'Created At',
        ];

        // Check if the column to sort by is valid
        if (!in_array($sortBy, $sortableColumns)) {
            $sortBy = 'id'; // default column
        }

        $records = Setting::where('id', 'search')
            ->orWhere('key', 'like', '%' . $search . '%')
            ->orWhere('value', 'like', '%' . $search . '%')->paginate();

        return view('settings.index', [
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
        return view('settings.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // اعتبارسنجی داده‌ها
        $validated = $request->validate([
            'key' => 'required|string|max:255|unique:settings,key',
            'value' => 'required|string|max:255',
        ]);

        try {
            // ذخیره در دیتابیس
            Setting::create([
                'key' => $validated['key'],
                'value' => $validated['value'],
            ]);

            // بازگشت به صفحه index با پیام موفقیت
            return redirect()->route('settings.index')->with('success', 'Setting created successfully.');
        } catch (\Exception $e) {
            // بازگشت به صفحه قبلی با پیام خطا
            return redirect()->back()->with('error', 'Failed to create setting. Please try again.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Setting $setting)
    {
        return view('settings.edit', compact('setting'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Setting $setting)
    {
        // اعتبارسنجی داده‌های ورودی
        $validated = $request->validate([
            'key' => 'required|string|unique:settings,key,' . $setting->id,
            'value' => 'required|string',
        ]);

        try {
            // به‌روزرسانی داده‌ها
            $setting->update($validated);

            // بازگشت به صفحه index با پیام موفقیت
            return redirect()
                ->route('settings.index')
                ->with('success', 'Setting updated successfully.');
        } catch (\Exception $e) {
            // بازگشت به صفحه قبل با پیام خطا
            return redirect()
                ->back()
                ->withErrors(['error' => 'Failed to update setting: ' . $e->getMessage()])
                ->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Setting $setting)
    {
        //
    }
}
