{{ Form::model($projectworkerrequest, ['route' => ['projectmaterials.update', $projectworkerrequest->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) }}
<div class="modal-body">
    {{-- start for ai module--}}

    {{-- end for ai module--}}
    <div class="text-end">
        &nbsp;
    </div>
    <div class="row">
        <div class="col-sm-6 col-md-6">
            <div class="form-group">
                {{ Form::label('project_id', __('Project'),['class'=>'form-label']) }}<span class="text-danger">*</span>
                {!! Form::select('project_id', $projects, $projectworkerrequest->project_id,array('class' => 'form-control','required'=>'required')) !!}
            </div>
        </div>
        <div class="col-sm-6 col-md-6">
            <div class="form-group">
                {{ Form::label('site_location', __('Site Location'),['class'=>'form-label']) }}<span class="text-danger">*</span>
                {{ Form::text('site_location', $projectworkerrequest->site_location, ['class' => 'form-control','required'=>'required']) }}
            </div>
        </div>

    </div>
    
    <div class="row">
        <div class="form-group">
            {{ Form::label('materials', __('Add Material/Equipment'),['class'=>'form-label']) }}<span class="text-danger">*</span>

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
                    <th>Action</th>

                </tr>
<?php
$j=0;
if(!empty($projectworkerrequest->workers))
{
    foreach($projectworkerrequest->workers as $key=>$val)
    {
?>
                <tr>
                <td>
                    <select class="form-control category" name="addmore[{{$key}}][item_name]"  id="item_name{{$key}}" required="">
                        <option value="">{{ __('Select Material') }}</option>
                        @foreach($products as $product)
                            <option <?= ($val->item_name==$product->id)?"selected":"" ?> value="{{$product->id}}">{{$product->name}}</option>
                        @endforeach
                    </select>
                </td>
                <!-- <td><input type="text" name="addmore[{{$key}}][item_name]" value="{{$val->item_name}}" placeholder="Enter Name" class="form-control" required/></td>

                <td><input type="text" name="addmore[{{$key}}][item_type]" value="{{$val->item_type}}" placeholder="Enter Item Type" class="form-control" required/></td> -->

                <td><input type="text" name="addmore[{{$key}}][qty]" value="{{$val->qty}}" placeholder="Enter Qty" class="form-control" required /></td>

                <td><input type="text" name="addmore[{{$key}}][specification]" value="{{$val->specification}}" placeholder="Enter Specification" class="form-control" required /></td>
                <td><input type="text" name="addmore[{{$key}}][preferences]" value="{{$val->preferences}}" placeholder="Enter Preferences" class="form-control" required /></td>
                <td><input type="text" name="addmore[{{$key}}][required_duration]" value="{{$val->required_duration}}" placeholder="Enter Duration" class="form-control" required /></td>
                <!-- <td><input type="text" name="addmore[{{$key}}][priority]" value="{{$val->priority}}" placeholder="Enter Priority" class="form-control" required /></td> -->
                <td><select name="addmore[{{$key}}][priority]" class="form-control" required ><option {{($val->priority=="Low")?"selected":""}} value="Low">Low</option><option {{($val->priority=="Medium")?"selected":""}} value="Medium">Medium</option><option {{($val->priority=="High")?"selected":""}} value="High">High</option></select></td>


<?php if($j==0){?>
                <td><button type="button" name="add" id="add" class="btn btn-success">Add More</button></td>
<?php }
else{ ?>
                <td><button type="button" class="btn btn-danger remove-tr">Remove</button></td>
<?php }$j++;?>

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
    <input type="submit" value="{{__('Update')}}" class="btn  btn-primary">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
</div>
{{Form::close()}}
<script type="text/javascript">
    var i = {{count($projectworkerrequest->workers)-1}};
    $("#add").click(function(){
        ++i;
        $("#dynamicTable").append('<tr><td><select class="form-control" name="addmore['+i+'][item_name]" id="item_name" required=""><option value="">{{ __('Select Material') }}</option>@foreach($products as $product)<option value="{{$product->id}}">{{$product->name}}</option>@endforeach</select></td><td><input type="text" name="addmore['+i+'][qty]" placeholder="Enter Qty" class="form-control" required/></td><td><input type="text" name="addmore['+i+'][specification]" placeholder="Enter Specification" class="form-control" required/></td><td><input type="text" name="addmore['+i+'][preferences]" placeholder="Enter Preferences" class="form-control" required/></td><td><input type="text" name="addmore['+i+'][required_duration]" placeholder="Enter Duration" class="form-control" required/></td><td><select name="addmore['+i+'][priority]" class="form-control" required ><option value="Low">Low</option><option value="Medium">Medium</option><option value="High">High</option></select></td><td><button type="button" class="btn btn-danger remove-tr">Remove</button></td></tr>');

        /* $("#dynamicTable").append('<tr><td><input type="text" name="addmore['+i+'][item_name]" placeholder="Enter Name" class="form-control" required/></td><td><input type="text" name="addmore['+i+'][item_type]" placeholder="Enter Item Type" class="form-control" required/></td><td><input type="text" name="addmore['+i+'][qty]" placeholder="Enter Qty" class="form-control" required/></td><td><input type="text" name="addmore['+i+'][specification]" placeholder="Enter Specification" class="form-control" required/></td><td><input type="text" name="addmore['+i+'][preferences]" placeholder="Enter Preferences" class="form-control" required/></td><td><input type="text" name="addmore['+i+'][required_duration]" placeholder="Enter Duration" class="form-control" required/></td><td><select name="addmore['+i+'][priority]" class="form-control" required ><option value="Low">Low</option><option value="Medium">Medium</option><option value="High">High</option></select></td><td><button type="button" class="btn btn-danger remove-tr">Remove</button></td></tr>'); */
    });
    $(document).on('click', '.remove-tr', function(){
         $(this).parents('tr').remove();
    });
</script>
