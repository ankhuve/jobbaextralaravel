@extends('app')

@section('content')

    <div class="container">

        @foreach($content as $block)
            <div class="panel panel-custom col-lg-10 col-lg-offset-1">
                <div class="panel-heading">
                    <h2>
                        {{ $block->title }}
                    </h2>
                </div>

                <div class="panel-body">
                    <div class="well well-custom">
                        <p style="white-space: pre-line">
                            {{ $block->content }}
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection