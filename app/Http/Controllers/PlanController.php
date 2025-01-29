<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends BaseController
{
    public static $menu_label = "Plans.index";
    public static $menu_icon = 'bi bi-envelope-fill';
    public static $base_route = 'plans';

    public static $actions = [
        [
            'label' => 'Plans.index',
            'icon' => 'bi bi-envelope-arrow-down-fill',
            'route' => 'plans.index',
        ],
        // [
        //     'label' => 'Compose',
        //     'icon' => 'bi bi-envelope-plus-fill',
        //     'route' => 'internal-messages.create',
        // ],
    ];

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if(!auth()->user()->isAdmin())
            abort(403);
        $search = $request->input('search');
        $sortBy = $request->get('sortBy', 'plans.id'); 
        $sortDirection = $request->get('sortDirection', 'asc');

        $sortableColumns = ['id', 'name', 'description', 'is_active', 'is_recommended', 'duration'];
        $columns = [
            'id' => ['label'=>'ID', 'type'=>'integer'],
            'name' => ['label'=>'Name', 'type' => 'text'],
            'is_active' => ['label'=>'Active', 'type' => 'boolean'],
            'is_recommended' => ['label'=>'Recommended', 'type' => 'boolean'],
            'duration' => ['label'=>'Duration', 'type' => 'integer'],
            'price' => ['label'=>'Price', 'type' => 'integer'],
            'description' => ['label'=>'Description', 'type' => 'text'],
            
        ];
        // Check if the column to sort by is valid
        if (!in_array($sortBy, $sortableColumns)) {
            $sortBy = 'plans.id'; // default column
        }

        $plans = Plan::where('id' , 'search')
            ->orWhere('name', 'like', '%'.$search.'%')
            ->orWhere('description', 'like', '%'.$search.'%')
            ->orderBy($sortBy, $sortDirection)
            ->paginate();
        

        // return view('plans.index', [
        //     'plans' => $plans,
        //     'sortBy' => $sortBy,
        //     'sortDirection' => $sortDirection,
        //     'search' => $search, // ارسال متغیر search به ویو
        // ]);

        return view('plans.index', [
            'records' => $plans,
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
        $fields = [
            ['name'=>'name', 'label' => 'Name', 'type' => 'text'],
            ['name'=>'is_active', 'label' => 'Is Active', 'type' => 'boolean'],
            ['name'=>'is_recommended', 'label' => 'Is Recommanded', 'type' => 'boolean'],
            ['name'=>'duration', 'label' => 'Duration', 'type' => 'integer'],
            ['name'=>'price', 'label' => 'Price', 'type' => 'integer'],
            ['name'=>'description', 'label' => 'Deacription', 'type' => 'text']
        ];
        return view('plans.create', ['fields' => $fields]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        // اعتبارسنجی داده‌ها
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:plans,name',
            'is_active' => 'required|boolean',
            'is_recommended' => 'required|boolean',
            'duration' => 'required|numeric|min:1',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:255',
        ]);

        
        try {
            // ذخیره در دیتابیس
            Plan::create([
                'name' => $validated['name'],
                'is_active' => $validated['is_active'],
                'is_recommended' => $validated['is_recommended'],
                'duration' => $validated['duration'],
                'price' => $validated['price'],
                'description' => $validated['description'],
                
            ]);
            // بازگشت به صفحه index با پیام موفقیت
            return redirect()->route('plans.index')->with('success', 'Plan created successfully.');
        } catch (\Exception $e) {
            // بازگشت به صفحه قبلی با پیام خطا
            return redirect()->back()->with('error', 'Failed to create plan. Please try again.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Plan $plan)
    {
        $fields = [
            ['name'=>'name', 'label' => 'Name', 'type' => 'text'],
            ['name'=>'is_active', 'label' => 'Is Active', 'type' => 'boolean'],
            ['name'=>'is_recommended', 'label' => 'Is Recommended', 'type' => 'boolean'],
            ['name'=>'duration', 'label' => 'Duration', 'type' => 'integer'],
            ['name'=>'price', 'label' => 'Price', 'type' => 'integer'],
            ['name'=>'description', 'label' => 'Deacription', 'type' => 'text']
        ];
        return view('plans.edit', 
            [
                'record' => $plan,
                'fields' => $fields
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Plan $plan)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:plans,name,' . $plan->id,
            'is_active' => 'required|boolean',
            'is_recommended' => 'required|boolean',
            'duration' => 'required|numeric|min:1',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:255',
        ]);

        try {
            // به‌روزرسانی داده‌ها
            $plan->update($validated);

            // بازگشت به صفحه index با پیام موفقیت
            return redirect()
                ->route('plans.index')
                ->with('success', 'Plan updated successfully.');
        } catch (\Exception $e) {
            // بازگشت به صفحه قبل با پیام خطا
            return redirect()
                ->back()
                ->withErrors(['error' => 'Failed to update plan: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
