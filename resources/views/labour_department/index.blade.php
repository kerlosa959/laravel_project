@extends('layouts.admin')

@section('page-title')
    {{__('Manage Labour Department')}}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Labour Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Labour Department')}}</li>
@endsection


@section('action-btn')
    <div class="float-end">
    
            <a href="#" data-url="{{ route('labour-department.create') }}" data-ajax-popup="true" data-title="{{__('Create New Department')}}" data-bs-toggle="tooltip" title="{{__('Create')}}"  class="btn btn-sm btn-primary">
                <i class="ti ti-plus"></i>
            </a>

    
    </div>
@endsection

@section('content')
    <div class="row">
        
        <div class="col-12">
            <div class="card">
            <div class="card-body table-border-style">
                    <div class="table-responsive">
                    <table class="table datatable">
                            <thead>
                            <tr>
                                <!-- <th>{{__('Branch')}}</th> -->
                                <th>{{__('Department')}}</th>
                                <th width="200px">{{__('Action')}}</th>
                            </tr>
                            </thead>
                            <tbody class="font-style">
                            @foreach ($departments as $department)
                                <tr>
                                    <!-- <td>{{ !empty($department->branch)?$department->branch->name:'' }}</td> -->
                                    <td>{{ $department->name }}</td>

                                    <td class="Action">
                                        <span>
                                            
                                            <div class="action-btn bg-primary ms-2">

                                                <a href="#" data-url="{{ URL::to('labour-department/'.$department->id.'/edit') }}"  data-ajax-popup="true" data-title="{{__('Edit Department')}}" class="mx-3 btn btn-sm d-inline-flex align-items-center" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-original-title="{{__('Edit')}}">
                                                    <i class="ti ti-pencil text-white"></i></a>
                                            </div>
                                                
                                                    <div class="action-btn bg-danger ms-2">
                                                        {!! Form::open(['method' => 'DELETE', 'route' => ['labour-department.destroy', $department->id],'id'=>'delete-form-'.$department->id]) !!}


                                                <a href="#" class="mx-3 btn btn-sm  align-items-center bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$department->id}}').submit();"><i class="ti ti-trash text-white"></i></a>
                                                {!! Form::close() !!}
                                                    </div>
                                            
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
