# 用户系统
## 通常事项
### Todo
 * 查看所有用户 / 满足某些条件的用户列表
 * 密码重置

### 自动发生的行为
 新注册的用户的 `logined` 字段为 `0`，在任何需要用户登录才能进行的操作发生后该值将会自动置为 `1`。  
 这意味着如果新注册用户直接退出系统该字段依旧为 `0`，该机制用于注册用户的首次提示或其他作用。

### 用户之 Type 说明
 用户类型对应的值：

| Type | Value |
| :---: | :---: |
| RootAdmin | -1 |
| Student | 0 |
 
### 未登陆时访问某些 url
```
HTTP/1.1 401 Unauthorized
Content-Type: application/json

{"status":"error","message":"Unauthorized!"}
```

## 相关 API 列表
### 登陆
 **Request:**
```
POST /login
Content-Type: application/json

{
    "login_name": "{login_name}",
    "password": "{password}"
}
```

 **Response:**
```
/** 登陆成功 **/
HTTP/1.1 200 OK
Content-Type: application/json

{
    name: "{real_name}",
    login_name: "{login_name}",
    type: 0,
    logined: 0
}


/** 用户名密码不符或用户不存在 **/
HTTP/1.1 401 Unauthorized
Content-Type: application/json

{"status":"error","message":"Unauthorized!"}


/** 缺少必须字段 **/
HTTP/1.1 400 Bad Request
Content-Type: application/json

{"status":"error","message":"Bad Request!"}
```

### 登出
 **Request**
```
GET /logout
```

 **Response**
```
HTTP/1.1 200 OK
Content-Type: application/json

{"status": "success", "message": "Done!"}
```

### 用户注册
 创建一个新用户，且使用该用户凭证登陆。  
 如果用户已经登陆,则返回错误信息.  

 **Request:**
```
POST /users
Content-Type: application/json

{
    "name": "xxx",          // 姓名
    "login_name": "xxx",    // 登陆所用名
    "password": "xxx",      // 密码
    "mac_addr": "xxx",      // 用户绑定的 mac 地址（可选）
    "key": "xxx"            // 用户在注册时提供的 key（可选），作用待定
}
```

 **Response:**
```
HTTP/1.1 200 OK
Content-Type: application/json

{
    "name": "{real_name}",
    "login_name": "{login_name}",
    "type": 0,
    "logined": 0
}


/** 用户处于登陆状态或者无权创建用户 **/
HTTP/1.1 403 Forbidden
Content-Type: application/json
{
    "status": "warning",
    "message": "当前状态您无法创建用户！"
}
```

---
### 取得指定用户名的基本信息
 **Request:**
```
GET /users/{login_name}
```

 **Response:**
```
Content-Type: application/json

{
    "name": "{real_name}",
    "login_name": "{login_name}"
    "type": 0,
}
```

---
### 取得当前登陆用户的信息
 **Request:**
```
GET /current/user
```

 **Response:**
```
Content-Type: application/json

{
    "name": "{real_name}",
    "login_name": "{login_name}",
    "type": 0,
    "logined": 0
}

```
### 修改当前用户信息
 **注意:**
 当前，只允许修改用户信息的 `['mac_addr', 'name']` 字段，其他所有字段即使提交也会被忽略。  
 返回的信息中只会显示修改过的字段，意思是如果请求中只有 `name` 字段，则只会返回 `name` 字段的最新值，即使提交的 `name` 与原本的相同。  
 服务器会忽略所有其他字段。

 **Request:**
```
PATCH /current/user
Content-Type: application/json

{
    "name": "{edited_name}"
}
```

 **Response:**
```
{
    "name": "{edited_name}"
}
```
