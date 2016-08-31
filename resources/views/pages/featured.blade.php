@extends('app')

@section('content')
        <div class="row">
            <div class="panel panel-custom col-lg-8 col-lg-offset-2">
                <div class="panel-heading">
                    <h2>
                        Attraktiva Arbetsgivare
                    </h2>
                </div>
                <div class="panel-body">

                    @if(isset($companies))
                        @foreach($companies as $company)
                            @if($company->hasPresentation())
                                @include('pages.partials.featuredpuff')
                            @endif
                        @endforeach
                    @endif


                </div>
            </div>
        </div>
@endsection