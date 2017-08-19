import { getUserMenu } from '@/api/user'

/** 本地存储 */
export const Storage = {
    /** 获取数据 */
    get: (name) => {
        if (!name) { return }
        return localStorage.getItem(name)
    },
    /** 设置数据 */
    set: (name, content) => {
        if (!name) { return }
        if (typeof content !== 'string') {
            content = JSON.stringify(content)
        }
        return localStorage.setItem(name, content)
    },
    /** 删除 */
    remove: (name) => {
        if (!name) { return }
        return localStorage.removeItem(name)
    }
}

/** 用户操作 **/
export const User = {
  /** 判断是否已经登录 **/
  isLogin: () => {
    if (Storage.get('token')) {
      return true
    }
    return false
  },
  /** 登录后获取的菜单 **/
  getUserMenu: () => {
    var menu = Storage.get('menu')
    if (menu) {
      return JSON.parse(menu)
    }
    return []
  }
}


export const Route = {
  /** 路由解析方法 **/
  parse: (path, name, component, hidden, redirect, auth, icon, children) => {
    let route = {
      path: path,
      name: name,
      hidden: hidden ? true : false
    }
    if (component) route['component'] = require(`./pages/${component}.vue`)
    if (redirect) route['redirect'] = redirect
    if (auth) route['auth'] = auth
    if (children) route['children'] = children
    if (icon) route['icon'] = icon
    return route
  },
  /** 获取完整的路由规则 **/
  authority: (menu) => {
    if (menu.length <= 0) return []
    var routes = []
    for (let item of menu) {
      if (item.children && item.children.length > 0) {
        var children = Route.authority(item.children)
      }
      routes.push(Route.parse(item.path, item.name, item.component, item.hidden, item.redirect, item.auth, item.icon, children))
    }
    return routes
  }
}
