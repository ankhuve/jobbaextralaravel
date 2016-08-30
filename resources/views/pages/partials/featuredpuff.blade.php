<a href="{{ action('FeaturedController@featured', $company->id) }}">
    <div class="col-md-6">
        <div class="puff puff-featured">
            <div class="puff-heading">
                <div class="{{ !empty($company->user->logo_path) ? 'col-md-8' : 'col-md-12' }} puff-content">
                    {{ $company->user->name }}
                </div>
                @if(!empty($company->user->logo_path))
                    <div class="col-md-4">
                        <div class="logo-holder">
                            <div class="heading-img" style="background-image: url('{{ env("UPLOADS_URL") }}/{{ $company->user->logo_path }}')"></div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</a>