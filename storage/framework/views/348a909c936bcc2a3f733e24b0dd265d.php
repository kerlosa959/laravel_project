
<?php echo e(Form::model($lead, array('route' => array('leads.discussion.store', $lead->id), 'method' => 'POST'))); ?>

<div class="modal-body">
    <div class="row">
        <div class="col-12 form-group">
            <?php echo e(Form::label('comment', __('Message'),['class'=>'form-label'])); ?>

            <?php echo e(Form::textarea('comment', null, array('class' => 'form-control'))); ?>

        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="<?php echo e(__('Create')); ?>" class="btn  btn-primary">
</div>
<?php echo e(Form::close()); ?>


<?php /**PATH /home/u188192483/domains/techzone.so/public_html/aldaar/resources/views/leads/discussions.blade.php ENDPATH**/ ?>