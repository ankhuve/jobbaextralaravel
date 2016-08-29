<div class="col-md-6">
    <div class="puff puff-featured">
        <div class="puff-heading">
            <div class="col-md-6 puff-content left">
                {{ $company->user->name }}
            </div>
            <div class="col-md-6">
                @if(!is_null($company->user->logo_path))
                    <div class="heading-img" style="background-image: url('{{ env("UPLOADS_URL") }}/{{ $company->user->logo_path }}')"></div>
                    {{--            <img src="{{ $company->user->logo_path }}" alt="{{ $company->user->name }}">--}}
                @endif
            </div>
        </div>
        {{--<div class="puff-body">--}}
            {{--<a href="{{ action('FeaturedController@featured', $company->id) }}">--}}
                {{--{{ $company->user->name }}--}}
            {{--</a>--}}
        {{--</div>--}}
        {{--<div class="puff-footer">--}}
            {{--<div class="text-left">--}}
                {{--<h4>{{ $company->user->email }}</h4>--}}
            {{--</div>--}}
        {{--</div>--}}
    </div>
</div>
