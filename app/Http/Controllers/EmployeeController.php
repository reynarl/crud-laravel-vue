<?php

namespace App\Http\Controllers;

use App\Models\Departament;
use App\Models\Employee;
use Illuminate\Http\Request;
use Inertia\Inertia;
// use DB;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    public function index()
    {
        // $employees = Employee::all();
        $employees = Employee::select('employees.id', 'employees.name', 'email', 'phone', 'departament_id', 'departaments.name as departament')
            ->join('departaments', 'departaments.id', '=', 'employees.departament_id')
            ->paginate(10);

        $departaments = Departament::all();

        return Inertia::render('Employees/Index', ['employees' => $employees, 'departaments' => $departaments]);
    }

    // public function create()
    // {
    //     return Inertia::render('Employees/Create');
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'departament_id' => 'required|numeric'
        ]);
        Employee::create($request->all());
        // return Inertia::render('employees');
        return redirect('employees');
    }

    /**
     * Display the specified resource.
     */
    // public function show(Employee $employee)
    // {
    //     return Inertia::render('Employees/Show', ['employee' => $employee]);
    // }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(Employee $employee)
    // {
    //     return Inertia::render('Employees/Edit', ['employee' => $employee]);
    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'departament_id' => 'required|numeric'
        ]);

        $employee->update($request->all());
        return redirect('employees');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect('employees');
    }

    public function graphic()
    {
        $data = Employee::select(DB::raw('count(employees.id) as count, departaments.name'))
            ->join('departaments', 'departaments.id', '=', 'employees.departament_id')
            ->groupBy('departaments.name')->get();

        return Inertia::render('Employees/Graphic', ['data' => $data]);
    }

    public function reports()
    {
        $employees = Employee::select('employees.id', 'employees.name', 'email', 'phone', 'departament_id', 'departaments.name as departament')
            ->join('departaments', 'departaments.id', '=', 'employees.departament_id')
            ->get();

        $departaments = Departament::all();

        return Inertia::render('Employees/Reports', ['employees' => $employees, 'departaments' => $departaments]);
    }
}
