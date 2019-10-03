<template>
  <div>
    <el-row :gutter="20">
      <el-col :span="12" :offset="6">
        <h3>The most frequent words:</h3>

        <span class="frequent-word" v-for="word in words"><strong>{{ word.word }}</strong> - {{ word.count }}</span>
        <br>
        <RSSFeedItem v-for="item in items" :item="item"></RSSFeedItem>
      </el-col>
    </el-row>

  </div>
</template>

<script>

import RSSFeedItem from "./RSSFeedItem";

export default {
  components: {
    RSSFeedItem
  },
  name: 'RSSFeed',
  props: {
    words: {
      type: Array,
      default: function() {
        return []
      }
    },
    items: {
      type: Array,
      default: function () {
        return []
      }
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
  .frequent-word {
    margin-right: 20px;
  }
</style>
