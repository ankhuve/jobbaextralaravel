<a href="{{ action('JobController@index', $job->id) }}">
    <div class="jobBlock col-md-6">
        <div class="upperInfo">
            <h1 class="text-center">{{ $job->title }}</h1>
            <h2 class="text-center"><i>{{ $job->work_place }}</i></h2>
            <div class="jobShortDescription">{{ (strlen($job->description)<200) ? $job->description : substr($job->description, 0, 200)." ..." }}</div>
        </div>

        <div class="bottomInfo">
            <div class="col-xs-4">
                <img src="img/map_pin.png"/>
                <span>{{ $job->municipality }}</span>
            </div>
            <div class="col-xs-4">
                <img src="img/time_ago.png"/>
                <span>{{ $job->created_at->format('Y-m-d') }}</span>
            </div>
            <div class="col-xs-4">
                <img src="img/calendar.png"/>
                <span>{{ $job->created_at->format('Y-m-d') }}</span>
            </div>
        </div>
    </div>
</a>