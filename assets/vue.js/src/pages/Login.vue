<template>
  <div id="login">
    <div id="login-bg"></div>
    <el-form :model="loginForm" :rules="loginRules" ref="loginForm" label-position="left" label-width="0px" class="login-container">
      <i class="iconfont switch-icon" :class="switchForm ? 'icon-erweima' : 'icon-dengludiannao'" @click="switchLogin"></i>
      <div v-if="switchForm">
        <h3 class="title">登录
          <span>LOGIN</span>
        </h3>
        <el-form-item prop="account">
          <el-input type="text" v-model="loginForm.account" auto-complete="off" placeholder="账号" @keyup.native.enter="onSubmit"></el-input>
        </el-form-item>
        <el-form-item prop="password">
          <el-input type="password" v-model="loginForm.password" auto-complete="off" placeholder="密码" @keyup.native.enter="onSubmit"></el-input>
        </el-form-item>
        <el-form-item style="width:100%;">
          <el-button type="primary" style="width:100%;" :loading="logining" @click="onSubmit">登录</el-button>
        </el-form-item>
      </div>
      <div v-if="!switchForm">
        <h3 class="title">微信扫码
          <span>安全登录</span>
        </h3>
        <div id="login_container"></div>
      </div>
    </el-form>
  </div>
</template>

<style lang="scss">
  @import '../assets/scss/style.scss';
  #login {
    height: 100%;
    width: 100%;
    margin: 0;
    padding: 0;
    overflow: hidden;
    background: #000000 url('../assets/images/background.jpg') no-repeat center;
    background-size: cover;
    position: relative;

    #login-bg {
      height: 100%;
    }
  }

  .login-container {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    padding: 20px 50px 40px 50px;
    background-color: #fff;
    width: 300px;

    #qrcodeLogin {
      width: 170px
    }

    .switch-icon {
      font-size: 50px;
      position: absolute;
      right: 5px;
      top: 5px;
      cursor: pointer;
      color: #1183d8;
    }

    .title {
      font-weight: normal;
      color: #171717;
      span {
        font-size: 12px;
        color: #666;
        padding-left: 20px;
      }

    }

  }


  @media (max-width: 767px) {
    .login-container {
      width: 230px;
      padding: 40px 30px;
    }
  }

</style>


<script>
import particlesJS from 'particles.js';
require('@/components/wxLogin');
import { Message } from 'element-ui';
import axios from 'axios';
import { User, Route } from '@/utils';

export default {
  data() {
    return {
      logining: false,
      switchForm: true,
      loginForm: {
        account: '',
        password: ''
      },
      loginRules: {
        account: [
          { required: true, message: '用户名不能为空!', trigger: 'blur' }
        ],
        password: [
          { required: true, message: '密码不能为空!', trigger: 'blur' }
        ]
      }
    }
  },
  methods: {
    particlesjs() {
      window.particlesJS('login-bg', require('../assets/particlesjs.json'));
    },
    switchLogin() {
      this.switchForm = !this.switchForm;
    },
    onSubmit() {
      this.$refs.loginForm.validate((valid) => {
        if (valid) {
          this.logining = true;
          this.$store.dispatch('LoginByMobile', this.loginForm).then(res => {
            this.logining = false;
            if (res.code === 0) {
                let routes = Route.authority(User.getUserMenu());
                for (let route of routes) {
                    this.$router.options.routes.push(route);
                }
                this.$router.addRoutes(routes);
                this.$router.replace({ path: decodeURIComponent(this.$route.query.redirect || '/') });
                Message.success('登录成功!');
            } else {
                Message.error(res.msg)
            }
          }).catch(error => {
            this.logining = false
          })
        } else {
          return false
        }
      })
    },
    wxLogin() {
      var container = document.querySelector('#login_container');
      if (container) {
        if (!container.hasChildNodes('iframe')) {
          WxLogin({
            id: "login_container",
            appid: "wxf31c30bce11ca9f4",
            scope: "snsapi_login",
            redirect_uri: "http://localhost:8080/login",
            state: "",
            style: "",
            href: encodeURI("https://brayun.oss-cn-beijing.aliyuncs.com/wxlogin.css")
          })
        }
      }
    }
  },
  created() {
    var code = this.$route.query.code
    if (code) {
      axios.get('http://www.fenkei.com/admin/user/wxlogin', {params: {code: code, state: ''}}).then(res => {
        console.log(res)
      })
    }
  },
  mounted() {
    this.particlesjs()
  },
  updated() {
    this.wxLogin()
  }
}
</script>
