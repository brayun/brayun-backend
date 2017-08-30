import Vue from 'vue';
import Router from 'vue-router';
import NProgress from 'nprogress';
import store from './store';
import { User, Route } from '@/utils';

Vue.use(Router);

/** 全局允许的路由 */
const whiteList = [
  '/login',
]

/** 登录后获取菜单 **/
var menu = [];
if (User.isLogin()) {
  menu = User.getUserMenu()
}


const router = new Router({
  // mode: 'history',
  routes: [
    Route.parse('/login', 'Login', 'Login', true),
    Route.parse('/not_found', 'NotFound', 'NotFound', true),
    Route.parse('/', '首页', 'Main', true, '/dashboard'),
    Route.parse('*', '', '', true, {path: '/not_found'}),
    ...Route.authority(menu)
  ]
});

router.beforeEach((to, from, next) => {
  NProgress.start();
  /** 已登录 */
  if (store.state.user.token) {
    /** 登录后还在登录页则跳转首页 */
    if (to.path === '/login') {
      next({ path: '/' })
    } else {
      /** 登录后获取Router */
      next()
    }
  } else {
    if (whiteList.indexOf(to.path) !== -1) { // 在免登录白名单，直接进入
      next()
    } else {
      next({ path: '/login', query: { redirect: to.query.redirect } }) // 否则全部重定向到登录页
      // NProgress.done(); // 在hash模式下 改变手动改变hash 重定向回来 不会触发afterEach 暂时hack方案 ps：history模式下无问题，可删除该行！
    }
  }
});

router.afterEach(route => {
  NProgress.done()
});

export default router
