<template>
    <div class="">
      <el-table :data="tableData" border style="width: 100%" v-loading.body="loading">
        <el-table-column type="index" width="50"></el-table-column>
        <el-table-column prop="title" label="标题"></el-table-column>
        <el-table-column prop="type.name" label="发布频道" width="120px" sortable></el-table-column>
        <el-table-column prop="created_at" label="发布时间" :formatter="formatDate" sortable></el-table-column>
        <el-table-column prop="views" label="浏览数" width="100" sortable></el-table-column>
        <el-table-column prop="msg_count" label="留言数" width="100" sortable></el-table-column>
        <el-table-column prop="is_top" label="置顶" width="80">
          <template scope="scope">
            <el-tag :type="scope.row.is_top === '0' ? 'gray' : 'success'">{{scope.row.is_top === '0' ? '否':'是'}}</el-tag>
          </template>
        </el-table-column>
        <el-table-column
          label="操作"
          width="100">
          <template scope="scope">
            <el-button @click="handleView" type="text" size="small">查看</el-button>
            <el-button type="text" size="small">编辑</el-button>
          </template>
        </el-table-column>
      </el-table>
    </div>
</template>

<script>
import { getArticleList } from '@/api/article';

export default {
  data () {
    return {
      loading: true,
      tableData: []
    }
  },
  methods: {
    formatDate (row, column) {
      let date = new Date(row.created_at * 1000);
      return date.toLocaleString();
    },
    getList () {
      getArticleList().then(res => {
        this.loading = false;
        this.tableData = res.data.result.data;
      })
    },
    handleView () {

    }
  },
  mounted() {
    this.getList()
  }
}
</script>
