@extends('app')
@section('content')
    <center>
        <div class="searchBar searchPage">
            <div id="orangeBG" class="searchPage">
                {!! Form::open() !!}

                    <input class="jobSearchForm searchPage" placeholder="Hitta ett jobb" autofocus="autofocus"/>
                    <span id="searchBarIcon" class="searchPage"></span>
                    <!-- Loading spinner -->
                    <div class="spinner">
                        <div class="spinner-container container1">
                            <div class="circle1"></div>
                            <div class="circle2"></div>
                            <div class="circle3"></div>
                            <div class="circle4"></div>
                        </div>
                        <div class="spinner-container container2">
                            <div class="circle1"></div>
                            <div class="circle2"></div>
                            <div class="circle3"></div>
                            <div class="circle4"></div>
                        </div>
                        <div class="spinner-container container3">
                            <div class="circle1"></div>
                            <div class="circle2"></div>
                            <div class="circle3"></div>
                            <div class="circle4"></div>
                        </div>
                    </div>
                    <button role="submit" class="searchButton searchPage">SÖK</button>

                    <div class="filters">
                        <select class="dropdown searchFilter">
                        </select>

                        <select class="dropdown searchFilter municipalitySelect">
                        </select>

                        <select class="dropdown searchFilter linesOfWorkSelect">
                        </select>

                        <select class="dropdown searchFilter professionSelect">
                        </select>
                    </div>

                    <div class="filterButtons">
                        <div class="searchButton filterButton searchPage">
                            <p>Filtrera</p> <br/>
                            <span id="filterToggleArrow" class="glyphicon glyphicon-chevron-down"></span>
                        </div>
                        <div class="searchButton resetFilters" title="Återställ alla filter">
                            <span class="glyphicon glyphicon-trash"></span>
                        </div>
                    </div>

                {!! Form::close() !!}
            </div>
        </div>
        <br/>
        <div id="numSearchResults">
            <h4>Antal sökträffar: antalAnnonser</h4>
        </div>
    </center>

    {{--<div class="jobsContainer">--}}
        {{--<div >--}}
            {{--<a href="#/job" >--}}
                {{--<div class="jobBlock">--}}
                    {{--<p>--}}
                        {{--<h4>--}}
                            {{--<small>--}}
                                {{--job.kommunnamn--}}
                            {{--</small>--}}
                            {{--job.arbetsplatsnamn--}}
                        {{--</h4>--}}
                    {{--job.annonsrubrik--}}
                    {{--</p>--}}
                    {{--<div class="publishDate">--}}
                        {{--Publicerad job.publiceraddatum | date:'yyyy-MM-dd'--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</a>--}}
        {{--</div>--}}
    {{--</div>--}}
    {{--<div class="pageSelector" >--}}
        {{--<button class="pageSelectorButton"><span class="glyphicon glyphicon-backward"></span>pageNavButtonText().first</button>--}}
        {{--<button class="pageSelectorButton"><span class="glyphicon glyphicon-chevron-left"></span>pageNavButtonText().previous</button>--}}
        {{--<span class="viewingPageNumber">pageNavButtonText().infoText</span>--}}
        {{--<button class="pageSelectorButton">pageNavButtonText().next<span class="glyphicon glyphicon-chevron-right"></span></button>--}}
        {{--<button class="pageSelectorButton">pageNavButtonText().last <span class="glyphicon glyphicon-forward"></span></button>--}}
    {{--</div>--}}


@endsection
