<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\LabourDepartment;
use Illuminate\Http\Request;

class LabourDepartmentController extends Controller
{
    public function index()
    {
        if(\Auth::user()->can('manage department'))
        {
            $departments = LabourDepartment::get();

            return view('labour_department.index', compact('departments'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function create()
    {
        if(\Auth::user()->can('create department'))
        {
            $branch = Branch::get()->pluck('name', 'id');

            return view('labour_department.create', compact('branch'));
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function store(Request $request)
    {
        if(\Auth::user()->can('create department'))
        {

            $validator = \Validator::make(
                $request->all(), [
                                   //'branch_id' => 'required',
                                   'name' => 'required',
                               ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $department             = new LabourDepartment();
            
            $department->name       = $request->name;
            $department->created_by = \Auth::user()->creatorId();
            $department->save();

            return redirect()->route('labour-department.index')->with('success', __('Department  successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function show(LabourDepartment $department)
    {
        return redirect()->route('labour-department.index');
    }

    public function edit($id)
    {
        if(\Auth::user()->can('edit department'))
        {
                $department = LabourDepartment::where('id',$id)->first();
                return view('labour_department.edit', compact('department'));
            
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function update(Request $request, $id)
    {
        if(\Auth::user()->can('edit department'))
        {
            if(true)
            {
                
                $validator = \Validator::make(
                    $request->all(), [
                                      // 'branch_id' => 'required',
                                       'name' => 'required',
                                   ]
                );
                if($validator->fails())
                {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }

                $department = LabourDepartment::where('id',$id)->first();
                $department->name      = $request->name;
                $department->save();

                return redirect()->route('labour-department.index')->with('success', __('Department successfully updated.'));
            }
            else
            {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function destroy($id)
    {
        if(\Auth::user()->can('delete department'))
        {
            if(true)
            {
                $department = LabourDepartment::where('id',$id)->first();
                $department->delete();

                return redirect()->route('labour-department.index')->with('success', __('Department successfully deleted.'));
            }
            else
            {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}
