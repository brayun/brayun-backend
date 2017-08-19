import { Storage } from '@/utils';
import { loginByMobile } from '@/api/user';

const state = {
  token: Storage.get('token') || null,
  menu: Storage.get('menu') || [],
  username: Storage.get('username') || '',
  collapsed: false
};

const mutations = {
  LOGIN: (state, user) => {
    state.token = user.token
    state.menu = user.menu
    state.username = user.username
  },
  LOGOUT: (state) => {
    state.token = null
    state.menu = []
    state.username = ''
  },
  COLLAPSE: (state, boolean) => {
    state.collapsed = state.collapsed ? false : true;
  }
}

const actions = {
  LoginByMobile({ commit }, user) {
    return new Promise((resolve, reject) => {
      loginByMobile(user).then(res => {
        if (res.data.code === 0) {
          let user = res.data;
          Storage.set('token', user.token);
          Storage.set('menu', user.menu);
          Storage.set('username', user.username);
          commit('LOGIN', user);
        }
        resolve(res.data)
      })
    }).catch(error => {
      reject(error);
    })
  },
  Logout({commit}) {
    commit('LOGOUT');
    Storage.remove('token');
    Storage.remove('menu');
    Storage.remove('username');
  },
  Collapse({commit}, bool) {
    commit('COLLAPSE', state.collapsed)
  }
}

export default {
  state,
  mutations,
  actions
}
