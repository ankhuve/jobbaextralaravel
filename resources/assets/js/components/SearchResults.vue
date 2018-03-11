<template>
    <div>
        <div class="numSearchResults">
            <h4 v-show="jobsObj.searchMeta">Antal sökträffar:
                <span id="numberOfJobMatches">{{ jobsObj.searchMeta ? jobsObj.searchMeta.all : "" }}</span>
            </h4>
        </div>

        <div class="searchResults row">
            <transition-group
                    name="stagger"
                    v-bind:css="false"
                    v-on:before-enter="beforeEnter"
                    v-on:enter="enter"
                    v-on:leave="leave"
            >
                <div class="stagger" v-for="(job, index) in jobsObj.allJobs"
                     v-bind:data-index="index"
                     v-bind:key="index"
                >
                    <custom-job-puff :job-data="job" v-if="!job.annonsid"></custom-job-puff>
                    <job-puff :job-data="job" v-if="job.annonsid"></job-puff>
                </div>
            </transition-group>
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
            <transition name="stagger">
                <div v-if="slowLoading" class="row" align="center">
                    <br>
                    <h4 class="text-shadow">(Sökningen verkar gå långsammare än vanligt..)</h4>
                    <br>
                    <div class="col-md-4 col-md-offset-4" >
                        <button class="btn btn-primary btn-sm" @click="fetchJobs">Prova igen</button>
                    </div>
                </div>
            </transition>
        </div>

        <transition name="stagger">
            <div v-if="errorOccurred" class="row text-center">
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
        </transition>

        <div id="pagination" v-show="showPagination">
            <div class="row">
                <div class="col-xs-12" align="center" v-html="jobsObj.paginatorMarkup"></div>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        mounted: function() {
            if(this.jobsObj.length === 0){
                this.fetchJobs();
            }

            window.addEventListener('popstate', e => {
                var state = e.state;
                this.fetchJobs();
            });
        },

        data () {
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
                },
                cancellationToken: null
            }
        },
        methods: {
            fetchJobs () {
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

                // abort previous request, if exists
                if (this.cancellationToken) {
                    this.cancellationToken.cancel();
                }

                // set a new cancellationToken
                const CancelToken = axios.CancelToken;
                this.cancellationToken = CancelToken.source();

                axios.post(url, parameters, {
                    cancelToken: this.cancellationToken.token
                }).then((response) => {
                        try {
                            this.jobsObj = response.data;
                            this.showJobs = true;
                            this.cancellationToken = null;

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

                    })
                    .catch(() => {
                        console.log('Error fetching jobs');
                        this.errorOccurred = true;
                    });
            },

            resetStates () {
                this.showJobs = false;
                this.errorOccurred = false;
                this.showPagination = false;
                this.slowLoading = false;
                this.jobsObj = {};

                if (this.slowLoadingTimeout) {
                    clearTimeout(this.slowLoadingTimeout);
                }
            },

            getUrlParameterByName (name, url) {
                if (!url) url = window.location.href;
                name = name.replace(/[\[\]]/g, "\\$&");
                var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
                    results = regex.exec(url);
                if (!results) return null;
                if (!results[2]) return '';
                return decodeURIComponent(results[2].replace(/\+/g, " "));
            },

            setPaginationEventListeners () {
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
            },
            beforeEnter: function (el) {
                el.style.opacity = 0;
            },
            enter: function (el) {
                const delay = el.dataset.index * 25;
                setTimeout(function () {
                    el.style.opacity = 1;
                }, delay)
            },
            leave: function (el) {
                const delay = el.dataset.index * 25;
                setTimeout(function () {
                    el.style.opacity = 0;
                }, delay)
            }
        }
    }
</script>
