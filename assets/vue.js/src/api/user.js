import axios from 'axios';

// 手机号码登录
export function loginByMobile (loginForm) {
  return axios.post('/api/secret/login', loginForm);
}

// 获取用户列表
export function getUserList (page) {
  return axios.get('/api/user/index');
}
