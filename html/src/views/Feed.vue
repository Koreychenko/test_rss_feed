<template>
    <div v-loading="loading" class="home">
        <RSSFeed :words="words" :items="feed"/>
    </div>
</template>

<script>
    // @ is an alias to /src
    import RSSFeed from '@/components/RSSFeed.vue'
    import api from "../services/api";

    export default {
        name: 'feed',
        data: function () {
            return {
                feed: [],
                words: {},
                loading: true
            }
        },
        components: {
            RSSFeed
        },
        created() {
            this.getFeed().catch((error) => {
                if (error == 'noauth') {
                    this.$router.push({name: 'login'});
                }
            });
        },
        methods: {
            async getFeed() {
                const result = await api.getFeed();
                this.feed = result.feed;
                this.loading = result.loading;
                this.words = result.words;
            }
        }
    }
</script>
