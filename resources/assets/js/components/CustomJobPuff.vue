<template>
    <div v-show="jobData" class="jobBlock col-md-6">
        <div class="row">
            <div class="col-xs-12">
                <div class="upperInfo bordered">
                    <a href="{{ jobData.url }}" >
                        <div class="row">
                            <div class="titles {{ jobData.logo_path ? 'col-xs-8' : 'col-xs-12' }}">
                                <h1 class="text-left">{{ jobData.title }}</h1>
                                <h2 class="text-left"><i>{{ jobData.work_place }}</i></h2>
                            </div>
                            <div v-if="jobData.logo_path" class="logo logo-job-block col-xs-4">
                                <div class="logo logo-img" v-show="jobData.logo_path" v-bind:style="{ backgroundImage: 'url(' + jobData.logo_path + ')'}"></div>
                            </div>
                        </div>
                    </a>
                    <div class="jobShortDescription">{{ jobData.description }}</div>
                </div>
            </div>
        </div>

        <div class="bottomInfo">
            <div class="col-xs-5" title="Kommunen där jobbet finns.">
                <img src="/build/img/map_pin.png"/>
                <span>{{ jobData.municipality }}</span>
            </div>
            <div class="col-xs-4" title="Dagar sedan jobbet publicerades.">
                <img src="/build/img/time_ago.png"/>
                <span>{{ jobData.time_since_published }}</span>
            </div>
            <div class="col-xs-3" title="Sista ansökningsdatum för jobbet.">
                <img src="/build/img/calendar.png"/>
                <span>{{ jobData.latest_application_date }}</span>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        created() {
//            console.log(this.jobData);
        },

        data: function() {
            return {
            }
        },

        props: ['jobData'],

        methods: {
            setBackgroundUrl: function(){
                console.log('fetching jobsObj...');
            }
        }
    }
</script>
