@if($status && $slugs->count() > 0)
    @foreach($slugs as $slug)
        <div class="card">
            <div class="card-body">
                <a class="slug"
                   href="{{ $route.'?'.\Zevitagem\LegoAuth\Helpers\Helper::createBuildQueryToOutLogin([
                                       'slug' => $slug->getId()
                                   ]) }}">{{ $slug->getName() }}</a>
            </div>
        </div>
    @endforeach
@else
    <div class='alert alert-warning'>Nenhuma especialidade para essa aplicação foi encontrada, infelizmente.</div>
@endif

@if(!empty($message))
    <div class='alert alert-danger'>{{ $message }}</div>
@endif