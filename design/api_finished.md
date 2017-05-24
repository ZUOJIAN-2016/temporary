# 已完成的 API 简介
## 用户系统

| 功能 | 方法 | URI |
| :--: | :--: | :--: |
| 登陆 | POST | /login |
| 注销 | GET | /logout |
| 用户注册 | POST | /users |
| 读指定用户信息 | GET | /users/{login_name} |
| 读当前登陆用户信息 | GET | /current/user |
| 修改用户基本信息 | PATCH | /current/user |

## 组织系统

| 功能 | 方法 | URI |
| :--: | :--: | :--: |
| 创建组织 | POST | /organizations |
| 列出组织列表 | GET | /organizations |
| 查看组织信息 | GET | /organizations/{id} |
| 查看组织结构 | GET | /organizations/{id}/structure |
| 查看组织成员 | GET | /organizations/{id}/members |
