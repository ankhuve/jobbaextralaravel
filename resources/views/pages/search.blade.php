@extends('app')
@section('content')
    <div class="container">
        <div class="row">
            {!! Form::open(array('url' => 'search', 'method' => 'get', 'id' => 'searchForm')) !!}
            <div class="searchBar searchPage">
                <div id="orangeBG" class="searchPage">
                    {!! Form::text('q', '', array('class'=>'jobSearchForm searchPage', 'placeholder'=>'Hitta ett jobb',
                    'autofocus'=>'autofocus', 'id' => 'keyword')) !!}
                    <span id="searchBarIcon" class="searchPage"></span>

                    {!! Form::submit('SÖK', array('class'=>'searchButton searchPage', 'onsubmit' =>
                    'setSearchParameters()')) !!}
                </div>
                <div class="filters">
                    @if (isset($searchOptions))
                        @foreach($searchOptions as $category)
                            @if ($category->soklista->listnamn==='yrkesomraden')
                                <select name="{{ $category->soklista->listnamn }}" class="dropdown searchFilter" id="workArea">
                                    <option class="defaultOption" value=''>Välj ett yrkesområde..</option>
                            @elseif($category->soklista->listnamn==='lan')
                                <select name="{{ $category->soklista->listnamn }}" class="dropdown searchFilter" id="county">
                                    <option class="defaultOption" value=''>Välj ett län..</option>
                            @endif
                            @foreach($category->soklista->sokdata as $option)
                                <option value={{ $option->id }} label='{{ $option->namn }}'
                                        name='{{ $option->namn }}'>{{ $option->namn }}</option>
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
                    <div id="resetFilters" onclick="resetFilters()" class="searchButton resetFilters"
                         title="Återställ alla filter">
                        <span class="glyphicon glyphicon-trash"></span>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}

        </div>

        @include('pages.partials.searchresults')

    </div>

    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/0.12.1/vue.js"></script>--}}
    <script src="/js/jquery.js"></script>
    <script src="/js/search.js"></script>

@endsection