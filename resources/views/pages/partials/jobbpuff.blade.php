<div class="jobBlock col-md-6" id="{{ $job->annonsid }}">
    <div class="row">
        <div class="col-xs-12">
            <div class="upperInfo">
                <a href="/job/{{ $job->annonsid }}" >
                    <div class="row">
                        <div class="titles col-xs-12">
                            <h1 class="text-left">{{ $job->arbetsplatsnamn }}</h1>
                            <h2 class="text-left"><i>{{ $job->annonsrubrik }}</i></h2>
                        </div>
                    </div>
                </a>
                <div class="jobShortDescription"></div>
            </div>
        </div>
    </div>

    <div class="bottomInfo">
        <div class="col-xs-5" title="Kommunen där jobbet finns.">
            <img src="{{ asset('build/img/map_pin.png') }}"/>
            <span>{{ $job->kommunnamn }}</span>
        </div>
        <div class="col-xs-4" title="Dagar sedan jobbet publicerades.">
            <img src="{{ asset('build/img/time_ago.png') }}"/>

            <span>
                {{ (\Carbon\Carbon::createFromFormat('Y-m-d\TH:i:se', $job->publiceraddatum)->isSameDay(\Carbon\Carbon::today())) ? 'Idag' : ((\Carbon\Carbon::createFromFormat('Y-m-d\TH:i:se', $job->publiceraddatum)->isSameDay(\Carbon\Carbon::yesterday())) ? 'Igår' : \Carbon\Carbon::createFromFormat('Y-m-d\TH:i:se', $job->publiceraddatum)->startOfDay()->diffInDays(Carbon\Carbon::now()) . ' dagar sedan') }}
            </span>
        </div>
        <div class="col-xs-3" title="Sista ansökningsdatum för jobbet.">
            <img src="{{ asset('build/img/calendar.png') }}"/>
            <span>{{ array_key_exists('sista_ansokningsdag', $job) ? substr($job->sista_ansokningsdag, 0, 10) : '-' }}</span>
        </div>
    </div>
</div>