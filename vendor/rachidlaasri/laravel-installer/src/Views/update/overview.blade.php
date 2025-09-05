<<<<<<< HEAD
@extends('vendor.installer.layouts.master-update')

@section('title', trans('installer_messages.updater.welcome.title'))
@section('container')
    <p class="paragraph text-center">{{ trans_choice('installer_messages.updater.overview.message', $numberOfUpdatesPending, ['number' => $numberOfUpdatesPending]) }}</p>
    <div class="buttons">
        <a href="{{ route('LaravelUpdater::database') }}" class="button">{{ trans('installer_messages.updater.overview.install_updates') }}</a>
    </div>
@stop
=======
@extends('vendor.installer.layouts.master-update')

@section('title', trans('installer_messages.updater.welcome.title'))
@section('container')
    <p class="paragraph text-center">{{ trans_choice('installer_messages.updater.overview.message', $numberOfUpdatesPending, ['number' => $numberOfUpdatesPending]) }}</p>
    <div class="buttons">
        <a href="{{ route('LaravelUpdater::database') }}" class="button">{{ trans('installer_messages.updater.overview.install_updates') }}</a>
    </div>
@stop
>>>>>>> f39eb1854d2944c0ca39f812f88e829928281819
