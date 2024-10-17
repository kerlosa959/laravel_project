<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project;
use App\Models\ProjectWorkerRequest;
use App\Models\LabourDepartment;
use App\Models\Labours;
use App\Models\ProjectWorkers;
use Carbon\Carbon;
use App\Models\ActivityLog;
use App\Models\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class ProjectWorkerRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $view = 'list';

        if(\Auth::user()->can('manage labour request'))
        {
            return view('projectworkerrequest.index', compact('view'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(\Auth::user()->can('create labour request'))
        {
          $usr           = Auth::user();
          $user_projects = $usr->projects()->pluck('project_id', 'project_id')->toArray();
          $projects = Project::whereIn('id', array_keys($user_projects))->whereIn('status',['in_progress','on_hold'] )->get()->pluck('project_name', 'id');
          $projects->prepend('Select Project', '');
          $departments=LabourDepartment::get();

            return view('projectworkerrequest.create', compact('projects','departments'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(\Auth::user()->can('create labour request'))
        {

            $validator = \Validator::make(
                $request->all(), [
                    'addmore.*.labour' => 'required',
                    
                    'addmore.*.price' => 'required',
                            ]
            );

            if($validator->fails())
            {
                return redirect()->back()->with('error', Utility::errorFormat($validator->getMessageBag()));
            }

            $projectCreatedBy=Project::find($request->project_id)->created_by;
            $project = new ProjectWorkerRequest();
            $project->request_id       =  Utility::getLabourNo();
            $project->project_id = $request->project_id;
            $project->milestone_id = $request->milestone_id;
            $project->task_id = $request->task_id;
            $project->requested_by = \Auth::user()->id;
            $project->created_by = $projectCreatedBy;
            $project->status = 1;
            $project->total_workers = count($request->addmore);
            $project->total_price = array_sum(array_column($request->addmore, 'subtotal'));
            
            // $project->start_date = date("Y-m-d H:i:s", strtotime($request->start_date));
            // $project->end_date = date("Y-m-d H:i:s", strtotime($request->end_date));

            

            if($project->save()){
                foreach ($request->addmore as $key => $value) {
                    $value['project_worker_request_id']=$project->id;
                    $value['worker_id']=$value['labour'];
                   
                    $labour=Labours::where('id',$value['labour'])->first();
                    $value['worker_name']= $labour->name;
                    $value['worker_phone']=$labour->phone;
                    $value['hours']= $value['days'];
                    ProjectWorkers::create($value);

                }
            }
            return redirect()->route('projectlabours.index')->with('success', __('Request Created Successfully'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Poject  $poject
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(\Auth::user()->can('view labour request'))
        {
          $projectworkerrequest = ProjectWorkerRequest::with('workers')->where('id', '=', $id)->first();
          $usr           = Auth::user();
          $user_projects = $usr->projects()->pluck('project_id', 'project_id')->toArray();
          $projects = Project::whereIn('id', array_keys($user_projects))->whereIn('status',['in_progress','on_hold'] )->get()->pluck('project_name', 'id');
          $projects->prepend('Select Project', '');

          return view('projectworkerrequest.view', compact('projects', 'projectworkerrequest'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Poject  $poject
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(\Auth::user()->can('edit labour request'))
        {
          $projectworkerrequest = ProjectWorkerRequest::with('workers')->where('id', '=', $id)->first();
          $usr           = Auth::user();
          $user_projects = $usr->projects()->pluck('project_id', 'project_id')->toArray();
          $projects = Project::whereIn('id', array_keys($user_projects))->whereIn('status',['in_progress','on_hold'] )->get()->pluck('project_name', 'id');
          $projects->prepend('Select Project', '');

          $departments=LabourDepartment::get();

          return view('projectworkerrequest.edit', compact('projects', 'projectworkerrequest','departments'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Poject  $poject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProjectWorkerRequest $projectworkerrequest)
    {

        if(\Auth::user()->can('edit labour request'))
        {
            $validator = \Validator::make(
                $request->all(), [
                                'project_id' => 'required',
                                'addmore.*.labour' => 'required',
                    
                                'addmore.*.price' => 'required',
                            ]
            );
            if($validator->fails())
            {
                return redirect()->back()->with('error', Utility::errorFormat($validator->getMessageBag()));
            }

            $projectCreatedBy=Project::find($request->project_id)->created_by;
            $project = ProjectWorkerRequest::where('id',$request->id)->first();

            $project->project_id = $request->project_id;
            $project->milestone_id = $request->milestone_id;
            $project->task_id = $request->task_id;
            $project->created_by = $projectCreatedBy;
            $project->requested_by = \Auth::user()->id;
            $project->status = 1;
            $project->total_workers = count($request->addmore);
            $project->total_price = array_sum(array_column($request->addmore, 'subtotal'));
            $project->updated_at = date("Y-m-d H:i:s");
           

            // $project->start_date = date("Y-m-d H:i:s", strtotime($request->start_date));
            // $project->end_date = date("Y-m-d H:i:s", strtotime($request->end_date));
            
            

            if($project->save())
            {
                ProjectWorkers::where('project_worker_request_id',  $project->id)->delete();
                foreach ($request->addmore as $key => $value) {
                    $value['project_worker_request_id']=$project->id;
                    $value['worker_id']=$value['labour'];
                   
                    $labour=Labours::where('id',$value['labour'])->first();
                    $value['worker_name']= $labour->name;
                    $value['worker_phone']=$labour->phone;
                    $value['hours']= $value['days'];
                    ProjectWorkers::create($value);
                }
            }

            return redirect()->route('projectlabours.index')->with('success', __('Request Updated Successfully'));

        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }
    public function updateStatus(Request $request)
    {

        if(\Auth::user()->can('edit labour request'))
        {
            $project = ProjectWorkerRequest::where('id',$request->id)->first();
            $projectDetail = Project::where('id',$project->project_id)->first();

       
            if(isset($request->accept))
            {
                $project->approved_datetime =date("Y-m-d H:i:s");
                $project->approved_rejected_by = \Auth::user()->id;
                $project->status = (isset($request->accept)?2:3);
                $project->updated_at = date("Y-m-d H:i:s");
                $project->save();
            }
            else if(isset($request->send_to_manager))
            {
                $project->manager_id =$projectDetail->manager_id;
                $project->status = 4;
                $project->updated_at = date("Y-m-d H:i:s");
                $project->save();

                // $project->manager_aprroved_date_time = date("Y-m-d H:i:s");
                // $project->manager_status =1;
                // $project->status = 4;
                // $project->updated_at = date("Y-m-d H:i:s");
            }
            else
            {
                $project->rejected_datetime = date("Y-m-d H:i:s");
                $project->approved_rejected_by = \Auth::user()->id;
                $project->status = (isset($request->accept)?2:3);
                $project->updated_at = date("Y-m-d H:i:s");
                $project->save();
            }

            

            return redirect()->route('projectlabours.index')->with('success', __('Request Updated Successfully'));

        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Poject  $poject
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(\Auth::user()->can('delete labour request'))
        {
            $projectWorkerRequest = ProjectWorkerRequest::find($id);

            // delete related
            $projectWorkerRequest->workers()->delete();
            $projectWorkerRequest->delete();


            return redirect()->back()->with('success', __('Request Successfully Deleted.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }


    public function filterLabourProjectView(Request $request)
    {

        if(\Auth::user()->can('manage labour request'))
        {
            $usr           = Auth::user();


            if($request->ajax() && $request->has('view') && $request->has('sort'))
            {
                $sort     = explode('-', $request->sort);

                if(\Auth::user()->type=='company')
                {
                    $projects = ProjectWorkerRequest::where('created_by',\Auth::user()->id)->with(['project:id,project_name','requestedBy:id,name','approvedBy:id,name'])->orderBy($sort[0], $sort[1]);
                }
                else if(\Auth::user()->type=='Accountant')
                {
                    $projects = ProjectWorkerRequest::with(['project:id,project_name','requestedBy:id,name','approvedBy:id,name'])->orderBy($sort[0], $sort[1]);
                }
                else if(\Auth::user()->type=='Manager')
                {
                    $projects = ProjectWorkerRequest::where('manager_id',\Auth::user()->id)->with(['project:id,project_name','requestedBy:id,name','approvedBy:id,name'])->orderBy($sort[0], $sort[1]);
                }
                else
                {
                    $projects = ProjectWorkerRequest::where('requested_by',\Auth::user()->id)->with(['project:id,project_name','requestedBy:id,name','approvedBy:id,name'])->orderBy($sort[0], $sort[1]);
                }




                if(!empty($request->status))
                {
                    $projects->whereIn('status', $request->status);
                }

                $projects   = $projects->get();



                $returnHTML = view('projectworkerrequest.' . $request->view, compact('projects'))->render();
                return response()->json(
                    [
                        'success' => true,
                        'html' => $returnHTML,
                    ]
                );
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }









}
