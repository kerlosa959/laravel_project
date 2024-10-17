<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Labour Department')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Labour Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Labour Department')); ?></li>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('action-btn'); ?>
    <div class="float-end">
    
            <a href="#" data-url="<?php echo e(route('labour-department.create')); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Create New Department')); ?>" data-bs-toggle="tooltip" title="<?php echo e(__('Create')); ?>"  class="btn btn-sm btn-primary">
                <i class="ti ti-plus"></i>
            </a>

    
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        
        <div class="col-12">
            <div class="card">
            <div class="card-body table-border-style">
                    <div class="table-responsive">
                    <table class="table datatable">
                            <thead>
                            <tr>
                                <!-- <th><?php echo e(__('Branch')); ?></th> -->
                                <th><?php echo e(__('Department')); ?></th>
                                <th width="200px"><?php echo e(__('Action')); ?></th>
                            </tr>
                            </thead>
                            <tbody class="font-style">
                            <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <!-- <td><?php echo e(!empty($department->branch)?$department->branch->name:''); ?></td> -->
                                    <td><?php echo e($department->name); ?></td>

                                    <td class="Action">
                                        <span>
                                            
                                            <div class="action-btn bg-primary ms-2">

                                                <a href="#" data-url="<?php echo e(URL::to('labour-department/'.$department->id.'/edit')); ?>"  data-ajax-popup="true" data-title="<?php echo e(__('Edit Department')); ?>" class="mx-3 btn btn-sm d-inline-flex align-items-center" data-bs-toggle="tooltip" title="<?php echo e(__('Edit')); ?>" data-original-title="<?php echo e(__('Edit')); ?>">
                                                    <i class="ti ti-pencil text-white"></i></a>
                                            </div>
                                                
                                                    <div class="action-btn bg-danger ms-2">
                                                        <?php echo Form::open(['method' => 'DELETE', 'route' => ['labour-department.destroy', $department->id],'id'=>'delete-form-'.$department->id]); ?>



                                                <a href="#" class="mx-3 btn btn-sm  align-items-center bs-pass-para" data-bs-toggle="tooltip" title="<?php echo e(__('Delete')); ?>" data-original-title="<?php echo e(__('Delete')); ?>" data-confirm="<?php echo e(__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')); ?>" data-confirm-yes="document.getElementById('delete-form-<?php echo e($department->id); ?>').submit();"><i class="ti ti-trash text-white"></i></a>
                                                <?php echo Form::close(); ?>

                                                    </div>
                                            
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u188192483/domains/techzone.so/public_html/aldaar/resources/views/labour_department/index.blade.php ENDPATH**/ ?>