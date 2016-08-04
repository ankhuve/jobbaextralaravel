@extends('app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="messageBox">
                <div class="messageBoxHeading">Attraktiva Arbetsgivare</div>
                <div class="panel-body">

                    @if(isset($companies))
                        @foreach($companies as $company)

                            <div>
                                <h3>{{ $company->user->name }}</h3>
                                <h3>{{ $company->user->email }}</h3>
                                <h3>{{ $company->user->created_at }}</h3>
                            </div>

                        @endforeach
                    @endif
                    {!! $companies->render() !!}


                </div>
            </div>
        </div>
    </div>
@endsection