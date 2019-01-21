<div class="block block--profiled-job col-lg-4 col-md-6 col-xs-12">
    <div class="row">
        <div class="col-xs-12 col-md-7">
            <div class="block__tag--top">
                <span class="text-small">Profilerat jobb</span>
            </div>
        </div>
    </div>

    <a href="{{ action('JobController@customJob', [$job->id, str_slug($job->title)]) }}" >
        <div class="block__upper">

                <div class="logo">
                    @if(\App\User::find($job->user_id)->logo_path)
                        <div class="logo-img" style="background-image: url('{{ env("UPLOADS_URL") }}/{{ \App\User::find($job->user_id)->logo_path }}')"></div>
                    @else
                        <div class="logo-img" style="background-image: url('{{ asset("images/colored/jobbmedia.png") }}')"></div>
                    @endif

                </div>

        </div>

        <div class="block__lower">
            <div class="block__title">
                <h2>{{ $job->profiledJob->title ? : $job->title }}</h2>
            </div>

            <div class="block__bottom-info--left">
                <img class="icon--small" src="{{ asset('images/map-pin_secondary.png') }}"/>
                <span class="text-small">{{ $job->municipality }}</span>
            </div>

            <div class="block__bottom-info--right" title="Sista ansökningsdatum för jobbet.">
                <img class="icon--small" src="{{ asset('images/calendar_secondary.png') }}"/>
                <span class="text-small date">{{ $job->latest_application_date }}</span>
            </div>
        </div>
    </a>
</div>