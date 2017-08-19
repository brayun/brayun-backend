<template>
    <el-menu :default-active="activeRoute" class="slider-nav" unique-opened router :collapse="$store.state.user.collapsed" theme="dark">
      <template v-for="(router,index) in $router.options.routes" v-if="!router.hidden && $route.matched[0].path == router.path">
        <template v-for="(item,sindex) in router.children" v-if="!item.hidden">
          <el-submenu :index="sindex+''" v-if="item.children">
            <template slot="title">
              <i class="iconfont" :class="item.icon" v-if="item.icon"></i>
              <span slot="title">{{item.name}}</span>
            </template>
            <el-menu-item v-for="child in item.children" :index="child.path" :key="child.path" v-if="!child.hidden">{{child.name}}</el-menu-item>
          </el-submenu>
          <el-menu-item v-if="!item.children" :index="item.path">
            <i class="iconfont" :class="item.icon" v-if="item.icon"></i>
            <span slot="title">{{item.name}}</span>
          </el-menu-item>
        </template>
      </template>

        <!-- <el-submenu index="1">
            <template slot="title">
                <i class="el-icon-message"></i>
                <span slot="title">导航一</span>
            </template>
            <el-menu-item-group title="分组一">
                <el-menu-item index="1-1">选项1</el-menu-item>
                <el-menu-item index="1-2">选项2</el-menu-item>
            </el-menu-item-group>
            <el-menu-item-group title="分组2">
                <el-menu-item index="1-3">选项3</el-menu-item>
            </el-menu-item-group>
            <el-submenu index="1-4">
                <span slot="title">选项4</span>
                <el-menu-item index="1-4-1">选项1</el-menu-item>
            </el-submenu>
        </el-submenu>
        <el-menu-item index="2">
            <i class="el-icon-menu"></i>
            <span slot="title">导航二</span>
        </el-menu-item>
        <el-menu-item index="3">
            <i class="el-icon-setting"></i>
            <span slot="title">导航三</span>
        </el-menu-item> -->
    </el-menu>
</template>

<script>
export default {
  data () {
      return {
        activeRoute: this.$route.path
      }
  },
  methods: {
    updateActiveRoute (route) {
      var route = route || this.$route;
      if (route.matched.length) {
        if (route.matched.length > 3) {
          this.activeRoute = this.$route.matched.length > 3 ? this.$route.matched[3].parent.path : this.$route.path;
        }
      }
    }
  },
  watch: {
		$route(to, from) {
      this.updateActiveRoute(to)
		}
	},
  mounted () {
    this.updateActiveRoute()
  }
}
</script>

<style lang="scss">
.slider-nav {
    width: 210px;
    &.el-menu--collapse {
        width: auto;
    }
}
.el-menu--dark .el-menu-item.is-active {
  color: #ffffff;
}
.el-menu {
    border-radius: 0;
}
</style>
