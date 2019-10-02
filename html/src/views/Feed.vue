<template>
  <div v-loading="loading" class="home">
    <RSSFeed :items="feed"/>
  </div>
</template>

<script>
  // @ is an alias to /src
  import RSSFeed from '@/components/RSSFeed.vue'
  import axios from 'axios'
  import config from "../config/config";

  export default {
    name: 'feed',
    data: function () {
      return {
        feed: [],
        loading: true
      }
    },
    components: {
      RSSFeed
    },
    created() {
      this.getFeed();
    },
    methods: {
      getFeed() {
        let _this = this;
        let axiosInstance = axios.create({
          headers: {'X-token': localStorage.getItem('token')}
        });
        axiosInstance.get(config.api.FEED, {}).then(result => {
          if (result.data.error) {
            _this.$router.push({'name': 'login'});
          } else {
            _this.feed = result.data.feed;
          }
          _this.loading = false;
        });
      }
    }
  }
</script>
