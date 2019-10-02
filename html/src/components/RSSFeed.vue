<template>
  <div>
    <el-row :gutter="20">
      <el-col :span="12" :offset="6"><RSSFeedItem v-for="item in items" :item="item"></RSSFeedItem></el-col>
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
    items: {
      type: Array,
      default: function () {
        return [
          {
            'id': '1',
            'updated': '2019-09-12T10:00:09Z',
            'author': {
              'name': 'Richard Speed',
              'uri': 'https://search.theregister.co.uk/?author=Richard%20Speed'
            },
            'link': 'http://go.theregister.com/feed/www.theregister.co.uk/2019/09/12/inlinkuk_crashed_ubuntu/',
            'title': 'Vulture Central team welcomed to our new nest by crashed Ubuntu that\'s 3 years out of date',
            'body': '&lt;h4&gt;What Mark Shuttleworth would have wanted?&lt;/h4&gt; &lt;p&gt;&lt;strong&gt;Updated&lt;/strong&gt;В  As eagle-eyed readers may have noted, Vulture Central UK is on the move. Our migratory path has led us to London\'s Grays Inn Road and, well, you can see what was waiting for us.вЂ¦&lt;/p&gt; &lt;p&gt;&lt;!--#include virtual=\'/data_centre/_whitepaper_textlinks_top.html\' --&gt;&lt;/p&gt;'
          },
          {
            'id': '2',
            'updated': '2019-09-12T10:00:09Z',
            'author': {
              'name': 'Richard Speed',
              'uri': 'https://search.theregister.co.uk/?author=Richard%20Speed'
            },
            'link': 'http://go.theregister.com/feed/www.theregister.co.uk/2019/09/12/inlinkuk_crashed_ubuntu/',
            'title': 'Vulture Central team welcomed to our new nest by crashed Ubuntu that\'s 3 years out of date',
            'body': '&lt;h4&gt;What Mark Shuttleworth would have wanted?&lt;/h4&gt; &lt;p&gt;&lt;strong&gt;Updated&lt;/strong&gt;В  As eagle-eyed readers may have noted, Vulture Central UK is on the move. Our migratory path has led us to London\'s Grays Inn Road and, well, you can see what was waiting for us.вЂ¦&lt;/p&gt; &lt;p&gt;&lt;!--#include virtual=\'/data_centre/_whitepaper_textlinks_top.html\' --&gt;&lt;/p&gt;'
          }
        ]
      }
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
