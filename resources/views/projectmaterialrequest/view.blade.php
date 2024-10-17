{{ Form::model($projectworkerrequest, ['route' => ['projectmaterial.materialUpdateStatus', $projectworkerrequest->id],'id'=>"updateStatus-form", 'method' => 'PPOST', 'enctype' => 'multipart/form-data']) }}
<div class="modal-body">
    {{-- start for ai module--}}

    {{-- end for ai module--}}
    <div class="text-end">
        &nbsp;
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                <b> Project </b>: {{$projectworkerrequest->project->project_name}}
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                <b> Site Location </b>: {{$projectworkerrequest->site_location}}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="form-group">
           <b> Material Requests</b>
        </div>

        
        <div class="col-sm-12 col-md-12">
            <table class="table table-bordered" id="dynamicTable">
                <tr>
                    <th>Item Name</th>
                    <!-- <th>Item Type</th> -->
                    <th>Qty</th>
                    <th>Specification</th>
                    <th>Preferences</th>
                    <th>Duration</th>
                    <th>Priority</th>
                </tr>
                <?php
                $j=0;
                if(!empty($projectworkerrequest->workers))
                {
                    foreach($projectworkerrequest->workers as $key=>$val)
                    {
                        ?>
                        <tr>
                            <td>{{$val->product->name}}</td>
                            <!-- <td>{{$val->item_type}}</td> -->
                            <td>{{$val->qty}}</td>
                            <td>{{$val->specification}}</td>
                            <td>{{$val->preferences}}</td>
                            <td>{{$val->required_duration}}</td>
                            <td>{{$val->priority}}</td>
                        </tr>
                        <?php
                    }
                }
                ?>


            </table>
        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="hidden" name='id' value="{{$projectworkerrequest->id}}" >
    <!-- @if( \Auth::user()->type=='company' && $projectworkerrequest->status==1)
        <input type="submit" id="accept"  name="accept" value="{{__('Accept')}}" class="btn  btn-primary">
        <input type="submit" id="reject" name="reject" value="{{__('Reject')}}" class="btn  btn-primary">
    @endif -->
    
    @if( $projectworkerrequest->status==1 ||  $projectworkerrequest->status==4 ||  $projectworkerrequest->status==6 )
        @if( \Auth::user()->type=='Accountant'  && is_null( $projectworkerrequest->logistic_status) )
            <input type="submit" id="send_to_manager"  name="send_to_manager" value="{{__('Approve and Send To Logistics')}}" class="btn  btn-primary">
        @endif
        @if( \Auth::user()->type=='Logistics'  && is_null( $projectworkerrequest->manager_id) )
            <input type="submit" id="send_to_manager"  name="send_to_manager" value="{{__('Approve and Send To Manager')}}" class="btn  btn-primary">
        @endif

       
        {{-- @if( \Auth::user()->can('accept labour request') && ((\Auth::user()->type=='Accountant' && is_null( $projectworkerrequest->manager_id) || (\Auth::user()->type=='Manager' && ($projectworkerrequest->status==1 || $projectworkerrequest->status==4)))) )
            <input type="submit" id="accept"  name="accept" value="{{__('Accept')}}" class="btn  btn-primary">
        @endif --}}
        @if( \Auth::user()->can('reject labour request')  && ((\Auth::user()->type=='Accountant' && is_null( $projectworkerrequest->manager_id) || (\Auth::user()->type=='Manager' && ($projectworkerrequest->status==1 || $projectworkerrequest->status==4 ||  $projectworkerrequest->status==6 )))) )
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
    
</script>
