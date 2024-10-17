<div class="col-xl-12">
    <div class="card">
        <div class="card-body table-border-style">
            <div class="table-responsive">
                <table class="table datatable">
                    <thead>
                    <tr>
                        <th>{{__('Request No')}}</th>
                        <th>{{__('Project')}}</th>
                        <th>{{__('Required labours')}}</th>
                        <th>{{__('Total Price')}}</th>
                        
                        <th>{{__('Status')}}</th>
                        <th>{{__('Requested Date')}}</th>
                        @if(\Auth::user()->type!='company')
                        <th>{{__('Requested By')}}</th>
                        @endif

                        <th class="text-end">{{__('Action')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(isset($projects) && !empty($projects) && count($projects) > 0)
                        @foreach ($projects as $key => $project)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="javascript:void(0)" class="name mb-0 h6 text-sm">{{ @$project->request_id }}</a>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        {{-- <a href="{{ route('projects.show',$project->project) }}" class="name mb-0 h6 text-sm">{{ $project->project->project_name }}</a> --}}
                                        <a href="javascript:void(0)" class="name mb-0 h6 text-sm">{{ @$project->project->project_name }}</a>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="javascript:void(0)" class="name mb-0 h6 text-sm">{{ @$project->total_workers }}</a>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="javascript:void(0)" class="name mb-0 h6 text-sm">{{ @$project->total_price }}</a>
                                    </div>
                                </td>
                               
                                <td>
                                    <span class="badge bg-{{\App\Models\ProjectWorkerRequest::$status_color[@$project->status]}} p-2 px-3 rounded">{{ __(\App\Models\ProjectWorkerRequest::$project_worker_request_status[@$project->status]) }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="javascript:void(0)" class="name mb-0 h6 text-sm">  {{ Utility::getDateFormated(@$project->created_at) }}
                                        </a>
                                    </div>
                                </td>
                                @if(\Auth::user()->type!='company')
                                <td class="text-end">
                                    <div class="d-flex align-items-center">
                                        <a href="javascript:void(0)" class="name mb-0 h6 text-sm">{{ @$project->requestedBy->name }}</a>
                                    </div>
                                </td>
                                @endif

                                <td class="text-end">
                                    <span>

                                        @can('edit labour request')
                                            <div class="action-btn bg-info ms-2">
                                                <a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center" data-url="{{ route('projectlabours.show',$project->id)  }}" data-ajax-popup="true" data-size="lg" data-bs-toggle="tooltip" title="{{__('Show')}}" data-title="{{__('Show Request')}}">
                                                    <i class="ti ti-eye text-white"></i>
                                                </a>
                                            </div>
                                        @endcan

                                        @can('edit labour request')
                                            @if($project->status==1 && (\Auth::user()->type=='Supervisor' || \Auth::user()->type=='Site Engineer') )
                                                <div class="action-btn bg-info ms-2">
                                                    <a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center" data-url="{{ URL::to('projectlabours/'.$project->id.'/edit') }}" data-ajax-popup="true" data-size="xl" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-title="{{__('Edit Request')}}">
                                                        <i class="ti ti-pencil text-white"></i>
                                                    </a>
                                                </div>
                                            @endif
                                        @endcan

                                        @can('delete labour request')
                                        @if($project->status==1 &&  \Auth::user()->type=='Supervisor')
                                            <div class="action-btn bg-danger ms-2">
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['projectlabours.destroy', @$project->id]]) !!}
                                                    <a href="#" class="mx-3 btn btn-sm  align-items-center bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}"><i class="ti ti-trash text-white"></i></a>
                                                    {!! Form::close() !!}
                                                </div>
                                        @endif
                                        @endcan

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

