<template>
  <div class="home">
    <RSSFeed />
  </div>
</template>

<script>
  // @ is an alias to /src
  import RSSFeed from '@/components/RSSFeed.vue'

  export default {
    name: 'register',
    components: {
      RSSFeed
    }
  }
</script>
