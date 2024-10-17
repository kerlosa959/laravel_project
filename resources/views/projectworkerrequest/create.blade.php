{{ Form::open(['url' => 'projectlabours', 'method' => 'post','enctype' => 'multipart/form-data']) }}
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
                {!! Form::select('project_id', $projects, null,array('class' => 'form-control','onchange'=>"selectProject(this);",'required'=>'required')) !!}
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-sm-6 col-md-6">
            <div class="form-group">
                {{ Form::label('milestone_id', __('Milestones'),['class'=>'form-label']) }}
                {!! Form::select('milestone_id', [], null,array('class' => 'form-control','onchange'=>"selectMilestone(this);")) !!}
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
                {{ Form::date('start_date', null, ['class' => 'form-control']) }}
            </div>
        </div>
        <div class="col-sm-6 col-md-6">
            <div class="form-group">
                {{ Form::label('end_date', __('To'), ['class' => 'form-label']) }}
                {{ Form::date('end_date', null, ['class' => 'form-control']) }}
            </div>
        </div>
    </div> -->
    <div class="row">
        <div class="form-group">
            {{ Form::label('labours', __('Add Labours'),['class'=>'form-label']) }}<span class="text-danger">*</span>
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

                <tr>
                    <td>
                        <select class="form-control category" name="addmore[0][department_id]" onchange="categoryChange(this);" id="category" required="">
                            <option value="">{{ __('Select Department') }}</option>
                            @foreach($departments as $department)
                                <option value="{{$department->id}}">{{$department->name}}</option>
                            @endforeach
                        </select>
                    </td>
                   
                    <td>
                        <select class="form-control assigned_to" id="assigned_to"  name="addmore[0][labour]" required="">
                                        <option value="">{{ __('Select Labour') }}</option>
                                    </select>
                    </td>
                    <td><input type="text" name="addmore[0][price]" id="price" placeholder="Enter Price" value="0" onkeyup="calculate(this)" class="form-control" required /></td>
                    <td><input type="text" name="addmore[0][days]" id="days" placeholder="Enter Days"  onkeyup="calculate(this)"  value="0" class="form-control" required/></td>
                    <td><input type="text" name="addmore[0][subtotal]" id="subtotal" value="0" placeholder="" class="form-control" readonly/></td>
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
        // $("#dynamicTable").append('<tr><td><input type="text" name="addmore['+i+'][worker_name]" placeholder="Enter Name" class="form-control" required/></td><td><input type="text" name="addmore['+i+'][worker_phone]" placeholder="Enter your Qty" class="form-control" required/></td><td><input type="text" name="addmore['+i+'][price]" placeholder="Enter your Price" class="form-control" required/></td><td><button type="button" class="btn btn-danger remove-tr">Remove</button></td></tr>');

          $("#dynamicTable").append('<tr><td><select class="form-control category" name="addmore['+i+'][department_id]" onchange="categoryChange(this);" id="category" required=""><option value="">{{ __('Select Department') }}</option>@foreach($departments as $department)<option value="{{$department->id}}">{{$department->name}}</option>@endforeach</select></td><td><select class="form-control assigned_to" id="assigned_to"  name="addmore['+i+'][labour]" required=""><option value="">{{ __('Select Labour') }}</option></select></td><td><input type="text" name="addmore['+i+'][price]" id="price"  onkeyup="calculate(this)"  value="0" placeholder="Enter your Price" class="form-control" required/></td><td><input type="text" name="addmore['+i+'][days]" id="days"  onkeyup="calculate(this)"  value="0" placeholder="Enter Days" class="form-control" required/></td><td><input type="text" name="addmore['+i+'][subtotal]" id="subtotal"  value="0" placeholder="" class="form-control" required/></td><td><button type="button" class="btn btn-danger remove-tr">Remove</button></td></tr>');

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
      
        
    });

   // $(document).ready(function () {

    function calculate(objVal){
        var price = $(objVal).parent().parent().find('#price').val();
        var days = $(objVal).parent().parent().find('#days').val();
        $(objVal).parent().parent().find('#subtotal').val(price*days);
    }

    function selectProject(obj){
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
                        $("#milestone_id").append('<option value="' + key + '">' + value + '</option>');
                    });
                }
            });
        }

        function selectMilestone(obj){
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
                        $("#task_id").append('<option value="' + key + '">' + value + '</option>');
                    });
                }
            });
        }

        function categoryChange(obj){
            var id = obj.value;
            $(obj).parent().parent().find('#assigned_to').html('');
            $.ajax({
                url: "{{route('department.fetch')}}",
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

                    $(obj).parent().parent().find('#assigned_to').html('<option value="">Select Staff</option>');
                    $.each(result.agents, function (key, value) {
                        $(obj).parent().parent().find('#assigned_to').append('<option value="' + key + '">' + value + '</option>');
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
       // }

    // $('#category').on('change', function () {
            
    //     });
</script>
