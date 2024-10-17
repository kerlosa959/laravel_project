{{ Form::open(['url' => 'projectmaterials', 'method' => 'post','enctype' => 'multipart/form-data']) }}
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
                {!! Form::select('project_id', $projects, null,array('class' => 'form-control','required'=>'required')) !!}
            </div>
        </div>
        <div class="col-sm-6 col-md-6">
            <div class="form-group">
                {{ Form::label('site_location', __('Site Location'),['class'=>'form-label']) }}<span class="text-danger">*</span>
                {{ Form::text('site_location', null, ['class' => 'form-control','required'=>'required']) }}
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
                    {{-- <th>Item Type</th> --}}
                    <th>Qty</th>
                    <th>Specification</th>
                    <th>Preferences</th>
                    <th>Duration</th>
                    <th>Priority</th>
                    <th>Action</th>
                </tr>

                <tr>
                    <td>
                        <select class="form-control" name="addmore[0][item_name]" id="item_name" required="">
                            <option value="">{{ __('Select Material') }}</option>
                            @foreach($products as $product)
                        
                                <option value="{{$product->id}}">{{$product->name}}</option>
                            @endforeach
                        </select>
                        
                    </td>
                    {{-- <td><input type="text" name="addmore[0][item_name]" placeholder="Enter Name" class="form-control" required/></td> 
                    <td><input type="text" name="addmore[0][item_type]" placeholder="Enter Item Type" class="form-control" required/></td>--}}
                    <td><input type="text" name="addmore[0][qty]" placeholder="Enter Qty" class="form-control" required /></td>
                    <td><input type="text" name="addmore[0][specification]" placeholder="Enter Specification" class="form-control" required /></td>
                    <td><input type="text" name="addmore[0][preferences]" placeholder="Enter Preferences" class="form-control" required /></td>
                    <td><input type="text" name="addmore[0][required_duration]" placeholder="Enter Duration" class="form-control" required /></td>
                    <!-- <td><input type="text" name="addmore[0][priority]" placeholder="Enter Priority" class="form-control" required /></td> -->
                    <td><select name="addmore[0][priority]" class="form-control" required ><option value="Low">Low</option><option value="Medium">Medium</option><option value="High">High</option></select></td>

                    <td><button type="button" name="add" id="add" class="btn btn-success">Add More</button></td>
                </tr>
            </table>
        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Create')}}" class="btn  btn-primary">
</div>
{{Form::close()}}
<script type="text/javascript">
    var i = 0;
    $("#add").click(function(){
        ++i;
        $("#dynamicTable").append('<tr><td><select class="form-control" name="addmore['+i+'][item_name]" id="item_name" required=""><option value="">{{ __('Select Material') }}</option>@foreach($products as $product)<option value="{{$product->id}}">{{$product->name}}</option>@endforeach</select></td><td><input type="text" name="addmore['+i+'][qty]" placeholder="Enter Qty" class="form-control" required/></td><td><input type="text" name="addmore['+i+'][specification]" placeholder="Enter Specification" class="form-control" required/></td><td><input type="text" name="addmore['+i+'][preferences]" placeholder="Enter Preferences" class="form-control" required/></td><td><input type="text" name="addmore['+i+'][required_duration]" placeholder="Enter Duration" class="form-control" required/></td><td><select name="addmore['+i+'][priority]" class="form-control" required ><option value="Low">Low</option><option value="Medium">Medium</option><option value="High">High</option></select></td><td><button type="button" class="btn btn-danger remove-tr">Remove</button></td></tr>');
        // $("#dynamicTable").append('<tr><td><input type="text" name="addmore['+i+'][item_name]" placeholder="Enter Name" class="form-control" required/></td><td><input type="text" name="addmore['+i+'][item_type]" placeholder="Enter Item Type" class="form-control" required/></td><td><input type="text" name="addmore['+i+'][qty]" placeholder="Enter Qty" class="form-control" required/></td><td><input type="text" name="addmore['+i+'][specification]" placeholder="Enter Specification" class="form-control" required/></td><td><input type="text" name="addmore['+i+'][preferences]" placeholder="Enter Preferences" class="form-control" required/></td><td><input type="text" name="addmore['+i+'][required_duration]" placeholder="Enter Duration" class="form-control" required/></td><td><select name="addmore['+i+'][priority]" class="form-control" required ><option value="Low">Low</option><option value="Medium">Medium</option><option value="High">High</option></select></td><td><button type="button" class="btn btn-danger remove-tr">Remove</button></td></tr>');
    });
    $(document).on('click', '.remove-tr', function(){
         $(this).parents('tr').remove();
    });
</script>
