<?php

namespace App\Http\Controllers;

use App\Models\ProjectType;
use Illuminate\Http\Request;

class ProjectTypeController extends Controller
{
    public function index()
    {
        if(\Auth::user()->can('manage allowance option'))
        {
            $projectTypes = ProjectType::get();

            return view('projecttype.index', compact('projectTypes'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function create()
    {
        if(\Auth::user()->can('create allowance option'))
        {
            return view('projecttype.create');
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function store(Request $request)
    {
        

            $validator = \Validator::make(
                $request->all(), [
                                   'name' => 'required',
                               ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $ProjectType             = new ProjectType();
            $ProjectType->name       = $request->name;
            $ProjectType->created_by = \Auth::user()->creatorId();
            $ProjectType->save();

            return redirect()->route('projecttype.index')->with('success', __('ProjectType  successfully created.'));
       
    }

    public function show(ProjectType $ProjectType)
    {
        return redirect()->route('projecttype.index');
    }

    public function edit(ProjectType $projecttype)
    {
        
            if($projecttype->created_by == \Auth::user()->creatorId())
            {

                return view('projecttype.edit', compact('projecttype'));
            }
            else
            {
                return response()->json(['error' => __('Permission denied.')], 401);
            }
        
    }

    public function update(Request $request, ProjectType $projecttype)
    {
        
            if($projecttype->created_by == \Auth::user()->creatorId())
            {
                $validator = \Validator::make(
                    $request->all(), [
                                       'name' => 'required',

                                   ]
                );

                if($validator->fails())
                {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }
                $projecttype->name = $request->name;
                $projecttype->save();

                return redirect()->route('projecttype.index')->with('success', __('ProjectType successfully updated.'));
            }
            else
            {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        
    }

    public function destroy(ProjectType $projecttype)
    {
       $projecttype->delete();
       return redirect()->route('projecttype.index')->with('success', __('Type successfully deleted.'));
            
            
       
    }

}
