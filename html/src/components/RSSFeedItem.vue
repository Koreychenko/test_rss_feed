<template>
    <el-card class="box-card" shadow="hover">
      <div slot="header" class="clearfix">
        <div class="date float-right"><i class="el-icon-date"></i> {{ item.updated }}</div>
        <el-link href="item.link" type="primary">{{item.title}}</el-link>
      </div>
      {{item.body}}
      <div class="footer clearfix">
        Author: <el-link href="item.author.uri" type="primary">{{ item.author.name }}</el-link>
      </div>
    </el-card>
</template>

<script>
  
export default {
  name: 'RSSFeedItem',
  props: {
    item: {
      type: Object,
      default: function () {
        return {
            'title': 'Title',
            'body': 'Body'
          }
      }
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
  .box-card {
    text-align: left;
  }
  .box-card:not(:last-child) {
    margin-bottom: 18px;
  }

  .box-card .footer {
    margin-top: 10px;
    border-top: 1px solid #ccc;
    padding-top: 10px;
  }

  .box-card .float-right {
    float: right;
  }

  .box-card .date {
    font-size: 12px;
  }

</style>
