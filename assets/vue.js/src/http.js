import axios from 'axios';
import store from './store';
import router from './router';
import NProgress from 'nprogress';
import Qs from 'qs';
import { Message } from 'element-ui';

axios.defaults.timeout = 5000;
// axios.defaults.baseURL = 'http://admin.weshop.dev';
axios.defaults.headers['Content-Type'] = 'application/x-www-form-urlencoded';

axios.interceptors.request.use(
  config => {
    NProgress.start();
    if (store.state.user.token) {
      config.headers.Authorization = 'Bearer ' + store.state.user.token;
      config.headers.alg = 'HS256';
    }
    config.transformRequest = params => {
      return Qs.stringify(params);
    };
    config.withCredentials = true;
    config.responseType = 'json';
    return config
  },
  error => {
    NProgress.done();
    return Promise.reject(error);
  }
);

axios.interceptors.response.use(
  response => {
    NProgress.done();
    if (response.data.code === 403) {
      Message({
        message: response.data.msg,
        type: 'error'
      })
    }
    return response;
  },
  error => {
    NProgress.done();
    if (error.response) {
      switch (error.response.status) {
        case 401:
          store.commit('LOGOUT');
          router.replace({
            path: 'login',
            query: {redirect: router.currentRoute.fullPath}
          });
          break;
        case 500:
          Message({
            message: error.response.statusText,
            type: 'error'
          });
          break;
      }
    }
    return Promise.reject(error);
  }
)
