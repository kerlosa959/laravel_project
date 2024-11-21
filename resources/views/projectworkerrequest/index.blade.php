@extends('layouts.admin')
@section('page-title')
    {{__('Manage Labour Requests')}}
@endsection
@push('script-page')
@endpush
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Labour Requests')}}</li>
@endsection
@section('action-btn')
    <div class="float-end">


        {{------------ Start Filter ----------------}}
                <a href="#" class="btn btn-sm btn-primary action-item" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="ti ti-filter"></i>
                </a>
                <div class="dropdown-menu  dropdown-steady" id="project_sort">
                    <a class="dropdown-item active" href="#" data-val="created_at-desc">
                        <i class="ti ti-sort-descending"></i>{{__('Newest')}}
                    </a>
                    <a class="dropdown-item" href="#" data-val="created_at-asc">
                        <i class="ti ti-sort-ascending"></i>{{__('Oldest')}}
                    </a>

                    <a class="dropdown-item" href="#" data-val="project_name-desc">
                        <i class="ti ti-sort-descending-letters"></i>{{__('From Z-A')}}
                    </a>
                    <a class="dropdown-item" href="#" data-val="project_name-asc">
                        <i class="ti ti-sort-ascending-letters"></i>{{__('From A-Z')}}
                    </a>
                </div>

            {{------------ End Filter ----------------}}

            {{------------ Start Status Filter ----------------}}
                <a href="#" class="btn btn-sm btn-primary action-item" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="btn-inner--icon">{{__('Status')}}</span>
                </a>
                <div class="dropdown-menu  project-filter-actions dropdown-steady" id="project_status">
                    <a class="dropdown-item filter-action filter-show-all pl-4 active" href="#">{{__('Show All')}}</a>
                    @foreach(\App\Models\ProjectWorkerRequest::$project_worker_request_status as $key => $val)
                        <a class="dropdown-item filter-action pl-4" href="#" data-val="{{ $key }}">{{__($val)}}</a>
                    @endforeach
                </div>
            {{------------ End Status Filter ----------------}}

        @can('create labour request')
            @if( \Auth::user()->type!='company' && \Auth::user()->type!='Accountant'  && \Auth::user()->type!='Manager')
            <a href="#" data-size="xl" data-url="{{ route('projectlabours.create') }}" data-ajax-popup="true" data-bs-toggle="tooltip" title="{{__('Create New Request')}}" data-title="{{__('Create New Request')}}" class="btn btn-sm btn-primary">
                <i class="ti ti-plus"></i>
            </a>
            @endif
        @endcan
    </div>
@endsection

@section('content')
    <div class="row min-750" id="project_view"></div>
@endsection

@push('script-page')
    <script>
        $(document).ready(function () {

            var sort = 'created_at-desc';
            var status = '';
            ajaxFilterProjectView('created_at-desc');
            $(".project-filter-actions").on('click', '.filter-action', function (e) {
                if ($(this).hasClass('filter-show-all')) {
                    $('.filter-action').removeClass('active');
                    $(this).addClass('active');
                } else {
                    $('.filter-show-all').removeClass('active');
                    if ($(this).hasClass('active')) {
                        $(this).removeClass('active');
                        $(this).blur();
                    } else {
                        $(this).addClass('active');
                    }
                }

                var filterArray = [];
                var url = $(this).parents('.project-filter-actions').attr('data-url');
                $('div.project-filter-actions').find('.active').each(function () {
                    filterArray.push($(this).attr('data-val'));
                });

                status = filterArray;

                ajaxFilterProjectView(sort, $('#project_keyword').val(), status);
            });

            // when change sorting order
            $('#project_sort').on('click', 'a', function () {
                sort = $(this).attr('data-val');
                ajaxFilterProjectView(sort, $('#project_keyword').val(), status);
                $('#project_sort a').removeClass('active');
                $(this).addClass('active');
            });

            // when searching by project name
            $(document).on('keyup', '#project_keyword', function () {
                ajaxFilterProjectView(sort, $(this).val(), status);
            });

        });

        var currentRequest = null;

        function ajaxFilterProjectView(project_sort, keyword = '', status = '') {

            var mainEle = $('#project_view');
            var view = '{{$view}}';
            var data = {
                view: view,
                sort: project_sort,
                keyword: keyword,
                status: status,
            }


            currentRequest = $.ajax({
                url: '{{ route('filter.projectlabour.view') }}',
                data: data,
                beforeSend: function () {
                    if (currentRequest != null) {
                        currentRequest.abort();
                    }
                },
                success: function (data) {
                    mainEle.html(data.html);
                    $('[id^=fire-modal]').remove();
                    loadConfirm();
                }
            });
        }
    </script>
@endpush
<form method="GET" action="{{ route('labours.search') }}">
    <label for="search">Search Labour:</label>
    <input type="text" name="search" id="search" placeholder="Enter name or mobile number" required>
    <button type="submit">Search</button>
</form>

<!-- Table to Display Search Results -->
@if(isset($labours))
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Mobile Number</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($labours as $labour)
                <tr>
                    <td>{{ $labour->name }}</td>
                    <td>{{ $labour->mobile }}</td>
                    <td>
                        <form method="POST" action="{{ route('labours.add', $labour->id) }}">
                            @csrf
                            <button type="submit">Add</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

<!-- Display Added Labour Details -->
@if(isset($selectedLabour))
    <h2>Labour Details</h2>
    <p>Name: {{ $selectedLabour->name }}</p>
    <p>Mobile: {{ $selectedLabour->mobile }}</p>
    <!-- Add more fields as needed -->
@endif

