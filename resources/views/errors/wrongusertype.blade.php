@if(!empty($user))
    <div class="h4">
        Du är inloggad som {{ $user->email }}. För att skapa en jobbannons måste du ha ett företagskonto.
        <br/><br/>
        Ditt konto är registrerat som en {{ $user->role===1 ? 'privatperson' : 'administratör.' }}.<br/><br/>
    </div>
@endif