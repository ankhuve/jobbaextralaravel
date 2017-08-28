<template>
    <div>
        <div class="numSearchResults">
            <h4 v-show="jobsObj.searchMeta">Antal sökträffar:
                <span id="numberOfJobMatches">{{ jobsObj.searchMeta ? jobsObj.searchMeta.all : "" }}</span>
            </h4>
        </div>

        <div class="searchResults row">
            <div v-for="job in jobsObj.allJobs" transition="stagger" enter-stagger="25">
                <custom-job-puff :job-data="job" v-if="!job.annonsid"></custom-job-puff>
                <job-puff :job-data="job" v-if="job.annonsid"></job-puff>
            </div>
        </div>

        <template v-if="jobsObj.paginator && jobsObj.paginator.data.length === 0">
            <div class="numSearchResults">
                <h4>Inga fler jobb hittades!</h4>
            </div>
        </template>

        <div v-show="!showJobs && !errorOccurred">
            <div class="row">
                <div class="spinner">
                    <div class="bounce1"></div>
                    <div class="bounce2"></div>
                    <div class="bounce3"></div>
                </div>
            </div>
            <div v-if="slowLoading" class="row" transition="stagger" align="center">
                <br>
                <h4 class="text-shadow">(Sökningen verkar gå långsammare än vanligt..)</h4>
                <br>
                <div class="col-md-4 col-md-offset-4" >
                    <button class="btn btn-primary btn-sm" @click="fetchJobs">Prova igen</button>
                </div>
            </div>
        </div>

        <div v-if="errorOccurred" class="row text-center" transition="stagger">
            <div class="messageBox">
                <div class="messageBoxHeading">Hoppsan!</div>
                <div class="panel-body">
                    <div class="h4">
                        Något gick visst snett vid sökningen.
                        <br><br>
                        <div class="col-md-4 col-md-offset-4">
                            <button class="btn btn-primary btn-sm" @click="fetchJobs">Försök igen</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="pagination" v-show="showPagination">
            <div class="row">
                <div class="col-xs-12" align="center">
                    {{{ jobsObj.paginatorMarkup }}}
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        created() {
            if(this.jobsObj.length === 0){
                this.fetchJobs();
            }

            window.addEventListener('popstate', e => {
                var state = e.state;
                this.fetchJobs();
            });
        },

        data: function() {
            return {
                jobsObj: [],
                currPage: null,
                showPagination: false,
                showJobs: false,
                infoText: 'Inga fler jobb hittades!',
                errorOccurred: false,
                slowLoading: false,
                slowLoadingTimeout: null,
                previousRequest: null,
                parameters: {
                    'sida': '',
                    'lan': '',
                    'q': '',
                    'yrkesomradeid': ''
                }
            }
        },
        methods: {
            fetchJobs: function(){
                this.resetStates();

                $('html, body').animate({
                    scrollTop: window.screenTop
                }, 500);

                this.currPage = this.getUrlParameterByName('sida');

                var parameters = {};
                for (var p in this.parameters){
                    parameters[p] = this.getUrlParameterByName(p);
                }

                var url = 'api/fetchJobs';
                this.slowLoadingTimeout = setTimeout(() => {
                    if (!this.errorOccurred || !this.showJobs) {
                        this.slowLoading = true;
                    }
                }, 5000);

                this.fetchJobsRequest = this.$http.post(url, parameters, {
                    // use before callback
                    before(request) {

                        // abort previous request, if exists
                        if (this.previousRequest) {
                            this.previousRequest.abort();
                        }

                        // set previous request on Vue instance
                        this.previousRequest = request;
                    }
                }).then((response) => {
                        try {
                            this.jobsObj = response.json();
                            this.showJobs = true;

                            setTimeout(() => {
                                this.showPagination = true;
                                Vue.nextTick(() => {
                                    this.setPaginationEventListeners();
                                });
                            }, 500);
                        } catch (e) {
                            console.log('Error fetching jobs');
                            this.errorOccurred = true;
                        }

                    },
                    (response) => {
                        console.log('Error fetching jobs');
                        this.errorOccurred = true;
                    });
            },

            resetStates: function() {
                this.showJobs = false;
                this.errorOccurred = false;
                this.showPagination = false;
                this.slowLoading = false;
                this.jobsObj = {};

                if (this.slowLoadingTimeout) {
                    clearTimeout(this.slowLoadingTimeout);
                }
            },

            getUrlParameterByName: function(name, url){
                if (!url) url = window.location.href;
                name = name.replace(/[\[\]]/g, "\\$&");
                var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
                    results = regex.exec(url);
                if (!results) return null;
                if (!results[2]) return '';
                return decodeURIComponent(results[2].replace(/\+/g, " "));
            },

            setPaginationEventListeners: function(){
                var links = document.querySelectorAll("ul.pagination > li > a");

                for(var i = 0; i < links.length; i++){
                    links[i].addEventListener("click", e => {
                        e.preventDefault();

                        // add the correct parameters to the url
                        var queryString = "";
                        var count = 0;
                        for (var p in this.parameters){
                            if (this.getUrlParameterByName(p, e.target)) {
                                if (count === 0) {
                                    queryString += '?' + p + '=' + this.getUrlParameterByName(p, e.target);
                                } else {
                                    queryString += '&' + p + '=' + this.getUrlParameterByName(p, e.target);
                                }
                            }
                            count++;
                        }

                        window.history.pushState(null, null, queryString);
                        this.fetchJobs();
                    })
                }
            }
        }
    }
</script>
