<?php echo e(Form::model($projectworkerrequest, ['route' => ['projectmaterial.materialUpdateStatus', $projectworkerrequest->id],'id'=>"updateStatus-form", 'method' => 'PPOST', 'enctype' => 'multipart/form-data'])); ?>

<div class="modal-body">
    

    
    <div class="text-end">
        &nbsp;
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                <b> Project </b>: <?php echo e($projectworkerrequest->project->project_name); ?>

            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                <b> Site Location </b>: <?php echo e($projectworkerrequest->site_location); ?>

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
                            <td><?php echo e($val->product->name); ?></td>
                            <!-- <td><?php echo e($val->item_type); ?></td> -->
                            <td><?php echo e($val->qty); ?></td>
                            <td><?php echo e($val->specification); ?></td>
                            <td><?php echo e($val->preferences); ?></td>
                            <td><?php echo e($val->required_duration); ?></td>
                            <td><?php echo e($val->priority); ?></td>
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
    <!-- <?php if( \Auth::user()->type=='company' && $projectworkerrequest->status==1): ?>
        <input type="submit" id="accept"  name="accept" value="<?php echo e(__('Accept')); ?>" class="btn  btn-primary">
        <input type="submit" id="reject" name="reject" value="<?php echo e(__('Reject')); ?>" class="btn  btn-primary">
    <?php endif; ?> -->
    
    <?php if( $projectworkerrequest->status==1 ||  $projectworkerrequest->status==4 ||  $projectworkerrequest->status==6 ): ?>
        <?php if( \Auth::user()->type=='Accountant'  && is_null( $projectworkerrequest->logistic_status) ): ?>
            <input type="submit" id="send_to_manager"  name="send_to_manager" value="<?php echo e(__('Approve and Send To Logistics')); ?>" class="btn  btn-primary">
        <?php endif; ?>
        <?php if( \Auth::user()->type=='Logistics'  && is_null( $projectworkerrequest->manager_id) ): ?>
            <input type="submit" id="send_to_manager"  name="send_to_manager" value="<?php echo e(__('Approve and Send To Manager')); ?>" class="btn  btn-primary">
        <?php endif; ?>

       
        
        <?php if( \Auth::user()->can('reject labour request')  && ((\Auth::user()->type=='Accountant' && is_null( $projectworkerrequest->manager_id) || (\Auth::user()->type=='Manager' && ($projectworkerrequest->status==1 || $projectworkerrequest->status==4 ||  $projectworkerrequest->status==6 )))) ): ?>
            <input type="submit" id="reject" name="reject" value="<?php echo e(__('Reject')); ?>" class="btn  btn-primary">
        <?php endif; ?>
    <?php endif; ?>

    <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn  btn-light" data-bs-dismiss="modal">
</div>
<?php echo e(Form::close()); ?>

<script type="text/javascript">
    $("#accept,#reject").click(function(e){
        if (confirm('Are you sure you want to continue?')) {
            $('#updateStatus-form').submit();
        }
    });

    var i = <?php echo e(count($projectworkerrequest->workers)-1); ?>;
    
</script>
<?php /**PATH /home/u188192483/domains/techzone.so/public_html/aldaar/resources/views/projectmaterialrequest/view.blade.php ENDPATH**/ ?>