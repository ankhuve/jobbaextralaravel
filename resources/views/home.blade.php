@extends('app')

@section('content')
    <center>

        <div class="searchBar">
            <div id="orangeBG">

                <form novalidate>
                    <input class="jobSearchForm" placeholder="Hitta ett jobb" autofocus="autofocus"></input>
                    <button class="searchButton">SÖK</button>
                </form>

            </div>
            <span id="searchBarIcon"></span>
        </div>

        <div id="splash">
            <h2 id="splashText">Vi letar efter dig</h2>
        </div>
    </center>
    <center>
        <div class="container full-width">
            <div class="infoBoxes">
                <div class="boxAndButton" id="userInfo">
                    <div class="infoBox" >
                        <div id="infoBoxTitle">
                            <h3 class="infoTitle"><span class="underlined">Jobbsökande</span>?</h3>
                        </div>
                        <p class="infoDescription">Här kan man ha massa bra information för de som letar jobb. Man kan skriva att de kan lägga upp sitt CV osv. Bli medlem på den här sidan och få en massa jobb. <br/><br/>Typiskt najs att göra det.</p>
                    </div>
                    <div id="registerUser">
                        <a><button class="registerButton" >Skapa din profil</button></a>
                        <br/>
                        <span class="alreadyJoined">Redan medlem? <a class="loginLink">Logga in!</a></span>
                    </div>
                </div>

                <div class="boxAndButton" id="companyInfo">
                    <div class="infoBox" >
                        <div id="infoBoxTitle">
                            <h3 class="infoTitle"><span class="underlined">Arbetsgivare</span>?</h3>
                        </div>
                        <p class="infoDescription">Här kan man ha massa bra information för de som letar jobb. Man kan skriva att de kan lägga upp sitt CV osv. Bli medlem på den här sidan och få en massa jobb. <br/><br/>Typiskt najs att göra det.</p>
                    </div>
                    <div class="registerCompany" id="registerCompany">
                        <a><button class="registerButton">Registrera ditt företag</button></a>
                        <br/>
                        <span class="alreadyJoined">Redan kund? <a class="loginLink" >Logga in!</a></span>
                    </div>
                </div>
            </div>

            <!-- div class="latestJobs">
			<div id="jobsTitle">
				<h3 class="infoTitle underlined">De senaste jobben</h3>
			</div>
			<p id="placeholder">PLACEHOLDER</p>
		</div> -->
        </div>

    </center>
@endsection
