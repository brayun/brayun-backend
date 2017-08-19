<template>
    <div class="">
        用户列表
    </div>
</template>

<script>
import { getUserList } from '@/api/user';

export default {
  data () {
    return {

    }
  },
  methods: {

  },
  mounted() {
    getUserList()
  }
}
</script>
