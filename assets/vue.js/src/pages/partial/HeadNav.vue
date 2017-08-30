<template>
    <el-col :span="24" class="header">
        <el-col :span="3" class="logo" :class="$store.state.user.collapsed?'logo-collapse':''">
            <img src="../../assets/images/logo.png" width="50" height="50" id="logo-small" alt="logo" v-if="$store.state.user.collapsed">
            <span v-if="!$store.state.user.collapsed">综合后台管理系统</span>
        </el-col>
        <el-col :span="2" class="collapse">
            <div class="tools" @click.prevent="collapse">
                <i class="iconfont icon-caidanzhankai"></i>
            </div>
        </el-col>
        <el-col :span="11">
          <el-menu :default-active="$route.matched[0].path" class="el-menu-brayun" mode="horizontal" unique-opened router>
            <template v-for="(item, index) in $router.options.routes" v-if="!item.hidden">
  						<el-menu-item :index="item.path">{{item.name}}</el-menu-item>
  					</template>
          </el-menu>
        </el-col>
        <el-col :span="4" class="top-userinfo">
            <el-dropdown trigger="hover">
                <span class="el-dropdown-link">
                    {{ this.$store.state.user.username }}
                    <i class="el-icon-caret-bottom el-icon--right"></i>
                </span>
                <el-dropdown-menu slot="dropdown">
                    <!-- <el-dropdown-item><router-link :to="{ path: '/user/info'}">用户信息</router-link></el-dropdown-item> -->
                    <el-dropdown-item @click.native="logout">退出登录</el-dropdown-item>
                </el-dropdown-menu>
            </el-dropdown>
        </el-col>
    </el-col>
</template>

<script>
export default {
  name: 'head-nav',
  data () {
      return {
          collapsed: false
      }
  },
  methods: {
    collapse () {
        this.$store.dispatch('Collapse', this.$store.state.user.collapsed);
	  },
	  logout () {
			this.$confirm('确认退出吗?', '提示', {}).then(() => {
        this.$router.options.routes = [];
		  	this.$store.dispatch('Logout');
				this.$router.replace({ path: '/login' });
			})
	  }
  }
}
</script>

<style lang="scss">
.header {
	color: #fff;

	#logo-small {
        padding: 5px;
    }
	.logo {
        height: 60px;
        line-height: 60px;
        text-align: center;
        background-color: rgb(41, 55, 76);
        width: 210px;
        &.logo-collapse {
            width: 60.67px;
        }
    }

	.collapse {
        width: auto;
    }

	.tools {
		padding: 0 20px;
		height: 60px;
		line-height: 60px;
		cursor: pointer;
		color: #215B99;
    }
}

.top-userinfo {
	float: right;
	text-align: right;
	height: 60px;
	line-height: 60px;
	padding-right: 20px;
	cursor: pointer;

	.el-dropdown-link {
		color: #000;
		font-size: 14px;
    }
}
.el-menu-brayun {
  background-color: transparent;

  a {
    text-decoration: none;
  }
}
.el-dropdown-menu {
  margin: -1px 0 0 0;
  border: none;
  box-shadow: none;

  a {
    color: #000;
    text-decoration: none;
  }
}
</style>
