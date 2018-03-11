<template>
    <div v-show="jobData" class="jobBlock col-md-6" :id="jobData.annonsid">
        <div class="row">
            <div class="col-xs-12">
                <div class="upperInfo">
                    <a :href="jobData.url" >
                        <div class="row">
                            <div class="titles col-xs-12">
                                <h1 class="text-left">{{ jobData.annonsrubrik }}</h1>
                                <h2 class="text-left"><i>{{ jobData.arbetsplatsnamn }}</i></h2>
                            </div>
                        </div>
                    </a>
                    <div class="jobShortDescription">
                        <template v-if="!done" v-html="loadingAnimation"></template>
                        <template v-else>{{ description }}</template>
                    </div>
                </div>
            </div>
        </div>

        <div class="bottomInfo">
            <div class="col-xs-5" title="Kommunen där jobbet finns.">
                <img src="/images/map_pin.png"/>
                <span>{{ jobData.kommunnamn }}</span>
            </div>
            <div class="col-xs-4" title="Dagar sedan jobbet publicerades.">
                <img src="/images/time_ago.png"/>
                <span>{{ jobData.time_since_published }}</span>
            </div>
            <div class="col-xs-3" title="Sista ansökningsdatum för jobbet.">
                <img src="/images/calendar.png"/>
                <span>{{ lastApplicationDay }}</span>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                description: '',
                done: false,
                loadingAnimation: '<div class="jobDescLoader"><div class="spinner-container container1"><div class="circle1"></div><div class="circle2"></div><div class="circle3"></div><div class="circle4"></div></div><div class="spinner-container container2"><div class="circle1"></div><div class="circle2"></div><div class="circle3"></div><div class="circle4"></div></div><div class="spinner-container container3"><div class="circle1"></div><div class="circle2"></div><div class="circle3"></div><div class="circle4"></div></div></div>'
            }
        },

        mounted () {
            this.getJobDescription();
        },
        props: ['jobData'],

        methods: {
            getJobDescription () {
                const url = 'getJobInfo/' + this.jobData.annonsid;

                axios.get(url)
                    .then((response) => {
                        this.done = true;
                        if(response.data.length > 200){
                            this.description = response.data.substring(0, 200) + " ...";
                        } else{
                            this.description = response.data;
                        }
                    })
                    .catch((response) => {
                        console.log('Error fetching job info');
                    });
            }
        },

        computed: {
            lastApplicationDay () {
                if (this.jobData.sista_ansokningsdag) {
                    return this.jobData.sista_ansokningsdag.substr(0, 10);
                }
                else {
                    return '-';
                }
            },
        }
    }
</script>
