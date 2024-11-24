<?php

namespace App\Http\Controllers;

use App\Models\Labours;
use App\Models\LabourDepartment;
use App\Models\ProjectTask;
use App\Models\Milestone;
use App\Models\Labour;
use Illuminate\Http\Request;

class LabourController extends Controller
{
    public function index()
    {
        if(\Auth::user()->can('manage department'))
        {
            $labours = Labours::get();

            return view('labour.index', compact('labours'));
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
            $departments = LabourDepartment::get()->pluck('name', 'id');

            return view('labour.create', compact('departments'));
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
                                   'phone' => 'required',
                                   'department_id' => 'required',
                                   'name' => 'required',
                               ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $department             = new Labours();
            
            
            $department->name       = $request->name;
            $department->phone       = $request->phone;
            $department->department_id       = $request->department_id;
            $department->created_by = \Auth::user()->creatorId();
            $department->save();

            return redirect()->route('labour.index')->with('success', __('Labour  successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function show(LabourLabour $department)
    {
        return redirect()->route('labour.index');
    }

    public function edit($id)
    {
        if(\Auth::user()->can('edit department'))
        {
                $departments = LabourDepartment::get()->pluck('name', 'id');
                $labour = Labours::where('id',$id)->first();
                return view('labour.edit', compact('labour','departments'));
            
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
                                        'phone' => 'required',
                                        'department_id' => 'required',
                                       'name' => 'required',
                                   ]
                );
                if($validator->fails())
                {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }

                $department = Labours::where('id',$id)->first();
                $department->name      = $request->name;
                $department->phone      = $request->phone;
                $department->department_id      = $request->department_id;
                $department->save();

                return redirect()->route('labour.index')->with('success', __('Labour successfully updated.'));
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
                $department = Labours::where('id',$id)->first();
                $department->delete();

                return redirect()->route('labour.index')->with('success', __('Labour successfully deleted.'));
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

    public function fetchLabourByDepartment(Request $request)
    {
        $data['agents'] = Labours::where('department_id',$request->id)->get()->pluck('name','id');
        
        return response()->json($data);
        
    }
    public function fetchMilestones(Request $request)
    {
        $data['agents'] = Milestone::where('project_id',$request->id)->get()->pluck('title','id');
        
        return response()->json($data);
        
    }
    public function fetchTasks(Request $request)
    {
        $data['agents'] = ProjectTask::where('milestone_id',$request->id)->get()->pluck('name','id');
        
        return response()->json($data);
        
    }
    
    public function search(Request $request)
    {
        $search = $request->get('search');
        $labours = Labour::where('name', 'LIKE', "%$search%")
            ->orWhere('mobile', 'LIKE', "%$search%")
            ->get();

        return view('labours.index', compact('labours'));
    }

    // Add labour and display their details
    public function add($id)
    {
        $selectedLabour = Labour::findOrFail($id);

        return view('labours.index', compact('selectedLabour'));
    }
}
