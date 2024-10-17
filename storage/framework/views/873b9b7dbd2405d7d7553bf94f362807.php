<div class="col-xl-12">
    <div class="card">
        <div class="card-body table-border-style">
            <div class="table-responsive">
                <table class="table datatable">
                    <thead>
                    <tr>
                        <th><?php echo e(__('Request No')); ?></th>
                        <th><?php echo e(__('Project')); ?></th>
                        <th><?php echo e(__('Required labours')); ?></th>
                        <th><?php echo e(__('Total Price')); ?></th>
                        
                        <th><?php echo e(__('Status')); ?></th>
                        <th><?php echo e(__('Requested Date')); ?></th>
                        <?php if(\Auth::user()->type!='company'): ?>
                        <th><?php echo e(__('Requested By')); ?></th>
                        <?php endif; ?>

                        <th class="text-end"><?php echo e(__('Action')); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(isset($projects) && !empty($projects) && count($projects) > 0): ?>
                        <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="javascript:void(0)" class="name mb-0 h6 text-sm"><?php echo e(@$project->request_id); ?></a>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        
                                        <a href="javascript:void(0)" class="name mb-0 h6 text-sm"><?php echo e(@$project->project->project_name); ?></a>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="javascript:void(0)" class="name mb-0 h6 text-sm"><?php echo e(@$project->total_workers); ?></a>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="javascript:void(0)" class="name mb-0 h6 text-sm"><?php echo e(@$project->total_price); ?></a>
                                    </div>
                                </td>
                               
                                <td>
                                    <span class="badge bg-<?php echo e(\App\Models\ProjectWorkerRequest::$status_color[@$project->status]); ?> p-2 px-3 rounded"><?php echo e(__(\App\Models\ProjectWorkerRequest::$project_worker_request_status[@$project->status])); ?></span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="javascript:void(0)" class="name mb-0 h6 text-sm">  <?php echo e(Utility::getDateFormated(@$project->created_at)); ?>

                                        </a>
                                    </div>
                                </td>
                                <?php if(\Auth::user()->type!='company'): ?>
                                <td class="text-end">
                                    <div class="d-flex align-items-center">
                                        <a href="javascript:void(0)" class="name mb-0 h6 text-sm"><?php echo e(@$project->requestedBy->name); ?></a>
                                    </div>
                                </td>
                                <?php endif; ?>

                                <td class="text-end">
                                    <span>

                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit labour request')): ?>
                                            <div class="action-btn bg-info ms-2">
                                                <a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center" data-url="<?php echo e(route('projectlabours.show',$project->id)); ?>" data-ajax-popup="true" data-size="lg" data-bs-toggle="tooltip" title="<?php echo e(__('Show')); ?>" data-title="<?php echo e(__('Show Request')); ?>">
                                                    <i class="ti ti-eye text-white"></i>
                                                </a>
                                            </div>
                                        <?php endif; ?>

                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit labour request')): ?>
                                            <?php if($project->status==1 && (\Auth::user()->type=='Supervisor' || \Auth::user()->type=='Site Engineer') ): ?>
                                                <div class="action-btn bg-info ms-2">
                                                    <a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center" data-url="<?php echo e(URL::to('projectlabours/'.$project->id.'/edit')); ?>" data-ajax-popup="true" data-size="xl" data-bs-toggle="tooltip" title="<?php echo e(__('Edit')); ?>" data-title="<?php echo e(__('Edit Request')); ?>">
                                                        <i class="ti ti-pencil text-white"></i>
                                                    </a>
                                                </div>
                                            <?php endif; ?>
                                        <?php endif; ?>

                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete labour request')): ?>
                                        <?php if($project->status==1 &&  \Auth::user()->type=='Supervisor'): ?>
                                            <div class="action-btn bg-danger ms-2">
                                                    <?php echo Form::open(['method' => 'DELETE', 'route' => ['projectlabours.destroy', @$project->id]]); ?>

                                                    <a href="#" class="mx-3 btn btn-sm  align-items-center bs-pass-para" data-bs-toggle="tooltip" title="<?php echo e(__('Delete')); ?>"><i class="ti ti-trash text-white"></i></a>
                                                    <?php echo Form::close(); ?>

                                                </div>
                                        <?php endif; ?>
                                        <?php endif; ?>

                                        <?php if(\Auth::user()->type=='company'): ?>
                                        <?php endif; ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <tr>
                            <th scope="col" colspan="7"><h6 class="text-center"><?php echo e(__('No Record Found.')); ?></h6></th>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php /**PATH /home/u188192483/domains/techzone.so/public_html/aldaar/resources/views/projectworkerrequest/list.blade.php ENDPATH**/ ?>