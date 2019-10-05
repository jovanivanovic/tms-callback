<template>
    <div id="app">
        <router-view />
    </div>
</template>

<script>
    export default {
        name: 'App',
        data() {
            return {

            }
        },
        computed: {
            userLoggedIn() {
                return this.$store.getters.isLoggedIn;
            },
        }
    }
</script>
