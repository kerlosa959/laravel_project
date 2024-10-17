@extends('layouts.admin')
@php
    $dir = asset(Storage::url('uploads/plan'));
    $admin_payment_setting = Utility::getAdminPaymentSetting();
@endphp
@section('page-title')
    {{__('Manage Plan')}}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{__('Plan')}}</li>
@endsection
@section('action-btn')
    <div class="float-end">
        @can('create plan')
            @if(isset($admin_payment_setting) && !empty($admin_payment_setting))
                @if($admin_payment_setting['is_manually_payment_enabled'] == 'on' || $admin_payment_setting['is_bank_transfer_enabled'] == 'on'
                || $admin_payment_setting['is_stripe_enabled'] == 'on' || $admin_payment_setting['is_paypal_enabled'] == 'on'
                || $admin_payment_setting['is_paystack_enabled'] == 'on' || $admin_payment_setting['is_flutterwave_enabled'] == 'on'
                || $admin_payment_setting['is_razorpay_enabled'] == 'on' || $admin_payment_setting['is_mercado_enabled'] == 'on'
                || $admin_payment_setting['is_paytm_enabled'] == 'on'  || $admin_payment_setting['is_mollie_enabled'] == 'on'
                || $admin_payment_setting['is_skrill_enabled'] == 'on' || $admin_payment_setting['is_coingate_enabled'] == 'on'
                || $admin_payment_setting['is_paymentwall_enabled'] == 'on' || $admin_payment_setting['is_toyyibpay_enabled'] == 'on'
                || $admin_payment_setting['is_payfast_enabled'] == 'on' || $admin_payment_setting['is_iyzipay_enabled'] == 'on'
                || $admin_payment_setting['is_sspay_enabled'] == 'on' || $admin_payment_setting['is_paytab_enabled'] == 'on'
                || $admin_payment_setting['is_benefit_enabled'] == 'on' || $admin_payment_setting['is_cashfree_enabled'] == 'on'
                || $admin_payment_setting['is_aamarpay_enabled'] == 'on' || $admin_payment_setting['is_paytr_enabled'] == 'on'
                || $admin_payment_setting['is_yookassa_enabled'] == 'on')
                    <a href="#" data-size="lg" data-url="{{ route('plans.create') }}" data-ajax-popup="true" data-bs-toggle="tooltip" title="{{__('Create')}}" data-title="{{__('Create New Plan')}}" class="btn btn-sm btn-primary">
                        <i class="ti ti-plus"></i>
                    </a>
                @endif
            @endif
        @endcan
    </div>
@endsection

@section('content')
    <div class="row">
        @foreach($plans as $plan)
            <div class="plan_card">
                <div class="card price-card price-1 wow animate__fadeInUp" data-wow-delay="0.2s" style="
                   visibility: visible;
                   animation-delay: 0.2s;
                   animation-name: fadeInUp;
                   ">
                    <div class="card-body">
                        <span class="price-badge bg-primary">{{ $plan->name }}</span>
                        @if (\Auth::user()->type == 'company' && \Auth::user()->plan == $plan->id)
                            <div class="d-flex flex-row-reverse m-0 p-0 active-tag">
                                 <span class=" align-items-right">
                                    <i class="f-10 lh-1 fas fa-circle text-success"></i>
                                    <span class="ms-2">{{ __('Active') }}</span>
                                </span>
                            </div>

                        @endif
                        <h1 class="mb-4 f-w-600 ">{{(isset($admin_payment_setting['currency_symbol']) ? $admin_payment_setting['currency_symbol'] : '$')}}{{ number_format($plan->price) }}
                            <small class="text-sm">/{{__(\App\Models\Plan::$arrDuration[$plan->duration])}}</small></h1>
                        <p class="mb-0">
                            {{__('Duration : ').__(\App\Models\Plan::$arrDuration[$plan->duration])}}<br/>
                        </p>

                        <div class="row ">
                            <div class="col-6">
                                <ul class="list-unstyled my-5">
                                    <li class="white-sapce-nowrap"><span class="theme-avtar"><i class="text-primary ti ti-circle-plus"></i></span>{{($plan->max_users==-1)?__('Unlimited'):$plan->max_users}} {{__('Users')}}</li>
                                    <li class="white-sapce-nowrap"><span class="theme-avtar"><i class="text-primary ti ti-circle-plus"></i></span>{{($plan->max_customers==-1)?__('Unlimited'):$plan->max_customers}} {{__('Customers')}}</li>
                                    <li class="white-sapce-nowrap"><span class="theme-avtar"><i class="text-primary ti ti-circle-plus"></i></span>{{($plan->max_venders==-1)?__('Unlimited'):$plan->max_venders}} {{__('Vendors')}}</li>
                                    <li class="white-sapce-nowrap"><span class="theme-avtar"><i class="text-primary ti ti-circle-plus"></i></span>{{($plan->max_clients==-1)?__('Unlimited'):$plan->max_clients}} {{__('Clients')}}</li>
                                    <li class="white-sapce-nowrap"><span class="theme-avtar"><i class="text-primary ti ti-circle-plus"></i></span>{{($plan->storage_limit==-1)?__('Unlimited'):$plan->storage_limit}} {{__('MB')}}  {{__('Storage')}}</li>
                                </ul>
                            </div>
                            <div class="col-6">
                                <ul class="list-unstyled my-5">
                                    <li class="white-sapce-nowrap"><span class="theme-avtar"><i class="text-primary ti ti-circle-plus"></i></span>{{($plan->account==1)?__('Enable'):__('Disable')}} {{__('Account')}}</li>
                                    <li class="white-sapce-nowrap"><span class="theme-avtar"><i class="text-primary ti ti-circle-plus"></i></span>{{($plan->crm==1)?__('Enable'):__('Disable')}} {{__('CRM')}}</li>
                                    <li class="white-sapce-nowrap"><span class="theme-avtar"><i class="text-primary ti ti-circle-plus"></i></span>{{($plan->hrm==1)?__('Enable'):__('Disable')}} {{__('HRM')}}</li>
                                    <li class="white-sapce-nowrap"><span class="theme-avtar"><i class="text-primary ti ti-circle-plus"></i></span>{{($plan->project==1)?__('Enable'):__('Disable')}} {{__('Project')}}</li>
                                    <li class="white-sapce-nowrap"><span class="theme-avtar"><i class="text-primary ti ti-circle-plus"></i></span>{{($plan->pos==1)?__('Enable'):__('Disable')}} {{__('POS')}}</li>
                                    <li class="white-sapce-nowrap"><span class="theme-avtar"><i class="text-primary ti ti-circle-plus"></i></span>{{($plan->chatgpt==1)?__('Enable'):__('Disable')}} {{__('Chat GPT')}}</li>

                                </ul>
                            </div>
                        </div>

                        @if(\Auth::user()->type =='super admin')
                            <div class="col-4">
                                <a title="{{__('Edit Plan')}}" href="#" class="btn btn-primary btn-icon m-1" data-url="{{ route('plans.edit',$plan->id) }}" data-ajax-popup="true" data-title="{{__('Edit Plan')}}" data-size="lg" data-toggle="tooltip" data-original-title="{{__('Edit')}}">
                                    <i class="ti ti-edit"></i>
                                </a>
                            </div>
                        @endif
                        @if(isset($admin_payment_setting) && !empty($admin_payment_setting))
                            @if($admin_payment_setting['is_manually_payment_enabled'] == 'on'
                                || $admin_payment_setting['is_bank_transfer_enabled'] == 'on' || $admin_payment_setting['is_stripe_enabled'] == 'on'
                                || $admin_payment_setting['is_paypal_enabled'] == 'on' || $admin_payment_setting['is_paystack_enabled'] == 'on'
                                || $admin_payment_setting['is_flutterwave_enabled'] == 'on'|| $admin_payment_setting['is_razorpay_enabled'] == 'on'
                                || $admin_payment_setting['is_mercado_enabled'] == 'on'|| $admin_payment_setting['is_paytm_enabled'] == 'on'
                                || $admin_payment_setting['is_mollie_enabled'] == 'on'|| $admin_payment_setting['is_skrill_enabled'] == 'on'
                                || $admin_payment_setting['is_coingate_enabled'] == 'on' || $admin_payment_setting['is_paymentwall_enabled'] == 'on'
                                || $admin_payment_setting['is_paymentwall_enabled'] == 'on' || $admin_payment_setting['is_toyyibpay_enabled'] == 'on'
                                || $admin_payment_setting['is_payfast_enabled'] == 'on' || $admin_payment_setting['is_iyzipay_enabled'] == 'on'
                                || $admin_payment_setting['is_sspay_enabled'] == 'on' || $admin_payment_setting['is_paytab_enabled'] == 'on'
                                || $admin_payment_setting['is_benefit_enabled'] == 'on' || $admin_payment_setting['is_cashfree_enabled'] == 'on'
                                || $admin_payment_setting['is_aamarpay_enabled'] == 'on' || $admin_payment_setting['is_paytr_enabled'] == 'on'
                                || $admin_payment_setting['is_yookassa_enabled'] == 'on' || $admin_payment_setting['is_midtrans_enabled'] == 'on'
                                || $admin_payment_setting['is_xendit_enabled'] == 'on')

                                @if(\Auth::user()->type != 'super admin')

                                    @if($plan->id != \Auth::user()->plan)
                                        @if($plan->price > 0)
                                            <a href="{{route('stripe',\Illuminate\Support\Facades\Crypt::encrypt($plan->id))}}" class="btn btn-primary btn-icon m-1">{{__('Buy Plan')}}</a>
                                        @endif
                                    @endif
                                    @if($plan->id != 1 && $plan->id != \Auth::user()->plan)
                                        @if(\Auth::user()->requested_plan != $plan->id)
                                            <a href="{{ route('send.request',[\Illuminate\Support\Facades\Crypt::encrypt($plan->id)])}}" class="btn btn-primary btn-icon m-1" data-title="{{__('Send Request')}}" data-bs-toggle="tooltip" title="{{__('Send Request')}}">
                                                <span class="btn-inner--icon"><i class="ti ti-corner-up-right"></i></span>
                                            </a>
                                        @else
                                            <a href="{{ route('request.cancel',\Auth::user()->id) }}" class="btn btn-danger btn-icon m-1" data-title="{{__('`Cancle Request')}}" data-bs-toggle="tooltip" title="{{__('Cancle Request')}}">
                                                <span class="btn-inner--icon"><i class="ti ti-x"></i></span>
                                            </a>
                                        @endif
                                    @endif
                                @endif
                            @endif
                        @endif


                        @if(\Auth::user()->type =='company' && \Auth::user()->plan == $plan->id)
                            <p class="display-total-time text-dark mb-0">
                                {{__('Plan Expired : ') }} {{!empty(\Auth::user()->plan_expire_date) ? \Auth::user()->dateFormat(\Auth::user()->plan_expire_date):'lifetime'}}
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Order st --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                            <tr>
                                <th>{{__('Order Id')}}</th>
                                <th>{{__('Name')}}</th>
                                <th>{{__('Plan Name')}}</th>
                                <th>{{__('Price')}}</th>
                                <th>{{__('Status')}}</th>
                                <th>{{__('Payment Type')}}</th>
                                <th>{{__('Date')}}</th>
                                <th>{{__('Coupon')}}</th>
                                <th>{{__('Invoice')}}</th>
                                @if(\Auth::user()->type == 'super admin')
                                <th>{{__('Action')}}</th>
                                @endif
                            </tr>
                            </thead>

                            <tbody>
                            @php
                                $path =\App\Models\Utility::get_file('uploads/order');
                            @endphp
                            @foreach($orders as $order)
                                <tr>
                                    <td>{{$order->order_id}}</td>
                                    <td>{{$order->user_name}}</td>
                                    <td>{{$order->plan_name}}</td>
                                    <td>{{isset($admin_payment_setting['currency_symbol']) ? $admin_payment_setting['currency_symbol'] : '$'}}{{number_format($order->price)}}</td>

                                    <td>
                                        @if($order->payment_status == 'success' || $order->payment_status == 'Approved')
                                            <span class="status_badge badge bg-primary p-2 px-3 rounded">{{ucfirst($order->payment_status)}}</span>
                                        @elseif($order->payment_status == 'succeeded')
                                            <span class="status_badge badge bg-primary p-2 px-3 rounded">{{__('Success')}}</span>
                                        @elseif($order->payment_status == 'Pending')
                                            <span class="status_badge badge bg-warning p-2 px-3 rounded">{{__('Pending')}}</span>
                                        @else
                                            <span class="status_badge badge bg-danger p-2 px-3 rounded">{{ucfirst($order->payment_status)}}</span>
                                        @endif
                                    </td>
                                    <td>{{$order->payment_type}}</td>
                                    <td>{{$order->created_at->format('d M Y')}}</td>
                                    <td class="text-center">
                                        {{!empty($order->total_coupon_used)? !empty($order->total_coupon_used->coupon_detail)?$order->total_coupon_used->coupon_detail->code:'-':'-'}}
                                    </td>
                                    <td class="Id">
                                        @if($order->payment_type=='Manually')
                                            <p>{{__('Manually plan upgraded by Super Admin')}}</p>
                                        @elseif($order->receipt =='free coupon')
                                            <p>{{__('Used 100 % discount coupon code.')}}</p>
                                        @elseif($order->payment_type=='STRIPE')
                                            <a href="{{$order->receipt}}" target="_blank">
                                                <i class="ti ti-file-invoice"></i> {{__('Receipt')}}
                                            </a>
                                        @elseif(!empty( $order->receipt) && $order->payment_type=='Bank Transfer')
                                            <a href="{{ $path . '/' . $order->receipt }}" target="_blank">
                                                <i class="ti ti-file-invoice"></i> {{__('Receipt')}}
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    @if(\Auth::user()->type == 'super admin')
                                        <td class="Action">
                                            @if($order->payment_type =='Bank Transfer' && $order->payment_status == 'Pending')
                                            <span>
                                                 <div class="action-btn bg-warning">
                                                    <a href="#" data-url="{{ URL::to('order/'.$order->id.'/action') }}" data-size="lg"
                                                       data-ajax-popup="true" data-title="{{__('Payment Status')}}" class="mx-3 btn btn-sm align-items-center"
                                                       data-bs-toggle="tooltip" title="{{__('Payment Status')}}" data-original-title="{{__('Payment Status')}}">
                                                        <i class="ti ti-caret-right text-white"></i>
                                                    </a>
                                                 </div>
                                            </span>
                                            @endif
                                            <span>
                                                <div class="action-btn bg-danger ms-2">
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['order.destroy', $order->id],'id'=>'delete-form-'.$order->id]) !!}
                                                         <a href="#" class="mx-3 btn btn-sm align-items-center bs-pass-para" data-bs-toggle="tooltip"
                                                            title="{{__('Delete')}}" data-original-title="{{__('Delete')}}"
                                                            data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}"
                                                            data-confirm-yes="document.getElementById('delete-form-{{$order->id}}').submit();">
                                                             <i class="ti ti-trash text-white"></i>
                                                         </a>
                                                    {!! Form::close() !!}
                                                </div>
                                            </span>
                                        </td>

                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Order en --}}
@endsection
