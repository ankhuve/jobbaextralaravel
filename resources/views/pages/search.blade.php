@extends('app')
@section('content')
    <div class="container">
        <div class="row">
            {!! Form::open(array('url' => 'search', 'method' => 'get')) !!}
            <div class="searchBar searchPage">
                <div id="orangeBG" class="searchPage">
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
                </div>
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
                    @endif
                </div>
                <div class="filterButtons">
                    <div onclick="toggleFilters()" class="searchButton filterButton searchPage">
                        <p>Filtrera</p> <br/>
                        <span id="filterToggleArrow" class="glyphicon glyphicon-chevron-down"></span>
                    </div>
                    <div id="resetFilters" onclick="resetFilters()" class="searchButton resetFilters" title="Återställ alla filter">
                        <span class="glyphicon glyphicon-trash"></span>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
            @if (!empty($jobs))
                <div id="numSearchResults">
                    <h4>Antal sökträffar: {{ $jobs->matchningslista->antal_platsannonser }}</h4>
                </div>
            @endif
        </div>

            @if (array_key_exists('matchningdata', $jobs->matchningslista))
                <div class="searchResults row">
                    @foreach($jobs->matchningslista->matchningdata as $job)
                        @include('pages.partials.jobbpuff')
                    @endforeach

                </div>
                <div class="pageSelector" >
                    <button onclick="paginate(1)" class="pageSelectorButton"><span class="glyphicon glyphicon-backward"></span></button>
                    <button onclick="paginate(-1)" class="pageSelectorButton"><span class="glyphicon glyphicon-chevron-left"></span></button>
                    <span class="viewingPageNumber">Sida 1</span>
                    <button onclick="paginate(+1)" class="pageSelectorButton"><span class="glyphicon glyphicon-chevron-right"></span></button>
                    <button onclick="paginate('last')" class="pageSelectorButton"><span class="glyphicon glyphicon-forward"></span></button>
                </div>
            @endif
    </div>

    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/0.12.1/vue.js"></script>--}}
    <script src="/js/jquery.js"></script>
    <script src="/js/paginate.js"></script>
    <script src="/js/search.js"></script>
    <script src="/js/getJobDescriptions.js"></script>

@endsection