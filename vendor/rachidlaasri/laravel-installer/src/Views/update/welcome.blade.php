<<<<<<< HEAD
@extends('vendor.installer.layouts.master-update')

@section('title', trans('installer_messages.updater.welcome.title'))
@section('container')
    <p class="paragraph text-center">
    	{{ trans('installer_messages.updater.welcome.message') }}
    </p>
    <div class="buttons">
        <a href="{{ route('LaravelUpdater::overview') }}" class="button">{{ trans('installer_messages.next') }}</a>
    </div>
@stop
=======
@extends('vendor.installer.layouts.master-update')

@section('title', trans('installer_messages.updater.welcome.title'))
@section('container')
    <p class="paragraph text-center">
    	{{ trans('installer_messages.updater.welcome.message') }}
    </p>
    <div class="buttons">
        <a href="{{ route('LaravelUpdater::overview') }}" class="button">{{ trans('installer_messages.next') }}</a>
    </div>
@stop
>>>>>>> f39eb1854d2944c0ca39f812f88e829928281819
