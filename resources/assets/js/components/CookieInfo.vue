<template>
    <div v-if="!showNotice" class="alert alert-bottom">
        <h1>Cookies</h1>
        <p>Denna webbplats använder cookies (kakor) för att förbättra användarupplevelsen. Genom att använda denna webbplats eller stänga av detta meddelande godkänner du användningen av cookies.</p>
        <button @click="accept" class="btn btn-success m-t-1">Jag accepterar</button>
    </div>
</template>

<script>
    export default {
        data: function() {
            return {
                accepted: false
            }
        },

        computed: {
            showNotice: function () {
                return localStorage.getItem('cookie-consent') ? localStorage.getItem('cookie-consent') : this.accepted
            }
        },

        methods: {
            accept () {
                localStorage.setItem('cookie-consent', true);
                this.accepted = true;
            }
        }
    }
</script>