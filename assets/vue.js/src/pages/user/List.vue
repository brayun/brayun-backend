<template>
  <div class="">
    <el-table :data="tableData" border style="width: 100%" v-loading.body="loading">
      <el-table-column type="index" width="50"></el-table-column>
      <el-table-column prop="username" label="用户名" sortable></el-table-column>
      <el-table-column prop="mobile" label="手机号码" width="130" sortable></el-table-column>
      <el-table-column prop="nickname" label="昵称" sortable></el-table-column>
      <el-table-column prop="email" label="邮箱" sortable></el-table-column>
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
  import { getUserList } from '@/api/user';

  export default {
    data () {
      return {
        loading: true,
        tableData: []
      }
    },
    methods: {
      getList () {
        getUserList().then(res => {
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
