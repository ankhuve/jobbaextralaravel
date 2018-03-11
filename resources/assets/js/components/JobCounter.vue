<template>
    <div class="job-counter">
        <div>
            <h3>Aktiva jobbannonser </h3>
        </div>
        <div class="row">
            &nbsp;
            <span v-for="num in numJobs">{{ num }}</span>

        </div>
    </div>
</template>

<script>
    export default {
        created() {
            this.fetchNumberOfJobs();
        },

        data () {
            return {
                numJobs: "..."
            }
        },

        methods: {
            fetchNumberOfJobs () {
                axios.get('api/numJobs')
                    .then((response) => {
                        this.numJobs = String(response.data).split('');
                    })
                    .catch((response) => {
                        console.log('Error fetching number of jobs');
                    });
            }
        }
    }
</script>
