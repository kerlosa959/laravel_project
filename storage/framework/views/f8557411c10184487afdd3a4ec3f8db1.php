<?php echo e(Form::open(array('route' => array('task.bug.store',$project_id)))); ?>

<div class="modal-body">
    
    <?php
                            $user = \App\Models\User::find(\Auth::user()->creatorId());
                    $plan= \App\Models\Plan::getPlan($user->plan);
    ?>
    <?php if($plan->chatgpt == 1): ?>
    <div class="text-end">
        <a href="#" data-size="md" class="btn  btn-primary btn-icon btn-sm" data-ajax-popup-over="true" data-url="<?php echo e(route('generate',['project bug'])); ?>"
           data-bs-placement="top" data-title="<?php echo e(__('Generate content with AI')); ?>">
            <i class="fas fa-robot"></i> <span><?php echo e(__('Generate with AI')); ?></span>
        </a>
    </div>
    <?php endif; ?>
    
    <div class="row">
        <div class="form-group col-md-6">
            <?php echo e(Form::label('title', __('Title'),['class'=>'form-label'])); ?>

            <?php echo e(Form::text('title', '', array('class' => 'form-control','required'=>'required'))); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('priority', __('Priority'),['class'=>'form-label'])); ?>

            <?php echo Form::select('priority', $priority, null,array('class' => 'form-control select','required'=>'required')); ?>

        </div>
        <div class="form-group  col-md-6">
            <?php echo e(Form::label('start_date', __('Start Date'),['class'=>'form-label'])); ?>

            <?php echo e(Form::date('start_date', '', array('class' => 'form-control','required'=>'required'))); ?>

        </div>
        <div class="form-group  col-md-6">
            <?php echo e(Form::label('due_date', __('Due Date'),['class'=>'form-label'])); ?>

            <?php echo e(Form::date('due_date', '', array('class' => 'form-control','required'=>'required'))); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('status', __('Bug Status'),['class'=>'form-label'])); ?>

            <?php echo Form::select('status', $status, null,array('class' => 'form-control select','required'=>'required')); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('assign_to', __('Assigned To'),['class'=>'form-label'])); ?>

            <?php echo e(Form::select('assign_to', $users, null,array('class' => 'form-control select','required'=>'required'))); ?>

        </div>
    </div>
    <div class="row">
        <div class="form-group  col-md-12">
            <?php echo e(Form::label('description', __('Description'),['class'=>'form-label'])); ?>

            <?php echo Form::textarea('description', null, ['class'=>'form-control','rows'=>'2']); ?>

        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="<?php echo e(__('Create')); ?>" class="btn  btn-primary">
</div>
<?php echo e(Form::close()); ?>

<?php /**PATH /home/u188192483/domains/techzone.so/public_html/aldaar/resources/views/projects/bugCreate.blade.php ENDPATH**/ ?>