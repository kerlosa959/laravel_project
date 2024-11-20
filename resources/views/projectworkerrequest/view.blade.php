{{ Form::model($projectworkerrequest, ['route' => ['projectlabour.updateStatus', $projectworkerrequest->id],'id'=>"updateStatus-form", 'method' => 'PPOST', 'enctype' => 'multipart/form-data']) }}
<div class="modal-body">
    {{-- start for ai module--}}

    {{-- end for ai module--}}
    <div class="text-end">
      &nbsp;
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="form-group">
            <b> Request No </b>: {{$projectworkerrequest->request_id}}
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                <b> Project </b>: {{$projectworkerrequest->project->project_name}}
            </div>
        </div>

    </div>
    
    @if(!is_null($projectworkerrequest->milestone_id))
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                <b> Milestone </b>: {{$projectworkerrequest->milestone->title}}
            </div>
        </div>

    </div>
    @endif
    @if(!is_null($projectworkerrequest->task_id))
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                <b> Task </b>: {{$projectworkerrequest->task->name}}
            </div>
        </div>

    </div>
    @endif
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                <b> Requested Date </b>: {{ Utility::getDateFormated($projectworkerrequest->created_at) }}
            </div>
        </div>

    </div>

    <div class="row">
        <div class="form-group">
           <b> Labours</b>
        </div>

        
        <div class="col-sm-12 col-md-12">
            <table class="table table-bordered" id="dynamicTable">
                <tr>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Rate</th>
                    <th>Days</th>
                    <th>Subtotal</th>
                </tr>
                <?php
                $j=0;
                if(!empty($projectworkerrequest->workers))
                {
                    foreach($projectworkerrequest->workers as $key=>$val)
                    {
                        ?>
                        <tr>
                            <td>{{$val->worker_name}}</td>

                            <td>{{$val->worker_phone}}</td>
                            <td>{{$val->price}}</td>
                            <td>{{$val->hours}}</td>

                            <td>{{$val->subtotal}}</td>
                        </tr>
                        <?php
                    }
                }
                ?>


            </table>
        </div>
    </div>
</div>
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

<div class="modal-footer">
    <input type="hidden" name='id' value="{{$projectworkerrequest->id}}" >
    <!-- @if( \Auth::user()->type=='company' && $projectworkerrequest->status==1)
        <input type="submit" id="accept"  name="accept" value="{{__('Accept')}}" class="btn  btn-primary">
        <input type="submit" id="reject" name="reject" value="{{__('Reject')}}" class="btn  btn-primary">
    @endif -->

    @if( $projectworkerrequest->status==1 ||  $projectworkerrequest->status==4 )
        @if( \Auth::user()->type=='Accountant'  && is_null( $projectworkerrequest->manager_id) )
            <input type="submit" id="send_to_manager"  name="send_to_manager" value="{{__('Approve And Send To Manager')}}" class="btn  btn-primary">
        @endif
        <!-- @if( \Auth::user()->can('accept labour request') && ((\Auth::user()->type=='Accountant' && is_null( $projectworkerrequest->manager_id) || (\Auth::user()->type=='Manager' && ($projectworkerrequest->status==1 || $projectworkerrequest->status==4)))) )
            <input type="submit" id="accept"  name="accept" value="{{__('Accept')}}" class="btn  btn-primary">
        @endif -->
        @if( \Auth::user()->can('accept labour request') && (((\Auth::user()->type=='Manager' && ($projectworkerrequest->status==1 || $projectworkerrequest->status==4)))) )
            <input type="submit" id="accept"  name="accept" value="{{__('Accept')}}" class="btn  btn-primary">
        @endif
        @if( \Auth::user()->can('reject labour request')  && ((\Auth::user()->type=='Accountant' && is_null( $projectworkerrequest->manager_id) || (\Auth::user()->type=='Manager' && ($projectworkerrequest->status==1 || $projectworkerrequest->status==4)))) )
            <input type="submit" id="reject" name="reject" value="{{__('Reject')}}" class="btn  btn-primary">
        @endif
    @endif

    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
</div>
{{Form::close()}}
<script type="text/javascript">
    $("#accept,#reject").click(function(e){
        if (confirm('Are you sure you want to continue?')) {
            $('#updateStatus-form').submit();
        }
    });

    var i = {{count($projectworkerrequest->workers)-1}};
    $("#add").click(function(){
        ++i;
        $("#dynamicTable").append('<tr><td><input type="text" name="addmore['+i+'][worker_name]" placeholder="Enter Name" class="form-control" required /></td><td><input type="text" name="addmore['+i+'][worker_phone]" placeholder="Enter your Qty" class="form-control" required/></td><td><input type="text" name="addmore['+i+'][price]" placeholder="Enter your Price" class="form-control" required /></td><td><button type="button" class="btn btn-danger remove-tr">Remove</button></td></tr>');
    });
    $(document).on('click', '.remove-tr', function(){
         $(this).parents('tr').remove();
    });
</script>
