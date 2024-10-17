{{ Form::model($projectworkerrequest, ['route' => ['projectlabours.update', $projectworkerrequest->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) }}
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
                {!! Form::select('project_id', $projects, $projectworkerrequest->project_id,array('class' => 'form-control','required'=>'required','onchange'=>"selectProject(this,".$projectworkerrequest->milestone_id.");")) !!}
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-sm-6 col-md-6">
            <div class="form-group">
                {{ Form::label('milestone_id', __('Milestones'),['class'=>'form-label']) }}
                {!! Form::select('milestone_id', [], null,array('class' => 'form-control','onchange'=>"selectMilestone(this,'');")) !!}
            </div>
        </div>
        <div class="col-sm-6 col-md-6">
            <div class="form-group">
                {{ Form::label('task_id', __('Task'),['class'=>'form-label']) }}
                {!! Form::select('task_id', [], null,array('class' => 'form-control')) !!}
            </div>
        </div>
    </div>

    <!-- <div class="row">
        <div class="col-sm-6 col-md-6">
            <div class="form-group">
                {{ Form::label('start_date', __('From'), ['class' => 'form-label']) }}
                {{ Form::date('start_date', $projectworkerrequest->start_date, ['class' => 'form-control']) }}
            </div>
        </div>
        <div class="col-sm-6 col-md-6">
            <div class="form-group">
                {{ Form::label('end_date', __('To'), ['class' => 'form-label']) }}
                {{ Form::date('end_date', $projectworkerrequest->end_date, ['class' => 'form-control']) }}
            </div>
        </div>
    </div> -->
    <div class="row">
        <div class="form-group">
            {{ Form::label('labours', __('Labours'),['class'=>'form-label']) }}<span class="text-danger">*</span>

        </div>
        <div class="col-sm-12 col-md-12">
            <table class="table table-bordered" id="dynamicTable">

                <tr>

                    <th>Department</th>
                    <th>Labour</th>
                    <th>Rate</th>
                    <th>Days</th>
                    <th>Subtotal</th>
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

                {{-- <td><input type="text" name="addmore[{{$key}}][worker_name]" value="{{$val->worker_name}}" placeholder="Enter Name" class="form-control" required/></td>

                <td><input type="text" name="addmore[{{$key}}][worker_phone]" value="{{$val->worker_phone}}" placeholder="Enter Phone" class="form-control" required/></td>

                <td><input type="text" name="addmore[{{$key}}][price]" value="{{$val->price}}" placeholder="Enter Price" class="form-control" required /></td> --}}


                <td>
                    <select class="form-control category" name="addmore[{{$key}}][department_id]" data-labour="{{$val->worker_id}}" onchange="categoryChange(this,'');" id="category{{$key}}" required="">
                        <option value="">{{ __('Select Department') }}</option>
                        @foreach($departments as $department)
                            <option <?= ($val->department_id==$department->id)?"selected":"" ?> value="{{$department->id}}">{{$department->name}}</option>
                        @endforeach
                    </select>
                </td>

                <td>
                    <select class="form-control assigned_to" id="assigned_to{{$key}}"  name="addmore[{{$key}}][labour]" required="">
                                    <option value="">{{ __('Select Labour') }}</option>
                                </select>
                </td>
                <td><input type="text" name="addmore[{{$key}}][price]" id="price" placeholder="Enter Price" value="{{$val->price}}" onkeyup="calculate(this)" class="form-control" required /></td>
                <td><input type="text" name="addmore[{{$key}}][days]" id="days" placeholder="Enter Days"  onkeyup="calculate(this)"  value="{{$val->hours}}" class="form-control" required/></td>
                <td><input type="text" name="addmore[{{$key}}][subtotal]" id="subtotal" value="{{$val->subtotal}}" placeholder="" class="form-control" readonly/></td>

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
        // $("#dynamicTable").append('<tr><td><input type="text" name="addmore['+i+'][worker_name]" placeholder="Enter Name" class="form-control" required /></td><td><input type="text" name="addmore['+i+'][worker_phone]" placeholder="Enter your Qty" class="form-control" required/></td><td><input type="text" name="addmore['+i+'][price]" placeholder="Enter your Price" class="form-control" required /></td><td><button type="button" class="btn btn-danger remove-tr">Remove</button></td></tr>');

        $("#dynamicTable").append('<tr><td><select class="form-control category" name="addmore['+i+'][department_id]" onchange="categoryChange(this,\'\');" id="category" required=""><option value="">{{ __('Select Department') }}</option>@foreach($departments as $department)<option value="{{$department->id}}">{{$department->name}}</option>@endforeach</select></td><td><select class="form-control assigned_to" id="assigned_to"  name="addmore['+i+'][labour]" required=""><option value="">{{ __('Select Labour') }}</option></select></td><td><input type="text" name="addmore['+i+'][price]" id="price"  onkeyup="calculate(this)"  value="0" placeholder="Enter your Price" class="form-control" required/></td><td><input type="text" name="addmore['+i+'][days]" id="days"  onkeyup="calculate(this)"  value="0" placeholder="Enter Days" class="form-control" required/></td><td><input type="text" name="addmore['+i+'][subtotal]" id="subtotal" readonly value="0" placeholder="" class="form-control" required/></td><td><button type="button" class="btn btn-danger remove-tr">Remove</button></td></tr>');

        $('.category').each(function() {
              $(this).select2({
                dropdownParent: $(this).parent(), // fix select2 search input focus bug
              })
            })
            $('.assigned_to').each(function() {
              $(this).select2({
                dropdownParent: $(this).parent(), // fix select2 search input focus bug
              });
             
            });
    });


    $(document).on('click', '.remove-tr', function(){
         $(this).parents('tr').remove();
    });

    $(document).ready(function(){
        selectoption();
        //$("#project_id").val({{$projectworkerrequest->milestone_id}});
        $("#project_id").trigger('change');
        
        // $('.category').each(function(){
            
        //     categoryChange(this,$(this).parent().parent().find('.category').attr('data-labour'))
        //     //categoryChange(this);
        // });
        
    });

    function calculate(objVal){
        var price = $(objVal).parent().parent().find('#price').val();
        var days = $(objVal).parent().parent().find('#days').val();
        $(objVal).parent().parent().find('#subtotal').val(price*days);
    }

    function selectProject(obj,milestone_id){
            var id = obj.value;
            $("#milestone_id").html('');
            $.ajax({
                url: "{{route('milestone.fetch')}}",
                type: "POST",
                data: {
                    id: id,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function (result) {
                    // $('#assigned_to').html('<option value="">Select Staff</option>');
                    // $.each(result.agents, function (key, value) {
                    //     $("#assigned_to").append('<option value="' + key + '">' + value + '</option>');
                    // });

                    

                    $("#milestone_id").html('<option value="">Select Milestone</option>');
                    $.each(result.agents, function (key, value) {
                        if(milestone_id!='')
                        {
                            if(milestone_id==key)
                            {
                                
                                selectClass='selected="selected"';
                            }
                        }
                        $("#milestone_id").append('<option '+selectClass+' value="' + key + '">' + value + '</option>');
                        $('#milestone_id').trigger('change');
                        selectMilestone($('#milestone_id'),milestone_id)
                    });
                }
            });
        }

        function selectMilestone(obj,task_id){
            var id = obj.value;
            $("#task_id").html('');
            $.ajax({
                url: "{{route('task.fetch')}}",
                type: "POST",
                data: {
                    id: id,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function (result) {
                    // $('#assigned_to').html('<option value="">Select Staff</option>');
                    // $.each(result.agents, function (key, value) {
                    //     $("#assigned_to").append('<option value="' + key + '">' + value + '</option>');
                    // });

                    $("#task_id").html('<option value="">Select Task</option>');
                    $.each(result.agents, function (key, value) {
                        if(task_id!='')
                        {
                            if(task_id==key)
                            {
                                
                                selectClass='selected="selected"';
                            }
                        }
                        $("#task_id").append('<option '+selectClass+' value="' + key + '">' + value + '</option>');
                    });
                }
            });
        }
    function categoryChange(obj,worker_id)
    {
        
        var id = obj.value;
        
        $(obj).parent().parent().find('.assigned_to').html('');
        $.ajax({
            url: "{{route('department.fetch')}}",
            type: "POST",
            data: {
                id: id,
                _token: '{{csrf_token()}}'
            },
            dataType: 'json',
            success: function (result) {
                // $('.assigned_to').html('<option value="">Select Staff</option>');
                // $.each(result.agents, function (key, value) {
                //     $(".assigned_to").append('<option value="' + key + '">' + value + '</option>');
                // });
                
                $(obj).parent().parent().find('.assigned_to').html('<option value="">Select Staff</option>');
                $.each(result.agents, function (key, value) {
                    var selectClass='';
                     
                    
                    if(worker_id!='')
                    {
                        if(worker_id==key)
                        {
                            
                            selectClass='selected="selected"';
                        }
                    }
                    
                    $(obj).parent().parent().find('.assigned_to').append('<option '+selectClass+' value="' + key + '">' + value + '</option>');
                });
                
            }
        });
    }
    function selectoption()
        {    
                    
            $('.category').each(function() {
              $(this).select2({
                dropdownParent: $(this).parent(), // fix select2 search input focus bug
              })
              categoryChange(this,$(this).parent().parent().find('.category').attr('data-labour'));
            })
            $('.assigned_to').each(function() {
              $(this).select2({
                dropdownParent: $(this).parent(), // fix select2 search input focus bug
              });
             
            });
        }

</script>
