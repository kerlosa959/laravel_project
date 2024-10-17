<?php echo e(Form::model($projectworkerrequest, ['route' => ['projectmaterials.update', $projectworkerrequest->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data'])); ?>

<div class="modal-body">
    

    
    <div class="text-end">
        &nbsp;
    </div>
    <div class="row">
        <div class="col-sm-6 col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('project_id', __('Project'),['class'=>'form-label'])); ?><span class="text-danger">*</span>
                <?php echo Form::select('project_id', $projects, $projectworkerrequest->project_id,array('class' => 'form-control','required'=>'required')); ?>

            </div>
        </div>
        <div class="col-sm-6 col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('site_location', __('Site Location'),['class'=>'form-label'])); ?><span class="text-danger">*</span>
                <?php echo e(Form::text('site_location', $projectworkerrequest->site_location, ['class' => 'form-control','required'=>'required'])); ?>

            </div>
        </div>

    </div>
    
    <div class="row">
        <div class="form-group">
            <?php echo e(Form::label('materials', __('Add Material/Equipment'),['class'=>'form-label'])); ?><span class="text-danger">*</span>

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
                    <select class="form-control category" name="addmore[<?php echo e($key); ?>][item_name]"  id="item_name<?php echo e($key); ?>" required="">
                        <option value=""><?php echo e(__('Select Material')); ?></option>
                        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option <?= ($val->item_name==$product->id)?"selected":"" ?> value="<?php echo e($product->id); ?>"><?php echo e($product->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </td>
                <!-- <td><input type="text" name="addmore[<?php echo e($key); ?>][item_name]" value="<?php echo e($val->item_name); ?>" placeholder="Enter Name" class="form-control" required/></td>

                <td><input type="text" name="addmore[<?php echo e($key); ?>][item_type]" value="<?php echo e($val->item_type); ?>" placeholder="Enter Item Type" class="form-control" required/></td> -->

                <td><input type="text" name="addmore[<?php echo e($key); ?>][qty]" value="<?php echo e($val->qty); ?>" placeholder="Enter Qty" class="form-control" required /></td>

                <td><input type="text" name="addmore[<?php echo e($key); ?>][specification]" value="<?php echo e($val->specification); ?>" placeholder="Enter Specification" class="form-control" required /></td>
                <td><input type="text" name="addmore[<?php echo e($key); ?>][preferences]" value="<?php echo e($val->preferences); ?>" placeholder="Enter Preferences" class="form-control" required /></td>
                <td><input type="text" name="addmore[<?php echo e($key); ?>][required_duration]" value="<?php echo e($val->required_duration); ?>" placeholder="Enter Duration" class="form-control" required /></td>
                <!-- <td><input type="text" name="addmore[<?php echo e($key); ?>][priority]" value="<?php echo e($val->priority); ?>" placeholder="Enter Priority" class="form-control" required /></td> -->
                <td><select name="addmore[<?php echo e($key); ?>][priority]" class="form-control" required ><option <?php echo e(($val->priority=="Low")?"selected":""); ?> value="Low">Low</option><option <?php echo e(($val->priority=="Medium")?"selected":""); ?> value="Medium">Medium</option><option <?php echo e(($val->priority=="High")?"selected":""); ?> value="High">High</option></select></td>


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
    <input type="hidden" name='id' value="<?php echo e($projectworkerrequest->id); ?>" >
    <input type="submit" value="<?php echo e(__('Update')); ?>" class="btn  btn-primary">
    <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn  btn-light" data-bs-dismiss="modal">
</div>
<?php echo e(Form::close()); ?>

<script type="text/javascript">
    var i = <?php echo e(count($projectworkerrequest->workers)-1); ?>;
    $("#add").click(function(){
        ++i;
        $("#dynamicTable").append('<tr><td><select class="form-control" name="addmore['+i+'][item_name]" id="item_name" required=""><option value=""><?php echo e(__('Select Material')); ?></option><?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($product->id); ?>"><?php echo e($product->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></td><td><input type="text" name="addmore['+i+'][qty]" placeholder="Enter Qty" class="form-control" required/></td><td><input type="text" name="addmore['+i+'][specification]" placeholder="Enter Specification" class="form-control" required/></td><td><input type="text" name="addmore['+i+'][preferences]" placeholder="Enter Preferences" class="form-control" required/></td><td><input type="text" name="addmore['+i+'][required_duration]" placeholder="Enter Duration" class="form-control" required/></td><td><select name="addmore['+i+'][priority]" class="form-control" required ><option value="Low">Low</option><option value="Medium">Medium</option><option value="High">High</option></select></td><td><button type="button" class="btn btn-danger remove-tr">Remove</button></td></tr>');

        /* $("#dynamicTable").append('<tr><td><input type="text" name="addmore['+i+'][item_name]" placeholder="Enter Name" class="form-control" required/></td><td><input type="text" name="addmore['+i+'][item_type]" placeholder="Enter Item Type" class="form-control" required/></td><td><input type="text" name="addmore['+i+'][qty]" placeholder="Enter Qty" class="form-control" required/></td><td><input type="text" name="addmore['+i+'][specification]" placeholder="Enter Specification" class="form-control" required/></td><td><input type="text" name="addmore['+i+'][preferences]" placeholder="Enter Preferences" class="form-control" required/></td><td><input type="text" name="addmore['+i+'][required_duration]" placeholder="Enter Duration" class="form-control" required/></td><td><select name="addmore['+i+'][priority]" class="form-control" required ><option value="Low">Low</option><option value="Medium">Medium</option><option value="High">High</option></select></td><td><button type="button" class="btn btn-danger remove-tr">Remove</button></td></tr>'); */
    });
    $(document).on('click', '.remove-tr', function(){
         $(this).parents('tr').remove();
    });
</script>
<?php /**PATH /home/u188192483/domains/techzone.so/public_html/aldaar/resources/views/projectmaterialrequest/edit.blade.php ENDPATH**/ ?>