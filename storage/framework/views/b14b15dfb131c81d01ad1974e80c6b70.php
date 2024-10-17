<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Budget Vs Actual')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('budget.index')); ?>"><?php echo e(__('Budget Planner')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e($budget->name); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('script-page'); ?>
    <script src="<?php echo e(asset('js/jquery-ui.min.js')); ?>"></script>
    <script>
        //Income Total
        $(document).on('keyup', '.income_data', function () {
            //category wise total
            var el = $(this).parent().parent();
            var inputs = $(el.find('.income_data'));

            var totalincome = 0;
            for (var i = 0; i < inputs.length; i++) {
                var price = $(inputs[i]).val();
                totalincome = parseFloat(totalincome) + parseFloat(price);
            }
            el.find('.totalIncome').html(totalincome);

            // month wise total //
            var month_income = $(this).data('month');
            var month_inputs = $(el.parent().find('.' + month_income + '_income'));
            var month_totalincome = 0;
            for (var i = 0; i < month_inputs.length; i++) {
                var month_price = $(month_inputs[i]).val();
                month_totalincome = parseFloat(month_totalincome) + parseFloat(month_price);
            }
            var month_total_income = month_income + '_total_income';
            el.parent().find('.' + month_total_income).html(month_totalincome);

            //all total //
            var total_inputs = $(el.parent().find('.totalIncome'));
            console.log(total_inputs)
            var income = 0;
            for (var i = 0; i < total_inputs.length; i++) {
                var price = $(total_inputs[i]).html();
                income = parseFloat(income) + parseFloat(price);
            }
            el.parent().find('.income').html(income);

        })


        //Expense Total
        $(document).on('keyup', '.expense_data', function () {
            //category wise total
            var el = $(this).parent().parent();
            var inputs = $(el.find('.expense_data'));

            var totalexpense = 0;
            for (var i = 0; i < inputs.length; i++) {
                var price = $(inputs[i]).val();
                totalexpense = parseFloat(totalexpense) + parseFloat(price);
            }
            el.find('.totalExpense').html(totalexpense);

            // month wise total //
            var month_expense = $(this).data('month');
            var month_inputs = $(el.parent().find('.' + month_expense + '_expense'));
            var month_totalexpense = 0;
            for (var i = 0; i < month_inputs.length; i++) {
                var month_price = $(month_inputs[i]).val();
                month_totalexpense = parseFloat(month_totalexpense) + parseFloat(month_price);
            }
            var month_total_expense = month_expense + '_total_expense';
            el.parent().find('.' + month_total_expense).html(month_totalexpense);

            //all total //
            var total_inputs = $(el.parent().find('.totalExpense'));
            console.log(total_inputs)
            var expense = 0;
            for (var i = 0; i < total_inputs.length; i++) {
                var price = $(total_inputs[i]).html();
                expense = parseFloat(expense) + parseFloat(price);
            }
            el.parent().find('.expense').html(expense);

        })

        //Hide & Show
        $(document).on('change', '.period', function () {
            var period = $(this).val();

            $('.budget_plan').removeClass('d-block');
            $('.budget_plan').addClass('d-none');
            $('#' + period).removeClass('d-none');
            $('#' + period).addClass('d-block');
        });

        // trigger
        $('.period').trigger('change');

    </script>
<?php $__env->stopPush(); ?>


<?php $__env->startSection('content'); ?>
    <div class="col-12 mt-4">
        <div class="card p-4 mb-4">
            <h6 class="report-text mb-0 text-center"><?php echo e(__('Year :')); ?> <?php echo e($budget->from); ?></h6>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body" style="overflow-x: auto">


                    
                    <?php if($budget->period == 'monthly'): ?>
                        <table class="table table-bordered table-item data">
                            <thead>
                            <tr>
                                <td rowspan="2"></td>
                                <?php $__currentLoopData = $monthList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <th colspan="3" scope="colgroup" class="text-center br-1px"><?php echo e($month); ?></th>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tr>
                            <tr>
                                <?php $__currentLoopData = $monthList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <th scope="col" class="br-1px">Budget</th>
                                    <th scope="col" class="br-1px">Actual</th>
                                    <th scope="col" class="br-1px">Over Budget</th>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tr>
                            </thead>
                            <!----INCOME Category ---------------------->

                            <tr>
                                <th colspan="37" class="text-dark light_blue"><span><?php echo e(__('Income :')); ?></span></th>
                            </tr>

                            <?php
                                $overBudgetTotal=[];
                            ?>

                            <?php $__currentLoopData = $incomeproduct; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $productService): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="text-dark"><?php echo e($productService->name); ?></td>
                                    <?php $__currentLoopData = $monthList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $budgetAmount= ($budget['income_data'][$productService->id][$month])?$budget['income_data'][$productService->id][$month]:0;
                                            $actualAmount=$incomeArr[$productService->id][$month];
                                            $overBudgetAmount=$actualAmount-$budgetAmount;
                                            $overBudgetTotal[$productService->id][$month]=$overBudgetAmount;
                                        ?>
                                        <td class="income_data <?php echo e($month); ?>_income"><?php echo e(!empty (\Auth::user()->priceFormat($budget['income_data'][$productService->id][$month]))?\Auth::user()->priceFormat($budget['income_data'][$productService->id][$month]):0); ?></td>
                                        <td><?php echo e(\Auth::user()->priceFormat($incomeArr[$productService->id][$month])); ?>

                                            <p><?php echo e(($budget['income_data'][$productService->id][$month] !=0)? (\App\Models\Budget::percentage($budget['income_data'][$productService->id][$month],$incomeArr[$productService->id][$month])!=0) ? '('.(\App\Models\Budget::percentage($budget['income_data'][$productService->id][$month],$incomeArr[$productService->id][$month]).'%)') :'':''); ?></p>
                                        </td>
                                        <td><?php echo e(\Auth::user()->priceFormat($overBudgetAmount)); ?>

                                            <p class="<?php echo e(($budget['income_data'][$productService->id][$month] < $overBudgetAmount)? 'green-text':''); ?> <?php echo e(($budget['income_data'][$productService->id][$month] > $overBudgetAmount)? 'red-text':''); ?>" ><?php echo e(($budget['income_data'][$productService->id][$month] !=0)? (\App\Models\Budget::percentage($budget['income_data'][$productService->id][$month],$overBudgetAmount) !=0) ?'('.(\App\Models\Budget::percentage($budget['income_data'][$productService->id][$month],$overBudgetAmount).'%)') :'':''); ?></p>

                                        </td>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            <?php
                                $overBudgetTotalArr = array();
                                  foreach($overBudgetTotal as $overBudget)
                                  {
                                      foreach($overBudget as $k => $value)
                                      {
                                          $overBudgetTotalArr[$k] = (isset($overBudgetTotalArr[$k]) ? $overBudgetTotalArr[$k] + $value : $value);
                                      }
                                  }
                            ?>
                            <tr class="total">
                                <td class="text-dark"><span></span><strong><?php echo e(__('Total :')); ?></strong></td>
                                <?php if(!empty($budgetTotal) ): ?>
                                    <?php $__currentLoopData = $monthList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                        <td class="text-dark <?php echo e($month); ?>_total_income"><strong><?php echo e(\Auth::user()->priceFormat($budgetTotal[$month])); ?></strong></td>
                                        <td class="text-dark"><strong><?php echo e(\Auth::user()->priceFormat($incomeTotalArr[$month])); ?></strong>
                                            <p><?php echo e(($budgetTotal[$month] !=0)? (\App\Models\Budget::percentage($budgetTotal[$month],$incomeTotalArr[$month])!=0) ? '('.(\App\Models\Budget::percentage($budgetTotal[$month],$incomeTotalArr[$month]).'%)') :'':''); ?></p>

                                        </td>
                                        <td class="text-dark"><strong><?php echo e(\Auth::user()->priceFormat($overBudgetTotalArr[$month])); ?></strong>
                                            <p class="<?php echo e(($budgetTotal[$month] < $overBudgetAmount)? 'green-text':''); ?> <?php echo e(($budgetTotal[$month] > $overBudgetAmount)? 'red-text':''); ?>"><?php echo e(($budgetTotal[$month] !=0)? (\App\Models\Budget::percentage($budgetTotal[$month],$overBudgetTotalArr[$month])!=0) ?'('.(\App\Models\Budget::percentage($budgetTotal[$month],$overBudgetTotalArr[$month]).'%)') :'':''); ?></p>

                                        </td>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>

                            </tr>


                            <!------------ EXPENSE Category ---------------------->

                            <tr>
                                <th colspan="37" class="text-dark light_blue"><span><?php echo e(__('Expense :')); ?></span></th>
                            </tr>
                            <?php
                                $overExpenseBudgetTotal=[];
                            ?>

                            <?php $__currentLoopData = $expenseproduct; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $productService): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="text-dark"><?php echo e($productService->name); ?></td>
                                    <?php $__currentLoopData = $monthList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $budgetAmount= ($budget['expense_data'][$productService->id][$month])?$budget['expense_data'][$productService->id][$month]:0;
                                            $actualAmount=$expenseArr[$productService->id][$month];
                                            $overBudgetAmount=$actualAmount-$budgetAmount;
                                            $overExpenseBudgetTotal[$productService->id][$month]=$overBudgetAmount;
                                        ?>
                                        <td class="expense_data <?php echo e($month); ?>_expense"><?php echo e(\Auth::user()->priceFormat(!empty($budget['expense_data'][$productService->id][$month]))?\Auth::user()->priceFormat($budget['expense_data'][$productService->id][$month]):0); ?></td>
                                        <td><?php echo e(\Auth::user()->priceFormat($expenseArr[$productService->id][$month])); ?>

                                            <p><?php echo e(($budget['expense_data'][$productService->id][$month] !=0)? (\App\Models\Budget::percentage($budget['expense_data'][$productService->id][$month],$expenseArr[$productService->id][$month])!=0) ? '('.(\App\Models\Budget::percentage($budget['expense_data'][$productService->id][$month],$expenseArr[$productService->id][$month]).'%)') :'':''); ?></p>

                                        </td>
                                        <td><?php echo e(\Auth::user()->priceFormat($overBudgetAmount)); ?>

                                            <p class="<?php echo e(($budget['expense_data'][$productService->id][$month] < $overBudgetAmount)? 'green-text':''); ?> <?php echo e(($budget['expense_data'][$productService->id][$month] > $overBudgetAmount)? 'red-text':''); ?>" ><?php echo e(($budget['expense_data'][$productService->id][$month] !=0)? (\App\Models\Budget::percentage($budget['expense_data'][$productService->id][$month],$overBudgetAmount) !=0) ?'('.(\App\Models\Budget::percentage($budget['expense_data'][$productService->id][$month],$overBudgetAmount).'%)') :'':''); ?></p>

                                        </td>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            <?php
                                $overExpenseBudgetTotalArr = array();
                                  foreach($overExpenseBudgetTotal as $overExpenseBudget)
                                  {
                                      foreach($overExpenseBudget as $k => $value)
                                      {
                                          $overExpenseBudgetTotalArr[$k] = (isset($overExpenseBudgetTotalArr[$k]) ? $overExpenseBudgetTotalArr[$k] + $value : $value);
                                      }
                                  }
                            ?>

                            <tr class="total">
                                <td class="text-dark"><span></span><strong><?php echo e(__('Total :')); ?></strong></td>
                                <?php if(!empty($budgetExpenseTotal) ): ?>
                                    <?php $__currentLoopData = $monthList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <td class="text-dark <?php echo e($month); ?>_total_expense"><strong><?php echo e(\Auth::user()->priceFormat($budgetExpenseTotal[$month])); ?></strong></td>
                                        <td class="text-dark"><strong><?php echo e(\Auth::user()->priceFormat($expenseTotalArr[$month])); ?></strong>
                                            <p><?php echo e(($budgetExpenseTotal[$month] !=0)? (\App\Models\Budget::percentage($budgetExpenseTotal[$month],$expenseTotalArr[$month])!=0) ? '('.(\App\Models\Budget::percentage($budgetExpenseTotal[$month],$expenseTotalArr[$month]).'%)') :'':''); ?></p>
                                        </td>
                                        <td class="text-dark"><strong><?php echo e(\Auth::user()->priceFormat($overExpenseBudgetTotalArr[$month])); ?></strong>
                                            <p class="<?php echo e(($budgetExpenseTotal[$month] < $overExpenseBudgetTotalArr[$month])? 'green-text':''); ?> <?php echo e(($budgetExpenseTotal[$month] >$overExpenseBudgetTotalArr[$month])? 'red-text':''); ?>"><?php echo e(($budgetExpenseTotal[$month] !=0)? (\App\Models\Budget::percentage($budgetExpenseTotal[$month],$overExpenseBudgetTotalArr[$month])!=0) ? '('.(\App\Models\Budget::percentage($budgetExpenseTotal[$month],$overExpenseBudgetTotalArr[$month]).'%)') :'':''); ?></p>

                                        </td>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>

                            </tr>

                            <td></td>

                            <tfoot>
                            <tr class="total">
                                <td class="text-dark"><span></span><strong><?php echo e(__('NET PROFIT :')); ?></strong></td>
                                <?php
                                    // NET PROFIT OF OVER BUDGET
                                     $overbudgetprofit = [];
                                     $keys   = array_keys($overBudgetTotalArr + $overExpenseBudgetTotalArr);
                                     foreach($keys as $v)
                                     {
                                         $overbudgetprofit[$v] = (empty($overBudgetTotalArr[$v]) ? 0 : $overBudgetTotalArr[$v]) - (empty($overExpenseBudgetTotalArr[$v]) ? 0 : $overExpenseBudgetTotalArr[$v]);
                                     }
                                     $data['overbudgetprofit']              = $overbudgetprofit;
                                ?>

                                <?php if(!empty($budgetprofit) ): ?>

                                    <?php $__currentLoopData = $monthList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <td class="text-dark"><strong><?php echo e(\Auth::user()->priceFormat($budgetprofit[$month])); ?></strong></td>
                                        <td class="text-dark"><strong><?php echo e(\Auth::user()->priceFormat($actualprofit[$month])); ?></strong>
                                            <p><?php echo e(($budgetprofit[$month] !=0)? (\App\Models\Budget::percentage($budgetprofit[$month],$actualprofit[$month])!=0) ?'('.(\App\Models\Budget::percentage($budgetprofit[$month],$actualprofit[$month]).'%)') :'':''); ?></p>

                                        </td>
                                        <td class="text-dark"><strong><?php echo e(\Auth::user()->priceFormat($overbudgetprofit[$month])); ?></strong>
                                            <p class="<?php echo e(($budgetprofit[$month] < $overbudgetprofit[$month])? 'green-text':''); ?> <?php echo e(($budgetprofit[$month] < $overbudgetprofit[$month])? 'green-text':''); ?>"><?php echo e(($budgetprofit[$month] !=0)? (\App\Models\Budget::percentage($budgetprofit[$month],$overbudgetprofit[$month])!=0) ? '('.(\App\Models\Budget::percentage($budgetprofit[$month],$overbudgetprofit[$month]).'%)') :'':''); ?></p>

                                        </td>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>

                            </tr>
                            </tfoot>


                        </table>

                        

                    <?php elseif($budget->period == 'quarterly'): ?>
                        <table class="table table-bordered table-item data">
                            <thead>
                            <tr>
                                <td rowspan="2"></td> <!-- merge two rows -->
                                <?php $__currentLoopData = $quarterly_monthlist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <th colspan="3" scope="colgroup" class="text-center br-1px"><?php echo e($month); ?></th>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tr>
                            <tr>
                                <?php $__currentLoopData = $quarterly_monthlist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <th scope="col" class="br-1px">Budget</th>
                                    <th scope="col" class="br-1px">Actual</th>
                                    <th scope="col" class="br-1px">Over Budget</th>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tr>
                            </thead>

                            <!----INCOME Category ---------------------->

                            <tr>
                                <th colspan="37" class="text-dark light_blue"><span><?php echo e(__('Income :')); ?></span></th>
                            </tr>

                            <?php
                                $overBudgetTotal=[];
                            ?>

                            <?php $__currentLoopData = $incomeproduct; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $productService): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="text-dark"><?php echo e($productService->name); ?></td>
                                    <?php $__currentLoopData = $quarterly_monthlist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $budgetAmount= ($budget['income_data'][$productService->id][$month])?$budget['income_data'][$productService->id][$month]:0;
                                            $actualAmount=$incomeArr[$productService->id][$month];
                                            $overBudgetAmount=$actualAmount-$budgetAmount;
                                            $overBudgetTotal[$productService->id][$month]=$overBudgetAmount;
                                        ?>

                                        <td class="income_data <?php echo e($month); ?>_income"><?php echo e(!empty (\Auth::user()->priceFormat($budget['income_data'][$productService->id][$month]))?\Auth::user()->priceFormat($budget['income_data'][$productService->id][$month]):0); ?></td>
                                        <td><?php echo e(\Auth::user()->priceFormat($incomeArr[$productService->id][$month])); ?>

                                            
                                            <p><?php echo e(($budget['income_data'][$productService->id][$month] !=0)? (\App\Models\Budget::percentage($budget['income_data'][$productService->id][$month],$incomeArr[$productService->id][$month])!=0) ? '('.(\App\Models\Budget::percentage($budget['income_data'][$productService->id][$month],$incomeArr[$productService->id][$month]).'%)') :'':''); ?></p>

                                        </td>
                                        <td><?php echo e(\Auth::user()->priceFormat($overBudgetAmount)); ?>

                                            <p class="<?php echo e(($budget['income_data'][$productService->id][$month] < $overBudgetAmount)? 'green-text':''); ?> <?php echo e(($budget['income_data'][$productService->id][$month] > $overBudgetAmount)? 'red-text':''); ?>"><?php echo e(($budget['income_data'][$productService->id][$month] !=0)? '('.(\App\Models\Budget::percentage($budget['income_data'][$productService->id][$month],$overBudgetAmount).'%)') :''); ?></p>
                                        </td>

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $overBudgetTotalArr = array();
                                  foreach($overBudgetTotal as $overBudget)
                                  {
                                      foreach($overBudget as $k => $value)
                                      {
                                          $overBudgetTotalArr[$k] = (isset($overBudgetTotalArr[$k]) ? $overBudgetTotalArr[$k] + $value : $value);
                                      }
                                  }
                            ?>
                            <tr class="total">
                                <td class="text-dark"><strong><?php echo e(__('Total :')); ?></strong></td>
                                <?php if(!empty($budgetTotal) ): ?>

                                    <?php $__currentLoopData = $quarterly_monthlist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                        <td class="text-dark <?php echo e($month); ?>_total_income"><strong><?php echo e(\Auth::user()->priceFormat($budgetTotal[$month])); ?></strong></td>
                                        <td><strong><?php echo e(\Auth::user()->priceFormat($incomeTotalArr[$month])); ?></strong>
                                            <p><?php echo e(($budgetTotal[$month] !=0)? (\App\Models\Budget::percentage($budgetTotal[$month],$incomeTotalArr[$month]) !=0)?'('.(\App\Models\Budget::percentage($budgetTotal[$month],$incomeTotalArr[$month]).'%)') :'':''); ?></p>
                                        </td>
                                        <td class="text-dark"><strong><?php echo e(\Auth::user()->priceFormat($overBudgetTotalArr[$month])); ?></strong>
                                            <p class="<?php echo e(($budgetTotal[$month] < $overBudgetTotalArr[$month])? 'green-text':''); ?> <?php echo e(($budgetTotal[$month] > $overBudgetTotalArr[$month])? 'red-text':''); ?>"><?php echo e(($budgetTotal[$month] !=0)? '('.(\App\Models\Budget::percentage($budgetTotal[$month],$overBudgetTotalArr[$month]).'%)') :''); ?></p>
                                        </td>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>

                            </tr>


                            <!------------ EXPENSE Category ---------------------->

                            <tr>
                                <th colspan="37" class="text-dark light_blue"><span><?php echo e(__('Expense :')); ?></span></th>
                            </tr>

                            <?php
                                $overExpenseBudgetTotal=[];
                            ?>

                            <?php $__currentLoopData = $expenseproduct; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $productService): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>

                                    <td class="text-dark"><?php echo e($productService->name); ?></td>
                                    <?php $__currentLoopData = $quarterly_monthlist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $budgetAmount= ($budget['expense_data'][$productService->id][$month])?$budget['expense_data'][$productService->id][$month]:0;
                                            $actualAmount=$expenseArr[$productService->id][$month];
                                            $overBudgetAmount=$actualAmount-$budgetAmount;
                                            $overExpenseBudgetTotal[$productService->id][$month]=$overBudgetAmount;

                                        ?>
                                        <td class="expense_data <?php echo e($month); ?>_expense"><?php echo e(\Auth::user()->priceFormat(!empty($budget['expense_data'][$productService->id][$month]))?\Auth::user()->priceFormat($budget['expense_data'][$productService->id][$month]):0); ?></td>
                                        <td><?php echo e(\Auth::user()->priceFormat($expenseArr[$productService->id][$month])); ?>

                                            <p><?php echo e(($budget['expense_data'][$productService->id][$month] !=0)? (\App\Models\Budget::percentage($budget['expense_data'][$productService->id][$month],$expenseArr[$productService->id][$month]) !=0) ?'('.(\App\Models\Budget::percentage($budget['expense_data'][$productService->id][$month],$expenseArr[$productService->id][$month]).'%)') :'':''); ?></p>

                                        </td>
                                        <td><?php echo e(\Auth::user()->priceFormat($overBudgetAmount)); ?>

                                            <p class="<?php echo e(($budget['expense_data'][$productService->id][$month] < $overBudgetAmount)? 'green-text':''); ?> <?php echo e(($budget['expense_data'][$productService->id][$month] > $overBudgetAmount)? 'red-text':''); ?> "><?php echo e(($budget['expense_data'][$productService->id][$month] !=0)? (\App\Models\Budget::percentage($budget['expense_data'][$productService->id][$month],$overBudgetAmount)!=0) ? '('.(\App\Models\Budget::percentage($budget['expense_data'][$productService->id][$month],$overBudgetAmount)
                                        .'%)') :'':''); ?></p>
                                        </td>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php if(!empty($budgetExpenseTotal) ): ?>
                                        <?php
                                            $overExpenseBudgetTotalArr = array();
                                              foreach($overExpenseBudgetTotal as $overExpenseBudget)
                                              {
                                                  foreach($overExpenseBudget as $k => $value)
                                                  {
                                                      $overExpenseBudgetTotalArr[$k] = (isset($overExpenseBudgetTotalArr[$k]) ? $overExpenseBudgetTotalArr[$k] + $value : $value);
                                                  }
                                              }
                                        ?>
                                    <?php endif; ?>

                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            <tr class="total">
                                <td class="text-dark"><span></span><strong><?php echo e(__('Total :')); ?></strong></td>

                                <?php if(!empty($budgetExpenseTotal) ): ?>

                                    <?php $__currentLoopData = $quarterly_monthlist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                        <td class="text-dark <?php echo e($month); ?>_total_expense"><strong><?php echo e(\Auth::user()->priceFormat($budgetExpenseTotal[$month])); ?></strong></td>
                                        <td class="text-dark"><strong><?php echo e(\Auth::user()->priceFormat($expenseTotalArr[$month])); ?></strong>
                                            <p><?php echo e(($budgetExpenseTotal[$month] !=0)? (\App\Models\Budget::percentage($budgetExpenseTotal[$month],$expenseTotalArr[$month])!=0) ? '('.(\App\Models\Budget::percentage($budgetExpenseTotal[$month],$expenseTotalArr[$month]).'%)') :'':''); ?></p>

                                        </td>
                                        <td class="text-dark"><strong><?php echo e(\Auth::user()->priceFormat($overExpenseBudgetTotalArr[$month])); ?></strong>
                                            <p class="<?php echo e(($budgetExpenseTotal[$month] < $overExpenseBudgetTotalArr[$month])? 'green-text':''); ?> <?php echo e(($budgetExpenseTotal[$month] > $overExpenseBudgetTotalArr[$month])? 'red-text':''); ?>"><?php echo e(($budgetExpenseTotal[$month] !=0)? (\App\Models\Budget::percentage($budgetExpenseTotal[$month],$overExpenseBudgetTotalArr[$month])!=0) ?'('.(\App\Models\Budget::percentage($budgetExpenseTotal[$month],$overExpenseBudgetTotalArr[$month]).'%)') :'':''); ?></p>

                                        </td>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>

                            </tr>

                            <td></td>

                            <tfoot>
                            <tr class="total">
                                <td class="text-dark"><span></span><strong><?php echo e(__('NET PROFIT :')); ?></strong></td>
                                <?php if(!empty($overExpenseBudgetTotalArr) ): ?>

                                    <?php
                                        // NET PROFIT OF OVER BUDGET
                                         $overbudgetprofit = [];
                                         $keys   = array_keys($overBudgetTotalArr + $overExpenseBudgetTotalArr);
                                         foreach($keys as $v)
                                         {
                                             $overbudgetprofit[$v] = (empty($overBudgetTotalArr[$v]) ? 0 : $overBudgetTotalArr[$v]) - (empty($overExpenseBudgetTotalArr[$v]) ? 0 : $overExpenseBudgetTotalArr[$v]);
                                         }
                                         $data['overbudgetprofit']              = $overbudgetprofit;
                                    ?>
                                <?php endif; ?>

                                <?php if(!empty($budgetprofit) ): ?>
                                    <?php $__currentLoopData = $quarterly_monthlist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <td class="text-dark"><strong><?php echo e(\Auth::user()->priceFormat($budgetprofit[$month])); ?></strong></td>
                                        <td class="text-dark"><strong><?php echo e(\Auth::user()->priceFormat($actualprofit[$month])); ?></strong></td>
                                        <td class="text-dark"><strong><?php echo e(\Auth::user()->priceFormat($overbudgetprofit[$month])); ?></strong>
                                            <p class="<?php echo e(($budgetprofit[$month] < $overbudgetprofit[$month])? 'green-text':''); ?> <?php echo e(($budgetprofit[$month] > $overbudgetprofit[$month])? 'red-text':''); ?>"><?php echo e(($budgetprofit[$month] !=0)? (\App\Models\Budget::percentage($budgetprofit[$month],$overbudgetprofit[$month])!=0) ? '('.(\App\Models\Budget::percentage($budgetprofit[$month],$overbudgetprofit[$month]).'%)') :'':''); ?></p>
                                        </td>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>

                            </tr>
                            </tfoot>


                        </table>

                        

                    <?php elseif($budget->period == 'half-yearly'): ?>
                        <table class="table table-bordered table-item data">
                            <thead>
                            <tr>
                                <td rowspan="2"></td>
                                <?php $__currentLoopData = $half_yearly_monthlist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <th colspan="3" scope="colgroup" class="text-center br-1px"><?php echo e($month); ?></th>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tr>
                            <tr>
                                <?php $__currentLoopData = $half_yearly_monthlist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <th scope="col" class="br-1px">Budget</th>
                                    <th scope="col" class="br-1px">Actual</th>
                                    <th scope="col" class="br-1px">Over Budget</th>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tr>
                            </thead>

                            <!----INCOME Category ---------------------->

                            <tr>
                                <th colspan="37" class="text-dark light_blue"><span><?php echo e(__('Income :')); ?></span></th>
                            </tr>

                            <?php
                                $overBudgetTotal=[];
                            ?>

                            <?php $__currentLoopData = $incomeproduct; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $productService): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="text-dark"><?php echo e($productService->name); ?></td>
                                    <?php $__currentLoopData = $half_yearly_monthlist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $budgetAmount= ($budget['income_data'][$productService->id][$month])?$budget['income_data'][$productService->id][$month]:0;
                                            $actualAmount=$incomeArr[$productService->id][$month];
                                            $overBudgetAmount=$actualAmount-$budgetAmount;
                                            $overBudgetTotal[$productService->id][$month]=$overBudgetAmount;

                                        ?>

                                        <td class="income_data <?php echo e($month); ?>_income"><?php echo e(!empty (\Auth::user()->priceFormat($budget['income_data'][$productService->id][$month]))?\Auth::user()->priceFormat($budget['income_data'][$productService->id][$month]):0); ?></td>
                                        <td><?php echo e(\Auth::user()->priceFormat($incomeArr[$productService->id][$month])); ?>

                                            <p><?php echo e(($budget['income_data'][$productService->id][$month] !=0)? (\App\Models\Budget::percentage($budget['income_data'][$productService->id][$month],$incomeArr[$productService->id][$month])!=0) ?'('.(\App\Models\Budget::percentage($budget['income_data'][$productService->id][$month],$incomeArr[$productService->id][$month]).'%)') :'':''); ?></p>

                                        </td>
                                        <td><?php echo e(\Auth::user()->priceFormat($overBudgetAmount)); ?>

                                            <p class="<?php echo e(($budget['income_data'][$productService->id][$month] < $overBudgetAmount)? 'green-text':''); ?> <?php echo e(($budget['income_data'][$productService->id][$month] > $overBudgetAmount)? 'red-text':''); ?>"><?php echo e(($budget['income_data'][$productService->id][$month] !=0)? (\App\Models\Budget::percentage($budget['income_data'][$productService->id][$month],$overBudgetAmount)!=0) ?'('.(\App\Models\Budget::percentage($budget['income_data'][$productService->id][$month],
                                        $overBudgetAmount).'%)') :'':''); ?></p>

                                        </td>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $overBudgetTotalArr = array();
                                  foreach($overBudgetTotal as $overBudget)
                                  {
                                      foreach($overBudget as $k => $value)
                                      {
                                          $overBudgetTotalArr[$k] = (isset($overBudgetTotalArr[$k]) ? $overBudgetTotalArr[$k] + $value : $value);
                                      }
                                  }
                            ?>

                            <tr class="total">
                                <td class="text-dark"><span></span><strong><?php echo e(__('Total :')); ?></strong></td>
                                <?php if(!empty($budgetTotal) ): ?>
                                    <?php $__currentLoopData = $half_yearly_monthlist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                        <td class="text-dark <?php echo e($month); ?>_total_income"><strong><?php echo e(\Auth::user()->priceFormat($budgetTotal[$month])); ?></strong></td>
                                        <td class="text-dark"><strong><?php echo e(\Auth::user()->priceFormat($incomeTotalArr[$month])); ?></strong>
                                            <p><?php echo e(($budgetTotal[$month] !=0)? (\App\Models\Budget::percentage($budgetTotal[$month],$incomeTotalArr[$month])!=0) ?'('.(\App\Models\Budget::percentage($budgetTotal[$month],$incomeTotalArr[$month]).'%)') :'':''); ?></p>
                                        </td>
                                        <td class="text-dark"><strong><?php echo e(\Auth::user()->priceFormat($overBudgetTotalArr[$month])); ?></strong>
                                            <p class="<?php echo e(($budgetTotal[$month] < $overBudgetTotalArr[$month])? 'green-text':''); ?> <?php echo e(($budgetTotal[$month] > $overBudgetTotalArr[$month])? 'red-text':''); ?>"><?php echo e(($budgetTotal[$month] !=0)? (\App\Models\Budget::percentage($budgetTotal[$month],$overBudgetTotalArr[$month])!=0) ?'('.(\App\Models\Budget::percentage($budgetTotal[$month],$overBudgetTotalArr[$month]).'%)') :'':''); ?></p>

                                        </td>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>

                            </tr>


                            <!------------ EXPENSE Category ---------------------->

                            <tr>
                                <th colspan="37" class="text-dark light_blue"><span><?php echo e(__('Expense :')); ?></span></th>
                            </tr>

                            <?php
                                $overExpenseBudgetTotal=[];
                            ?>

                            <?php $__currentLoopData = $expenseproduct; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $productService): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="text-dark"><?php echo e($productService->name); ?></td>
                                    <?php $__currentLoopData = $half_yearly_monthlist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $budgetAmount= ($budget['expense_data'][$productService->id][$month])?$budget['expense_data'][$productService->id][$month]:0;
                                            $actualAmount=$expenseArr[$productService->id][$month];
                                            $overBudgetAmount=$actualAmount-$budgetAmount;
                                            $overExpenseBudgetTotal[$productService->id][$month]=$overBudgetAmount;

                                        ?>
                                        <td class="expense_data <?php echo e($month); ?>_expense"><?php echo e(\Auth::user()->priceFormat(!empty($budget['expense_data'][$productService->id][$month]))?\Auth::user()->priceFormat($budget['expense_data'][$productService->id][$month]):0); ?></td>
                                        <td><?php echo e(\Auth::user()->priceFormat($expenseArr[$productService->id][$month])); ?>

                                            <p><?php echo e(($budget['expense_data'][$productService->id][$month] !=0)? (\App\Models\Budget::percentage($budget['expense_data'][$productService->id][$month],$expenseArr[$productService->id][$month])!=0) ?'('.(\App\Models\Budget::percentage($budget['expense_data'][$productService->id][$month],$expenseArr[$productService->id][$month]).'%)') :'':''); ?></p>

                                        </td>
                                        <td><?php echo e(\Auth::user()->priceFormat($overBudgetAmount)); ?>

                                            <p class="<?php echo e(($budget['expense_data'][$productService->id][$month] < $overBudgetAmount)? 'green-text':''); ?> <?php echo e(($budget['expense_data'][$productService->id][$month] > $overBudgetAmount)? 'red-text':''); ?>"><?php echo e(($budget['expense_data'][$productService->id][$month] !=0)? (\App\Models\Budget::percentage($budget['expense_data'][$productService->id][$month],$overBudgetAmount)!=0)?'('.(\App\Models\Budget::percentage
                                        ($budget['expense_data'][$productService->id][$month],$overBudgetAmount).'%)') :'':''); ?></p>
                                        </td>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $overExpenseBudgetTotalArr = array();
                                  foreach($overExpenseBudgetTotal as $overExpenseBudget)
                                  {
                                      foreach($overExpenseBudget as $k => $value)
                                      {
                                          $overExpenseBudgetTotalArr[$k] = (isset($overExpenseBudgetTotalArr[$k]) ? $overExpenseBudgetTotalArr[$k] + $value : $value);
                                      }
                                  }
                            ?>


                            <tr class="total">
                                <td class="text-dark"><span></span><strong><?php echo e(__('Total :')); ?></strong></td>
                                <?php if(!empty($budgetExpenseTotal) ): ?>
                                    <?php $__currentLoopData = $half_yearly_monthlist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


                                        <td class="text-dark <?php echo e($month); ?>_total_expense"><strong><?php echo e(\Auth::user()->priceFormat($budgetExpenseTotal[$month])); ?></strong></td>
                                        <td class="text-dark"><strong><?php echo e(\Auth::user()->priceFormat($expenseTotalArr[$month])); ?></strong>
                                            <p><?php echo e(($budgetExpenseTotal[$month] !=0)? (\App\Models\Budget::percentage($budgetExpenseTotal[$month],$expenseTotalArr[$month])!=0) ?'('.(\App\Models\Budget::percentage($budgetExpenseTotal[$month],$expenseTotalArr[$month]).'%)') :'':''); ?></p>

                                        </td>
                                        <td class="text-dark"><strong><?php echo e(\Auth::user()->priceFormat($overExpenseBudgetTotalArr[$month])); ?></strong>
                                            <p class="<?php echo e(($budgetExpenseTotal[$month] < $overExpenseBudgetTotalArr[$month])? 'green-text':''); ?> <?php echo e(($budgetExpenseTotal[$month] > $overExpenseBudgetTotalArr[$month])? 'red-text':''); ?>"><?php echo e(($budgetExpenseTotal[$month] !=0)? (\App\Models\Budget::percentage($budgetExpenseTotal[$month],$overExpenseBudgetTotalArr[$month])!=0) ? '('.(\App\Models\Budget::percentage($budgetExpenseTotal[$month],$overExpenseBudgetTotalArr[$month]).'%)') :'':''); ?></p>

                                        </td>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>

                            </tr>
                            <td></td>
                            <tfoot>
                            <tr class="total">
                                <td class="text-dark"><span></span><strong><?php echo e(__('NET PROFIT :')); ?></strong></td>
                                <?php
                                    // NET PROFIT OF OVER BUDGET
                                     $overbudgetprofit = [];
                                     $keys   = array_keys($overBudgetTotalArr + $overExpenseBudgetTotalArr);
                                     foreach($keys as $v)
                                     {
                                         $overbudgetprofit[$v] = (empty($overBudgetTotalArr[$v]) ? 0 : $overBudgetTotalArr[$v]) - (empty($overExpenseBudgetTotalArr[$v]) ? 0 : $overExpenseBudgetTotalArr[$v]);
                                     }
                                     $data['overbudgetprofit']              = $overbudgetprofit;
                                ?>
                                <?php if(!empty($budgetprofit) ): ?>
                                    <?php $__currentLoopData = $half_yearly_monthlist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <td class="text-dark"><strong><?php echo e(\Auth::user()->priceFormat($budgetprofit[$month])); ?></strong></td>
                                        <td class="text-dark"><strong><?php echo e(\Auth::user()->priceFormat($actualprofit[$month])); ?></strong>
                                            <p><?php echo e(($budgetprofit[$month] !=0)? (\App\Models\Budget::percentage($budgetprofit[$month],$actualprofit[$month])!=0) ? '('.(\App\Models\Budget::percentage($budgetprofit[$month],$actualprofit[$month]).'%)') :'':''); ?></p>
                                        </td>
                                        <td class="text-dark"><strong><?php echo e(\Auth::user()->priceFormat($overbudgetprofit[$month])); ?></strong>
                                            <p class="<?php echo e(($budgetprofit[$month] < $overbudgetprofit[$month])? 'green-text':''); ?> <?php echo e(($budgetprofit[$month] > $overbudgetprofit[$month])? 'red-text':''); ?>"><?php echo e(($budgetprofit[$month] !=0)? (\App\Models\Budget::percentage($budgetprofit[$month],$overbudgetprofit[$month])!=0) ?'('.(\App\Models\Budget::percentage($budgetprofit[$month],$overbudgetprofit[$month]).'%)') :'':''); ?></p>
                                        </td>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>

                            </tr>
                            </tfoot>
                        </table>

                        
                    <?php else: ?>
                        <table class="table table-bordered table-item data">
                            <thead>
                            <tr>
                                <td rowspan="2"></td> <!-- merge two rows -->
                                <?php $__currentLoopData = $yearly_monthlist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <th colspan="3" scope="colgroup" class="text-center br-1px"><?php echo e($month); ?></th>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>`
                            </tr>
                            <tr>
                                <?php $__currentLoopData = $yearly_monthlist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <th scope="col" class="br-1px">Budget</th>
                                    <th scope="col" class="br-1px">Actual</th>
                                    <th scope="col" class="br-1px">Over Budget</th>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tr>
                            </thead>

                            <!----INCOME Category ---------------------->

                            <tr>
                                <th colspan="37" class="text-dark light_blue"><span><?php echo e(__('Income :')); ?></span></th>
                            </tr>

                            <?php
                                $overBudgetTotal=[];
                            ?>

                            <?php $__currentLoopData = $incomeproduct; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $productService): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="text-dark"><?php echo e($productService->name); ?></td>
                                    <?php $__currentLoopData = $yearly_monthlist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $budgetAmount= ($budget['income_data'][$productService->id][$month])?$budget['income_data'][$productService->id][$month]:0;
                                            $actualAmount=$incomeArr[$productService->id][$month];
                                            $overBudgetAmount=$actualAmount-$budgetAmount;
                                            $overBudgetTotal[$productService->id][$month]=$overBudgetAmount;

                                        ?>

                                        <td class="income_data <?php echo e($month); ?>_income"><?php echo e(!empty (\Auth::user()->priceFormat($budget['income_data'][$productService->id][$month]))?\Auth::user()->priceFormat($budget['income_data'][$productService->id][$month]):0); ?></td>
                                        <td><?php echo e(\Auth::user()->priceFormat($incomeArr[$productService->id][$month])); ?>

                                            <p><?php echo e(($budget['income_data'][$productService->id][$month] !=0)? (\App\Models\Budget::percentage($budget['income_data'][$productService->id][$month],$incomeArr[$productService->id][$month])!=0) ?'('.(\App\Models\Budget::percentage($budget['income_data'][$productService->id][$month],$incomeArr[$productService->id][$month]).'%)') :'':''); ?></p>

                                        </td>
                                        <td><?php echo e(\Auth::user()->priceFormat($overBudgetAmount)); ?>

                                            <p class="<?php echo e(($budget['income_data'][$productService->id][$month] < $overBudgetAmount)? 'green-text':''); ?> <?php echo e(($budget['income_data'][$productService->id][$month] > $overBudgetAmount)? 'red-text':''); ?>"><?php echo e(($budget['income_data'][$productService->id][$month] !=0)? (\App\Models\Budget::percentage($budget['income_data'][$productService->id][$month],$overBudgetAmount)!=0) ?'('.(\App\Models\Budget::percentage
                                        ($budget['income_data'][$productService->id][$month],$overBudgetAmount).'%)') :'':''); ?></p>

                                        </td>

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $overBudgetTotalArr = array();
                                  foreach($overBudgetTotal as $overBudget)
                                  {
                                      foreach($overBudget as $k => $value)
                                      {
                                          $overBudgetTotalArr[$k] = (isset($overBudgetTotalArr[$k]) ? $overBudgetTotalArr[$k] + $value : $value);
                                      }
                                  }
                            ?>


                            <tr class="total text-dark">
                                <td class=""><span></span><strong><?php echo e(__('Total :')); ?></strong></td>
                                <?php $__currentLoopData = $yearly_monthlist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        ?>
                                    <td class="text-dark <?php echo e($month); ?>_total_income"><strong><?php echo e(\Auth::user()->priceFormat($budgetTotal[$month])); ?></strong></td>
                                    <td class="text-dark"><strong><?php echo e(\Auth::user()->priceFormat($incomeTotalArr[$month])); ?></strong>
                                        <p><?php echo e(($budgetTotal[$month] !=0)? (\App\Models\Budget::percentage($budgetTotal[$month],$incomeTotalArr[$month])!=0)?'('.(\App\Models\Budget::percentage($budgetTotal[$month],$incomeTotalArr[$month]).'%)') :'':''); ?></p>

                                    </td>
                                    <td class="text-dark"><strong><?php echo e(\Auth::user()->priceFormat($overBudgetTotalArr[$month])); ?></strong>
                                        <p class="<?php echo e(($budgetTotal[$month] < $overBudgetTotalArr[$month])? 'green-text':''); ?> <?php echo e(($budgetTotal[$month] > $overBudgetTotalArr[$month])? 'red-text':''); ?>"><?php echo e(($budgetTotal[$month] !=0)? (\App\Models\Budget::percentage($budgetTotal[$month],$overBudgetTotalArr[$month])!=0) ?'('.(\App\Models\Budget::percentage($budgetTotal[$month],$overBudgetTotalArr[$month]).'%)') :'':''); ?></p>

                                    </td>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tr>


                            <!------------ EXPENSE Category ---------------------->

                            <tr>
                                <th colspan="37" class="text-dark light_blue"><span><?php echo e(__('Expense :')); ?></span></th>
                            </tr>
                            <?php
                                $overExpenseBudgetTotal=[];
                            ?>

                            <?php $__currentLoopData = $expenseproduct; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $productService): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="text-dark"><?php echo e($productService->name); ?></td>
                                    <?php $__currentLoopData = $yearly_monthlist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $budgetAmount= ($budget['expense_data'][$productService->id][$month])?$budget['expense_data'][$productService->id][$month]:0;
                                            $actualAmount=$expenseArr[$productService->id][$month];
                                            $overBudgetAmount=$actualAmount-$budgetAmount;
                                            $overExpenseBudgetTotal[$productService->id][$month]=$overBudgetAmount;

                                        ?>
                                        <td class="expense_data <?php echo e($month); ?>_expense"><?php echo e(\Auth::user()->priceFormat(!empty($budget['expense_data'][$productService->id][$month]))?\Auth::user()->priceFormat($budget['expense_data'][$productService->id][$month]):0); ?></td>
                                        <td><?php echo e(\Auth::user()->priceFormat($expenseArr[$productService->id][$month])); ?>

                                            <p><?php echo e(($budget['expense_data'][$productService->id][$month] !=0)? (\App\Models\Budget::percentage($budget['expense_data'][$productService->id][$month],$expenseArr[$productService->id][$month])!=0) ?'('.(\App\Models\Budget::percentage($budget['expense_data'][$productService->id][$month],$expenseArr[$productService->id][$month]).'%)') :'':''); ?></p>


                                        </td>
                                        <td><?php echo e(\Auth::user()->priceFormat($overBudgetAmount)); ?>

                                            <p class="<?php echo e(($budget['expense_data'][$productService->id][$month] < $overBudgetAmount)? 'green-text':''); ?> <?php echo e(($budget['expense_data'][$productService->id][$month] > $overBudgetAmount)? 'red-text':''); ?>"><?php echo e(($budget['expense_data'][$productService->id][$month] !=0)? (\App\Models\Budget::percentage($budget['expense_data'][$productService->id][$month],$overBudgetAmount)!=0) ?'('.(\App\Models\Budget::percentage
                                        ($budget['expense_data'][$productService->id][$month],$overBudgetAmount).'%)') :'':''); ?></p>
                                        </td>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            <?php
                                $overExpenseBudgetTotalArr = array();
                                  foreach($overExpenseBudgetTotal as $overExpenseBudget)
                                  {
                                      foreach($overExpenseBudget as $k => $value)
                                      {
                                          $overExpenseBudgetTotalArr[$k] = (isset($overExpenseBudgetTotalArr[$k]) ? $overExpenseBudgetTotalArr[$k] + $value : $value);
                                      }
                                  }
                            ?>

                            <tr class="total">
                                <td class="text-dark"><span></span><strong><?php echo e(__('Total :')); ?></strong></td>
                                <?php $__currentLoopData = $yearly_monthlist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        ?>
                                    <td class="text-dark <?php echo e($month); ?>_total_expense"><strong><?php echo e(\Auth::user()->priceFormat($budgetExpenseTotal[$month])); ?></strong></td>
                                    <td class="text-dark"><strong><?php echo e(\Auth::user()->priceFormat($expenseTotalArr[$month])); ?></strong>
                                        <p><?php echo e(($budgetExpenseTotal[$month] !=0)? (\App\Models\Budget::percentage($budgetExpenseTotal[$month],$expenseTotalArr[$month])!=0) ?'('.(\App\Models\Budget::percentage($budgetExpenseTotal[$month],$expenseTotalArr[$month]).'%)') :'':''); ?></p>

                                    </td>
                                    <td class="text-dark"><strong><?php echo e(\Auth::user()->priceFormat($overExpenseBudgetTotalArr[$month])); ?></strong>
                                        <p class="<?php echo e(($budgetExpenseTotal[$month] < $overExpenseBudgetTotalArr[$month])? 'green-text':''); ?> <?php echo e(($budgetExpenseTotal[$month] > $overExpenseBudgetTotalArr[$month])? 'red-text':''); ?>"><?php echo e(($budgetExpenseTotal[$month] !=0)? (\App\Models\Budget::percentage($budgetExpenseTotal[$month],$overExpenseBudgetTotalArr[$month])!=0) ? '('.(\App\Models\Budget::percentage($budgetExpenseTotal[$month],$overExpenseBudgetTotalArr[$month]).'%)') :'':''); ?></p>
                                    </td>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </tr>
                            <td></td>
                            <tfoot>
                            <tr class="total">
                                <td class="text-dark"><span></span><strong><?php echo e(__('NET PROFIT :')); ?></strong></td>
                                <?php
                                    // NET PROFIT OF OVER BUDGET
                                     $overbudgetprofit = [];
                                     $keys   = array_keys($overBudgetTotalArr + $overExpenseBudgetTotalArr);
                                     foreach($keys as $v)
                                     {
                                         $overbudgetprofit[$v] = (empty($overBudgetTotalArr[$v]) ? 0 : $overBudgetTotalArr[$v]) - (empty($overExpenseBudgetTotalArr[$v]) ? 0 : $overExpenseBudgetTotalArr[$v]);
                                     }
                                     $data['overbudgetprofit']              = $overbudgetprofit;
                                ?>

                                <?php $__currentLoopData = $yearly_monthlist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <td class="text-dark"><strong><?php echo e(\Auth::user()->priceFormat($budgetprofit[$month])); ?></strong></td>
                                    <td class="text-dark"><strong><?php echo e(\Auth::user()->priceFormat($actualprofit[$month])); ?></strong>
                                        <p><?php echo e(($budgetprofit[$month] !=0)? (\App\Models\Budget::percentage($budgetprofit[$month],$actualprofit[$month])!=0) ?'('.(\App\Models\Budget::percentage($budgetprofit[$month],$actualprofit[$month]).'%)') :'':''); ?></p>

                                    </td>
                                    <td class="text-dark"><strong><?php echo e(\Auth::user()->priceFormat($overbudgetprofit[$month])); ?></strong>
                                        <p class="<?php echo e(($budgetprofit[$month] < $overbudgetprofit[$month])? 'green-text':''); ?> <?php echo e(($budgetprofit[$month] > $overbudgetprofit[$month])? 'red-text':''); ?>"><?php echo e(($budgetprofit[$month] !=0)? (\App\Models\Budget::percentage($budgetprofit[$month],$overbudgetprofit[$month])!=0) ?'('.(\App\Models\Budget::percentage($budgetprofit[$month],$overbudgetprofit[$month]).'%)') :'':''); ?></p>
                                    </td>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </tr>
                            </tfoot>

                        </table>

                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>





<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u188192483/domains/techzone.so/public_html/aldaar/resources/views/budget/show.blade.php ENDPATH**/ ?>