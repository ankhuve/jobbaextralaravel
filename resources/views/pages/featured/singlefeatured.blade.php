@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-10 col-lg-offset-1 panel panel-custom">
                <div class="panel-heading">
                    <h2>
                        {{ $featured->title }}
                    </h2>
                    @if($featured->subtitle)
                        <h3 class="subheading">
                            <i>
                                {{ $featured->subtitle }}
                            </i>
                        </h3>
                    @endif
                </div>

                <div class="panel-body">

                    {!! $featured->description !!}

                </div>
            </div>
        </div>
    </div>
@endsection