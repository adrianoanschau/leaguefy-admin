@if($error = Session::get('error'))
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-bs-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon icon-ban"></i>{{ \Illuminate\Support\Arr::get($error->get('title'), 0) }}</h4>
        <p>{!!  \Illuminate\Support\Arr::get($error->get('message'), 0) !!}</p>
    </div>
@elseif ($errors = Session::get('errors'))
    @if ($errors->hasBag('error'))
      <div class="alert alert-danger alert-dismissable">

        <button type="button" class="close" data-bs-dismiss="alert" aria-hidden="true">×</button>
        @foreach($errors->getBag("error")->toArray() as $message)
            <p>{!!  \Illuminate\Support\Arr::get($message, 0) !!}</p>
        @endforeach
      </div>
    @endif
@endif

@if($success = Session::get('success'))
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-bs-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon icon-check"></i>{{ \Illuminate\Support\Arr::get($success->get('title'), 0) }}</h4>
        <p>{!!  \Illuminate\Support\Arr::get($success->get('message'), 0) !!}</p>
    </div>
@endif

@if($info = Session::get('info'))
    <div class="alert alert-info alert-dismissable">
        <button type="button" class="close" data-bs-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon icon-info"></i>{{ \Illuminate\Support\Arr::get($info->get('title'), 0) }}</h4>
        <p>{!!  \Illuminate\Support\Arr::get($info->get('message'), 0) !!}</p>
    </div>
@endif

@if($warning = Session::get('warning'))
    <div class="alert alert-warning alert-dismissable">
        <button type="button" class="close" data-bs-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon icon-exclamation-triangle"></i>{{ \Illuminate\Support\Arr::get($warning->get('title'), 0) }}</h4>
        <p>{!!  \Illuminate\Support\Arr::get($warning->get('message'), 0) !!}</p>
    </div>
@endif
