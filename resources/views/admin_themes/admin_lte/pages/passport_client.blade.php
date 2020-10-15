@extends('admin_themes.admin_lte.master.admin')
@section('page_title', trans('pages.admin_passport_client_title'))
@section('page_description', trans('pages.admin_passport_client_desc'))
@section('page_breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ adminUrl() }}"><i class="fa fa-home"></i> {{ trans('pages.admin_dashboard_title') }}</a></li>
        <li>{{ trans('pages.admin_passport_client_title') }}</li>
    </ol>
@endsection
@section('lib_styles')
    <link rel="stylesheet" href="{{ libraryAsset('default.css') }}">
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
@endsection
@section('lib_scripts')
    <script src="{{ libraryAsset('default.js') }}"></script>
@endsection
@section('page_content')
    <div class="row">
        <div class="col-xs-12">
            <div id="app">
                <passport-clients></passport-clients>
                <passport-authorized-clients></passport-authorized-clients>
                <passport-personal-access-tokens></passport-personal-access-tokens>
            </div>
        </div>
    </div>
@endsection