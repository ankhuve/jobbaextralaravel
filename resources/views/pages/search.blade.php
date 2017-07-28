@extends('app')
@section('content')
    <div class="container">
        <div class="row">
            {!! Form::open(array('url' => action('SearchController@index'), 'method' => 'get', 'id' => 'searchForm')) !!}
            <div class="searchBar searchPage">
                <div id="orangeBG" class="searchPage">
                    {!! Form::text('q', '', array('class'=>'jobSearchForm searchPage', 'placeholder'=>'Hitta ett jobb',
                    'autofocus'=>'autofocus', 'id' => 'keyword')) !!}
                    <span id="searchBarIcon" class="searchPage"></span>

                    {!! Form::submit('SÖK', array('class'=>'searchButton searchPage', 'onsubmit' =>
                    'setSearchParameters()')) !!}
                </div>
                <div class="filters">
                    <label class="sr-only" for="county">Län</label>
                    <select name="lan" class="dropdown searchFilter" id="county">
                        <option value="" class="defaultOption" selected>Alla län</option>
                        <option {{ $request->get('lan') === "155" ? "selected" : "" }} value="155" label="Norge" name="Norge">Norge</option>
                        <option disabled>------</option>
                        <option {{ $request->get('lan') === "10" ? "selected" : "" }} value="10" label="Blekinge län" name="Blekinge län">Blekinge län</option>
                        <option {{ $request->get('lan') === "20" ? "selected" : "" }} value="20" label="Dalarnas län" name="Dalarnas län">Dalarnas län</option>
                        <option {{ $request->get('lan') === "9" ? "selected" : "" }} value="9" label="Gotlands län" name="Gotlands län">Gotlands län</option>
                        <option {{ $request->get('lan') === "21" ? "selected" : "" }} value="21" label="Gävleborgs län" name="Gävleborgs län">Gävleborgs län</option>
                        <option {{ $request->get('lan') === "13" ? "selected" : "" }} value="13" label="Hallands län" name="Hallands län">Hallands län</option>
                        <option {{ $request->get('lan') === "23" ? "selected" : "" }} value="23" label="Jämtlands län" name="Jämtlands län">Jämtlands län</option>
                        <option {{ $request->get('lan') === "6" ? "selected" : "" }} value="6" label="Jönköpings län" name="Jönköpings län">Jönköpings län</option>
                        <option {{ $request->get('lan') === "8" ? "selected" : "" }} value="8" label="Kalmar län" name="Kalmar län">Kalmar län</option>
                        <option {{ $request->get('lan') === "7" ? "selected" : "" }} value="7" label="Kronobergs län" name="Kronobergs län">Kronobergs län</option>
                        <option {{ $request->get('lan') === "25" ? "selected" : "" }} value="25" label="Norrbottens län" name="Norrbottens län">Norrbottens län</option>
                        <option {{ $request->get('lan') === "12" ? "selected" : "" }} value="12" label="Skåne län" name="Skåne län">Skåne län</option>
                        <option {{ $request->get('lan') === "1" ? "selected" : "" }} value="1" label="Stockholms län" name="Stockholms län">Stockholms län</option>
                        <option {{ $request->get('lan') === "4" ? "selected" : "" }} value="4" label="Södermanlands län" name="Södermanlands län">Södermanlands län</option>
                        <option {{ $request->get('lan') === "3" ? "selected" : "" }} value="3" label="Uppsala län" name="Uppsala län">Uppsala län</option>
                        <option {{ $request->get('lan') === "17" ? "selected" : "" }} value="17" label="Värmlands län" name="Värmlands län">Värmlands län</option>
                        <option {{ $request->get('lan') === "24" ? "selected" : "" }} value="24" label="Västerbottens län" name="Västerbottens län">Västerbottens län</option>
                        <option {{ $request->get('lan') === "22" ? "selected" : "" }} value="22" label="Västernorrlands län" name="Västernorrlands län">Västernorrlands län</option>
                        <option {{ $request->get('lan') === "19" ? "selected" : "" }} value="19" label="Västmanlands län" name="Västmanlands län">Västmanlands län</option>
                        <option {{ $request->get('lan') === "14" ? "selected" : "" }} value="14" label="Västra Götalands län" name="Västra Götalands län">Västra Götalands län</option>
                        <option {{ $request->get('lan') === "18" ? "selected" : "" }} value="18" label="Örebro län" name="Örebro län">Örebro län</option>
                        <option {{ $request->get('lan') === "5" ? "selected" : "" }} value="5" label="Östergötlands län" name="Östergötlands län">Östergötlands län</option>
                        <option {{ $request->get('lan') === "90" ? "selected" : "" }} value="90" label="Ospecificerad arbetsort" name="Ospecificerad arbetsort">Ospecificerad arbetsort</option>
                    </select>
                    <select name="{{ config('app.af_type_name_minor') }}" class="dropdown searchFilter" id="workArea">
                        <option class="defaultOption" value="">Alla yrkesgrupper</option>
                        <option {{ $request->get(config('app.af_type_name_minor')) === "1" ? "selected" : "" }} value="1" label="Administration, ekonomi, juridik" name="Administration, ekonomi, juridik">Administration, ekonomi, juridik</option>
                        <option {{ $request->get(config('app.af_type_name_minor')) === "2" ? "selected" : "" }} value="2" label="Bygg och anläggning" name="Bygg och anläggning">Bygg och anläggning</option>
                        <option {{ $request->get(config('app.af_type_name_minor')) === "20" ? "selected" : "" }} value="20" label="Chefer och verksamhetsledare" name="Chefer och verksamhetsledare">Chefer och verksamhetsledare</option>
                        <option {{ $request->get(config('app.af_type_name_minor')) === "3" ? "selected" : "" }} value="3" label="Data/IT" name="Data/IT">Data/IT</option>
                        <option {{ $request->get(config('app.af_type_name_minor')) === "5" ? "selected" : "" }} value="5" label="Försäljning, inköp, marknadsföring" name="Försäljning, inköp, marknadsföring">Försäljning, inköp, marknadsföring</option>
                        <option {{ $request->get(config('app.af_type_name_minor')) === "6" ? "selected" : "" }} value="6" label="Hantverksyrken" name="Hantverksyrken">Hantverksyrken</option>
                        <option {{ $request->get(config('app.af_type_name_minor')) === "7" ? "selected" : "" }} value="7" label="Hotell, restaurang, storhushåll" name="Hotell, restaurang, storhushåll">Hotell, restaurang, storhushåll</option>
                        <option {{ $request->get(config('app.af_type_name_minor')) === "8" ? "selected" : "" }} value="8" label="Hälso- och sjukvård" name="Hälso- och sjukvård">Hälso- och sjukvård</option>
                        <option {{ $request->get(config('app.af_type_name_minor')) === "9" ? "selected" : "" }} value="9" label="Industriell tillverkning" name="Industriell tillverkning">Industriell tillverkning</option>
                        <option {{ $request->get(config('app.af_type_name_minor')) === "10" ? "selected" : "" }} value="10" label="Installation, drift, underhåll" name="Installation, drift, underhåll">Installation, drift, underhåll</option>
                        <option {{ $request->get(config('app.af_type_name_minor')) === "4" ? "selected" : "" }} value="4" label="Kropps- och skönhetsvård" name="Kropps- och skönhetsvård">Kropps- och skönhetsvård</option>
                        <option {{ $request->get(config('app.af_type_name_minor')) === "11" ? "selected" : "" }} value="11" label="Kultur, media, design" name="Kultur, media, design">Kultur, media, design</option>
                        <option {{ $request->get(config('app.af_type_name_minor')) === "22" ? "selected" : "" }} value="22" label="Militärt arbete" name="Militärt arbete">Militärt arbete</option>
                        <option {{ $request->get(config('app.af_type_name_minor')) === "13" ? "selected" : "" }} value="13" label="Naturbruk" name="Naturbruk">Naturbruk</option>
                        <option {{ $request->get(config('app.af_type_name_minor')) === "14" ? "selected" : "" }} value="14" label="Naturvetenskapligt arbete" name="Naturvetenskapligt arbete">Naturvetenskapligt arbete</option>
                        <option {{ $request->get(config('app.af_type_name_minor')) === "15" ? "selected" : "" }} value="15" label="Pedagogiskt arbete" name="Pedagogiskt arbete">Pedagogiskt arbete</option>
                        <option {{ $request->get(config('app.af_type_name_minor')) === "12" ? "selected" : "" }} value="12" label="Sanering och renhållning" name="Sanering och renhållning">Sanering och renhållning</option>
                        <option {{ $request->get(config('app.af_type_name_minor')) === "16" ? "selected" : "" }} value="16" label="Socialt arbete" name="Socialt arbete">Socialt arbete</option>
                        <option {{ $request->get(config('app.af_type_name_minor')) === "17" ? "selected" : "" }} value="17" label="Säkerhetsarbete" name="Säkerhetsarbete">Säkerhetsarbete</option>
                        <option {{ $request->get(config('app.af_type_name_minor')) === "18" ? "selected" : "" }} value="18" label="Tekniskt arbete" name="Tekniskt arbete">Tekniskt arbete</option>
                        <option {{ $request->get(config('app.af_type_name_minor')) === "19" ? "selected" : "" }} value="19" label="Transport" name="Transport">Transport</option>
                        <option {{ $request->get(config('app.af_type_name_minor')) === "9000" ? "selected" : "" }} value="9000" label="Övrigt" name="Övrigt">Övrigt</option>
                    </select>
                </div>
                <div class="filterButtons">
                    <div class="searchButton filterButton searchPage">
                        <p>Filtrera</p> <br/>
                        <span id="filterToggleArrow" class="glyphicon glyphicon-chevron-down"></span>
                    </div>
                    <div id="resetFilters" class="searchButton resetFilters"
                         title="Återställ alla filter">
                        <span class="glyphicon glyphicon-trash"></span>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}

        </div>

        <search-results></search-results>

    </div>
@endsection