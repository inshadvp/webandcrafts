<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Mail\EmployeeMail;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use SebastianBergmann\LinesOfCode\Counter;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $employees = Employee::join('designations', 'designations.id', '=', 'employees.designation')->select('employees.*','designations.name as designation_name')->latest()->paginate(5);

        return view('employees.index',compact('employees'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $designations = DB::table('designations')->get();
        $designations = json_decode(json_encode($designations), true);
        return view('employees.create',compact('designations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:employees',
            'photo' => 'nullable|image|mimes:jpg,png,jpeg,svg|max:500000',
            'designation' => 'required',
        ]);

        $photo = $request->file('photo');
        if($photo != ''){
            $imageName = time().'.'.request()->photo->getClientOriginalExtension();
            request()->photo->move(public_path('photos'), $imageName);
        }else{
            $imageName = '';
        }
        // $request->merge([ 
        //     'photo' => $imageName
        // ]);
        // Employee::create($request->all());
        $employee = new Employee;
        $employee->name = $request->name;
        $employee->email = $request->email;
        $employee->photo = $imageName;
        $employee->designation = $request->designation;
        $employee->save();
        $employee_id = $employee->id;

        if($employee_id != ''){
            $request->merge([ 
                'random_password' =>  Str::random(20)
            ]);
            Mail::to($request->email)->send(new EmployeeMail($request));
        }

        return redirect()->route('employees.index')
                        ->with('success','Employee created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        $designations = DB::table('designations')->get();
        $designations = json_decode(json_encode($designations), true);
        return view('employees.edit',compact('employee','designations'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        $photo_name = $request->hidden_image;
        $photo = $request->file('photo');
        if($photo != '')
        {
            $request->validate([
                'name' => 'required',
                'photo' => 'nullable|image|mimes:jpg,png,jpeg,svg|max:500000',
                'designation' => 'required',
            ]);

            $photo_name = rand() . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('photos'), $photo_name);
        }
        else
        {
            $request->validate([
                'name' => 'required',
                'designation' => 'required',
            ]);
        }

        $data = [];
        $data['id'] = $request->id;
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['photo'] = $photo_name != '' ? $photo_name : '';
        $data['designation'] = $request->designation;
        Employee::where('id', $request->id)->update($data);

        return redirect()->route('employees.index')
                        ->with('success','Employee updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employees.index')
                        ->with('success','Employee deleted successfully');
    }


}
