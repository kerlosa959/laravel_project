<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project;
use App\Models\ProjectMaterialRequest;
use App\Models\ProjectMaterials;
use App\Models\ProductService;
use App\Models\ProductStock;
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

class ProjectMaterialRequestController extends Controller
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
            return view('projectmaterialrequest.index', compact('view'));
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

          $products = ProductService::orderBy('name','desc')->get();
          

            return view('projectmaterialrequest.create', compact('projects','products'));
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
                    'project_id' => 'required',
                    'addmore.*.item_name' => 'required',
                    // 'addmore.*.item_type' => 'required',
                    'addmore.*.qty' => 'required',
                            ]
            );

            if($validator->fails())
            {
                return redirect()->back()->with('error', Utility::errorFormat($validator->getMessageBag()));
            }

            $projectCreatedBy=Project::find($request->project_id)->created_by;
            $project = new ProjectMaterialRequest();
            $project->project_id = $request->project_id;
            $project->site_location = $request->site_location;
            $project->requested_by = \Auth::user()->id;
            $project->created_by = $projectCreatedBy;
            $project->status = 1;
            $project->created_at = date("Y-m-d H:i:s");
            

            if($project->save()){
                foreach ($request->addmore as $key => $value) {
                    $value['project_material_request_id']=$project->id;
                    ProjectMaterials::create($value);

                }
            }
            return redirect()->route('projectmaterials.index')->with('success', __('Request Created Successfully'));
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
          $projectworkerrequest = ProjectMaterialRequest::with('workers')->where('id', '=', $id)->first();
          $usr           = Auth::user();
          $user_projects = $usr->projects()->pluck('project_id', 'project_id')->toArray();
          $projects = Project::whereIn('id', array_keys($user_projects))->whereIn('status',['in_progress','on_hold'] )->get()->pluck('project_name', 'id');
          $projects->prepend('Select Project', '');

          return view('projectmaterialrequest.view', compact('projects', 'projectworkerrequest'));
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
          $projectworkerrequest = ProjectMaterialRequest::with('workers')->where('id', '=', $id)->first();
          $usr           = Auth::user();
          $user_projects = $usr->projects()->pluck('project_id', 'project_id')->toArray();
          $projects = Project::whereIn('id', array_keys($user_projects))->whereIn('status',['in_progress','on_hold'] )->get()->pluck('project_name', 'id');
          $projects->prepend('Select Project', '');

          $products = ProductService::orderBy('name','desc')->get();

          return view('projectmaterialrequest.edit', compact('projects', 'projectworkerrequest','products'));
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
    public function update(Request $request, ProjectMaterialRequest $ProjectMaterialRequest)
    {

        if(\Auth::user()->can('edit labour request'))
        {
            $validator = \Validator::make(
                $request->all(), [
                                'project_id' => 'required',
                                'addmore.*.item_name' => 'required',
                                // 'addmore.*.item_type' => 'required',
                                'addmore.*.qty' => 'required',
                            ]
            );
            if($validator->fails())
            {
                return redirect()->back()->with('error', Utility::errorFormat($validator->getMessageBag()));
            }

            $project = ProjectMaterialRequest::where('id',$request->id)->first();

            $project->project_id = $request->project_id;
            $project->site_location = $request->site_location;
           // $project->requested_by = \Auth::user()->id;
            $project->status = 1;
            $project->updated_at = date("Y-m-d H:i:s");
            
            if($project->save())
            {
                ProjectMaterials::where('project_material_request_id',  $project->id)->delete();
                foreach ($request->addmore as $key => $value) {
                    $value['project_material_request_id']=$project->id;
                    ProjectMaterials::create($value);
                }
            }

            return redirect()->route('projectmaterials.index')->with('success', __('Request Updated Successfully'));

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
            $project = ProjectMaterialRequest::where('id',$request->id)->first();
            $projectDetail = Project::where('id',$project->project_id)->first();

       
            if(isset($request->accept))
            {
                $project->approved_datetime =date("Y-m-d H:i:s");
                $project->approved_rejected_by = \Auth::user()->id;
                $project->status = (isset($request->accept)?2:3);
                $project->updated_at = date("Y-m-d H:i:s");
                if($project->save())
                {
                    $materials=ProjectMaterials::where('project_material_request_id', $request->id)->get();

                    foreach ($materials as $material) {
                        $productService = ProductService::find($material->item_name);
                        $total = $productService->quantity - $material->qty;
                        $productService->quantity   = $total;
                        $productService->save();

                       Utility::updateProductStock($material->item_name,$total);
                    }
                    
                }

            }
            else if(isset($request->send_to_manager))
            {
                if(\Auth::user()->type=='Accountant' )
                {
                    $project->accountant_id =\Auth::user()->id;
                    $project->accountant_aprroved_date_time = date("Y-m-d H:i:s");
                    $project->logistic_status =0;
                    $project->accountant_status =1;
                    $project->status = 6;
                    $project->updated_at = date("Y-m-d H:i:s");
                }
                if(\Auth::user()->type=='Logistics' )
                {
                    $project->manager_id =$projectDetail->manager_id;
                    $project->logistic_id =\Auth::user()->id;
                    $project->logistic_aprroved_date_time = date("Y-m-d H:i:s");
                    $project->logistic_status =1;
                    $project->accountant_status =0;
                    $project->status = 4;
                    $project->updated_at = date("Y-m-d H:i:s");
                }
                
                
                $project->save();
            }
            else
            {
                if(\Auth::user()->type=='Accountant' )
                {
                    $project->accountant_rejected_date_time = date("Y-m-d H:i:s");
                    $project->accountant_id =\Auth::user()->id;
                    $project->accountant_status =2;
                    $project->updated_at = date("Y-m-d H:i:s");
                    $project->save();
                }
                if(\Auth::user()->type=='Logistics' )
                {
                    $project->logistic_rejected_date_time = date("Y-m-d H:i:s");
                    $project->logistic_id =\Auth::user()->id;
                    $project->logistic_status =2;
                    $project->updated_at = date("Y-m-d H:i:s");
                    $project->save();
                }
                else{
                    $project->rejected_datetime = date("Y-m-d H:i:s");
                    $project->approved_rejected_by = \Auth::user()->id;
                    $project->status = (isset($request->accept)?2:3);
                    $project->updated_at = date("Y-m-d H:i:s");
                    $project->save();
                }
                
            }

            

            return redirect()->route('projectmaterials.index')->with('success', __('Request Updated Successfully'));

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
        
        
            $ProjectMaterialRequest = ProjectMaterialRequest::find($id);

            // delete related
            $ProjectMaterialRequest->workers()->delete();
            $ProjectMaterialRequest->delete();


            return redirect()->back()->with('success', __('Request Successfully Deleted.'));
        
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
                    $projects = ProjectMaterialRequest::where('created_by',\Auth::user()->id)->with(['project:id,project_name','requestedBy:id,name','approvedBy:id,name'])->orderBy($sort[0], $sort[1]);
                }
                else if(\Auth::user()->type=='Accountant')
                {
                    $projects = ProjectMaterialRequest::with(['project:id,project_name','requestedBy:id,name','approvedBy:id,name'])->orderBy($sort[0], $sort[1]);
                }
                else if(\Auth::user()->type=='Logistics')
                {
                    $projects = ProjectMaterialRequest::with(['project:id,project_name','requestedBy:id,name','approvedBy:id,name'])->where('accountant_status',1)->orWhere('logistic_id',\Auth::user()->id)->orderBy($sort[0], $sort[1]);
                }
                else if(\Auth::user()->type=='Manager')
                {
                    $projects = ProjectMaterialRequest::where('manager_id',\Auth::user()->id)->with(['project:id,project_name','requestedBy:id,name','approvedBy:id,name'])->orderBy($sort[0], $sort[1]);
                }
                else
                {
                    $projects = ProjectMaterialRequest::where('requested_by',\Auth::user()->id)->with(['project:id,project_name','requestedBy:id,name','approvedBy:id,name'])->orderBy($sort[0], $sort[1]);
                }




                if(!empty($request->status))
                {
                    $projects->whereIn('status', $request->status);
                }

                $projects   = $projects->get();



                $returnHTML = view('projectmaterialrequest.' . $request->view, compact('projects'))->render();
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
