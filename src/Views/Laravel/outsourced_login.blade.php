@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div id="applications-loading" class="none">Carregando informações ...</div>

                <div class="card-body" id="applications-box">
                    @if(!empty($applications))
                    @foreach($applications as $app)
                    <div class="card">
                        <div class="card-body">
                            <a class="application"
                               href="{{ route('slugs', [
                                           'app' => $app->getId(),
                                           'login_route' => $app->getLoginRoute()]) }}">{{ $app->getName() }}</a>

                            <div class="content-slugs"></div>
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
<link type="stylesheet" href="{{ asset(\Zevitagem\LegoAuth\Helpers\Helper::getGeneralAdapter()->getAssetsPath().'/outsourced_login.css') }}"></link>
@endsection

@section('js')
<script type="text/javascript" src="{{ asset(\Zevitagem\LegoAuth\Helpers\Helper::getGeneralAdapter()->getAssetsPath().'/outsourced_login.js') }}" defer></script>
@endsection