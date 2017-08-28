<template>
    <div class="job-counter">
        <div>
            <h3>Aktiva jobbannonser </h3>
        </div>
        <div class="row">
            &nbsp;
            <span v-for="num in numJobs" track-by="$index">{{ num }}</span>

        </div>
    </div>
</template>

<script>
    export default {
        created() {
            this.fetchNumberOfJobs();
        },

        data: function() {
            return {
                numJobs: "..."
            }
        },

        methods: {
            fetchNumberOfJobs: function(){
                this.$http.get('api/numJobs').then((response) => {
                    this.numJobs = response.body;
                }, (response) => {
                    console.log('Error fetching number of jobs');
                });
            }
        }
    }
</script>
