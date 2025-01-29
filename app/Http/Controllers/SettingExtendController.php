<?php

namespace App\Http\Controllers;

use App\Models\SettingExtend;
use Illuminate\Http\Request;

class SettingExtendController extends Controller
{
    public static $menu_label = "settings.settings";
    public static $menu_icon = 'bi bi-gear';
    public static $base_route = 'settingextends';

    public static $actions = [
        [
            'label' => 'settings.index',
            'icon' => 'bi bi-gear',
            'route' => 'settingextends.index',
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

        $records = SettingExtend::where('id', 'search')
            ->orWhere('key', 'like', '%' . $search . '%')
            ->orWhere('value', 'like', '%' . $search . '%')->paginate();

        return view('settingextends.index', [
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
        return view('settingextends.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'key' => 'required|string|max:255|unique:settings,key',
            'value' => 'required|string',
        ]);
        
        //dd($validated['value']);
        try {
            // ذخیره در دیتابیس
            $encodedValue = htmlspecialchars($validated['value'], ENT_QUOTES, 'UTF-8');

            SettingExtend::create([
                'key' => $validated['key'],
                'type' => 'wysiwyg',
                'value' => json_encode(['content' => $validated['value']]),//$validated['value'],
            ]);

            // بازگشت به صفحه index با پیام موفقیت
            return redirect()->route('settingextends.index')->with('success', 'Setting created successfully.');
        } catch (\Exception $e) {
            //dd($e->getMessage());
            // بازگشت به صفحه قبلی با پیام خطا
            return redirect()->back()->with('error', 'Failed to create setting. Please try again.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(SettingExtend $settingsExtend)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SettingsExtend $settingsExtend)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SettingsExtend $settingsExtend)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SettingsExtend $settingsExtend)
    {
        //
    }
}
