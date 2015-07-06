<div class="jobBlock col-md-6">
    <div class="upperInfo">

            <div class="titles">
                <h1 class="text-left">{{ $job->title }}</h1>
                <h2 class="text-right"><i>{{ $job->work_place }}</i></h2>
            </div>

        <div class="jobShortDescription">{{ (strlen($job->description)<200) ? $job->description : substr($job->description, 0, 200)." ..." }}</div>
    </div>

    <div class="bottomInfo">
        <div class="col-md-4" title="Kommunen där jobbet finns.">
            <img src="/img/map_pin.png"/>
            <span>{{ $job->municipality }}</span>
        </div>
        <div class="col-md-4" title="Dagar sedan jobbet publicerades.">
            <img src="/img/time_ago.png"/>

            <span>{{ $job->created_at->diffInDays(\Carbon\Carbon::now()) < 1 ? 'Idag' : ($job->created_at->diffInDays(\Carbon\Carbon::now()) == 1 ? 'Igår' : ($job->created_at->diffInDays(\Carbon\Carbon::now()).' dagar sedan')) }}</span>
        </div>
        <div class="col-md-4" title="Sista ansökningsdatum för jobbet.">
            <img src="/img/calendar.png"/>
            <span>{{ $job->latest_application_date }}</span>
        </div>
    </div>
</div>