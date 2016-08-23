<div class="col-md-12 newJobContainer">
    <div class="messageBoxHeading">{{ $data['title'] }}</div>
    <div class="panel-body">
        <p style="white-space: pre-line">{!! $data['description'] !!}</p>
    </div>
    <div class="moreInfo">
        {{--<p class="extraJobInfo"> Varaktighet: {{ $jobMatch->villkor->varaktighet }} </p>--}}
        <p class="extraJobInfo"> Kommun:  {{ $data['municipality'] }}</p>
        {{--<p class="extraJobInfo"> Publicerad: {{ date('d-m-Y', strtotime($jobMatch->annons->publiceraddatum)) }} </p>--}}
        {{--<p class="extraJobInfo"> Dagar sedan publicering: {{ $daysSincePublished }} </p>--}}
        {{--<p class="extraJobInfo"><a href="{{ $jobMatch->annons->platsannonsUrl }}">Länk till arbetsförmedlingen</a></p>--}}
        <div>Kontaktadress: {{ $data['contact_email'] }}</div>
        <div class="extraJobInfo">Sista ansökningsdag: {{ $data['latest_application_date'] }}</div>
    </div>
</div>