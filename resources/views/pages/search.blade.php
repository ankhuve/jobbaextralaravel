@extends('app')
@section('content')
    <center>
        <div class="searchBar searchPage">
                <div id="orangeBG" class="searchPage">

                {!! Form::open(array('url' => 'search', 'method' => 'get')) !!}
                    {!! Form::text('q', '', array('class'=>'jobSearchForm searchPage', 'placeholder'=>'Hitta ett jobb', 'autofocus'=>'autofocus')) !!}
                    <span id="searchBarIcon" class="searchPage"></span>
                    <!-- Loading spinner -->
                    {{--<div class="spinner">--}}
                        {{--<div class="spinner-container container1">--}}
                            {{--<div class="circle1"></div>--}}
                            {{--<div class="circle2"></div>--}}
                            {{--<div class="circle3"></div>--}}
                            {{--<div class="circle4"></div>--}}
                        {{--</div>--}}
                        {{--<div class="spinner-container container2">--}}
                            {{--<div class="circle1"></div>--}}
                            {{--<div class="circle2"></div>--}}
                            {{--<div class="circle3"></div>--}}
                            {{--<div class="circle4"></div>--}}
                        {{--</div>--}}
                        {{--<div class="spinner-container container3">--}}
                            {{--<div class="circle1"></div>--}}
                            {{--<div class="circle2"></div>--}}
                            {{--<div class="circle3"></div>--}}
                            {{--<div class="circle4"></div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {!! Form::submit('SÖK', array('class'=>'searchButton searchPage')) !!}

                    <div class="filters">
                        @if (isset($searchOptions))
                            @foreach($searchOptions as $category)
                                <select name="{{ $category->soklista->listnamn }}" class="dropdown searchFilter">
                                    @if ($category->soklista->listnamn==='yrkesomraden')
                                        <option class="defaultOption" value=''>Välj ett yrkesområde..</option>
                                    @elseif($category->soklista->listnamn==='lan')
                                        <option class="defaultOption" value=''>Välj ett län..</option>
                                    @endif
                                    @foreach($category->soklista->sokdata as $option)
                                        <option value={{ $option->id }} label='{{ $option->namn }}' name='{{ $option->namn }}'>{{ $option->namn }}</option>
                                    @endforeach
                                </select>
                            @endforeach
                    </div>
                    @endif

                    <div class="filterButtons">
                        <div onclick="toggleFilters()" class="searchButton filterButton searchPage">
                            <p>Filtrera</p> <br/>
                            <span id="filterToggleArrow" class="glyphicon glyphicon-chevron-down"></span>
                        </div>
                        <div id="resetFilters" onclick="resetFilters()" class="searchButton resetFilters" title="Återställ alla filter">
                            <span class="glyphicon glyphicon-trash"></span>
                        </div>
                    </div>

                {!! Form::close() !!}
            </div>
        </div>
        @if (!empty($jobs))
            <div id="numSearchResults">
                <h4>Antal sökträffar: {{ $jobs->matchningslista->antal_platsannonser }}</h4>
            </div>
        @endif
    </center>

        @if (array_key_exists('matchningdata', $jobs->matchningslista))
            @foreach($jobs->matchningslista->matchningdata as $job)
                @include('pages.partials.jobbpuff')
            @endforeach
            {{--<div class="pageSelector" >--}}
                {{--<button class="pageSelectorButton"><span class="glyphicon glyphicon-backward"></span>pageNavButtonText().first</button>--}}
                {{--<button class="pageSelectorButton"><span class="glyphicon glyphicon-chevron-left"></span>pageNavButtonText().previous</button>--}}
                {{--<span class="viewingPageNumber">pageNavButtonText().infoText</span>--}}
                {{--<button class="pageSelectorButton">pageNavButtonText().next<span class="glyphicon glyphicon-chevron-right"></span></button>--}}
                {{--<button class="pageSelectorButton">pageNavButtonText().last <span class="glyphicon glyphicon-forward"></span></button>--}}
            {{--</div>--}}
        @endif

    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/0.12.1/vue.js"></script>--}}
    <script src="/js/jquery.js"></script>
    <script src="/js/search.js"></script>
    <script src="/js/getJobDescriptions.js"></script>

@endsection