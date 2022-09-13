@extends($view_prefix . 'layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div id='slugs-box'>
                    @php
                        $totalSlugs = $slugs->count();
                        $uniqueSlug = ($totalSlugs == 1);
                    @endphp

                    <div>
                        @if($slugs->count() > 0)
                            <ul class="list-group">
                                @foreach($slugs as $slug)
                                    <li class="list-group-item"><input {{ ($uniqueSlug) ? 'checked' : '' }} type="radio" name="slug" value="{{ $slug->getId() }}"/> [{{ $slug->getName() }}]</li>
                                @endforeach
                            </ul>
                        @else
                            <div class='alert alert-warning'>Nenhuma especialidade para essa aplicação foi encontrada, infelizmente.</div>
                        @endif
                    </div>
                </div>

                <div id="applications-loading" class="none">Carregando informações ...</div>

                <div class="card-body" id="applications-box">
                    @if(!empty($applications))
                        @foreach($applications as $app)
                        <div class="card">
                            <div class="card-body">
                                <a class="application" href="{{ route('build_out_login_route', ['login_route' => $app->getLoginRoute()]) }}">
                                   {{ $app->getName() }}
                                </a>
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