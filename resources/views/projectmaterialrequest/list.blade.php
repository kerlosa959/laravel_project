<div class="col-xl-12">
    <div class="card">
        <div class="card-body table-border-style">
            <div class="table-responsive">
                <table class="table datatable">
                    <thead>
                    <tr>
                        <th>{{__('Project')}}</th>
                        <th>{{__('Site Location')}}</th>
                        <th>{{__('Requested On')}}</th>
                        @if(\Auth::user()->type!='company')
                        <th>{{__('Requested By')}}</th>
                        @endif
                        <th>{{__('Status')}}</th>
                        <th class="text-end">{{__('Action')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(isset($projects) && !empty($projects) && count($projects) > 0)
                        @foreach ($projects as $key => $project)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="{{ route('projects.show',$project->project) }}" class="name mb-0 h6 text-sm">{{ $project->project->project_name }}</a>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="javascript:void(0)" class="name mb-0 h6 text-sm">{{ $project->site_location }}</a>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="javascript:void(0)" class="name mb-0 h6 text-sm"> {{ Utility::getDateFormated($project->created_at) }}</a>
                                    </div>
                                </td>
                                
                                @if(\Auth::user()->type!='company')
                                <td class="text-end">
                                    <div class="d-flex align-items-center">
                                        <a href="javascript:void(0)" class="name mb-0 h6 text-sm">{{ $project->requestedBy->name }}</a>
                                    </div>
                                </td>
                                @endif

                                
                                <td>
                                    <span class="badge bg-{{\App\Models\ProjectMaterialRequest::$status_color[$project->status]}} p-2 px-3 rounded">{{ __(\App\Models\ProjectMaterialRequest::$project_worker_request_status[$project->status]) }}</span>
                                </td>

                                <td class="text-end">
                                    <span>

                                       
                                    
                                            <div class="action-btn bg-info ms-2">
                                                <a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center" data-url="{{ route('projectmaterials.show',$project->id)  }}" data-ajax-popup="true" data-size="lg" data-bs-toggle="tooltip" title="{{__('Show')}}" data-title="{{__('Show Request')}}">
                                                    <i class="ti ti-eye text-white"></i>
                                                </a>
                                            </div>
                                       

                                       
                                            @if($project->status==1 && (\Auth::user()->type=='Supervisor' || \Auth::user()->id==$project->requested_by))
                                                <div class="action-btn bg-info ms-2">
                                                    <a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center" data-url="{{ URL::to('projectmaterials/'.$project->id.'/edit') }}" data-ajax-popup="true" data-size="lg" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-title="{{__('Edit Request')}}">
                                                        <i class="ti ti-pencil text-white"></i>
                                                    </a>
                                                </div>
                                            @endif
                                       

                                       
                                        @if($project->status==1 && (\Auth::user()->type=='Supervisor' || \Auth::user()->id==$project->requested_by))
                                            <div class="action-btn bg-danger ms-2">
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['projectmaterials.destroy', $project->id]]) !!}
                                                    <a href="#" class="mx-3 btn btn-sm  align-items-center bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}"><i class="ti ti-trash text-white"></i></a>
                                                    {!! Form::close() !!}
                                                </div>
                                        @endif
                                        

                                        @if(\Auth::user()->type=='company')
                                        @endif
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <th scope="col" colspan="7"><h6 class="text-center">{{__('No Record Found.')}}</h6></th>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

