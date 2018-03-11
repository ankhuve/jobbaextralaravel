<div class="jobBlock col-md-6" id="{{ $job->annonsid }}">
    <div class="row">
        <div class="col-xs-12">
            <div class="upperInfo">
                <a href="{{ action('JobController@index', $job->annonsid) }}" >
                    <div class="row">
                        <div class="titles col-xs-12">
                            <h1 class="text-left">{{ $job->annonsrubrik }}</h1>
                            <h2 class="text-left"><i>{{ $job->arbetsplatsnamn }}</i></h2>
                        </div>
                    </div>
                </a>
                <div class="jobShortDescription"></div>
            </div>
        </div>
    </div>

    <div class="bottomInfo">
        <div class="col-xs-5" title="Kommunen där jobbet finns.">
            <img src="{{ asset('images/map_pin.png') }}"/>
            <span>{{ $job->kommunnamn }}</span>
        </div>
        <div class="col-xs-4" title="Dagar sedan jobbet publicerades.">
            <img src="{{ asset('images/time_ago.png') }}"/>

            <span>
                {{ (\Carbon\Carbon::createFromFormat('Y-m-d\TH:i:se', $job->publiceraddatum)->isSameDay(\Carbon\Carbon::today())) ? 'Idag' : ((\Carbon\Carbon::createFromFormat('Y-m-d\TH:i:se', $job->publiceraddatum)->isSameDay(\Carbon\Carbon::yesterday())) ? 'Igår' : \Carbon\Carbon::createFromFormat('Y-m-d\TH:i:se', $job->publiceraddatum)->startOfDay()->diffInDays(Carbon\Carbon::now()) . ' dagar sedan') }}
            </span>
        </div>
        <div class="col-xs-3" title="Sista ansökningsdatum för jobbet.">
            <img src="{{ asset('images/calendar.png') }}"/>
            <span>{{ array_key_exists('sista_ansokningsdag', $job) ? substr($job->sista_ansokningsdag, 0, 10) : '-' }}</span>
        </div>
    </div>
</div>