@if(!empty($user))
    <div class="h4">
        Du är inloggad som {{ $user->email }}. För att skapa jobbannonser måste du vara en administratör.
        <br/><br/>
        {{--Ditt konto är registrerat som en {{ $user->role === 1 ? 'privatperson' : 'administratör.' }}.<br/><br/>--}}
    </div>
@elseif(empty($user))

    <div class="h4">
        Du måste ha ett företagskonto för att skapa jobbannonser.
        <br><br>
        <a class="btn-link" href="{{ action('ContactController@create') }}">Kontakta oss</a> så löser vi det!
        <br/><br/>
        {{--Ditt konto är registrerat som en {{ $user->role === 1 ? 'privatperson' : 'administratör.' }}.<br/><br/>--}}
    </div>

@endif