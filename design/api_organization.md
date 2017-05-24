# 组织系统
## 通常事项
 * 要进行组织的相关操作用户必须已登陆，否则将直接返回 401 Unauthorized
 * 某些操作与用户所拥有的权限 / 所在的组有关

### Todo
### 组织之 Type 说明
 暂时没想到（

## 相关 API 列表
### 创建组织
 **Request:**
```
HTTP/1.1 POST /organizations
Content-Type: application/json

{
	"name": "{name}",						// 组织名称
	"type": {type},							// 组织类型
	"parent_organization": {parent_id},		// 组织所属组织的 id (到时候顶级组织属于学校，学校将有一固定 id)
	"introduction": "{introduction}",			// 组织的简单描述 (Optional)
	"description": "{description}",			// 组织的详细描述 (Optional)
	"info": {
		// 组织的具体其他信息，可为对象或数组 (Optional)
	}
}
```

 **Response:**
```
HTTP/1.1 200 OK
Content-Type: application/json

{
	"id": 1,
	"name": "",
	"type": 0,
	"parent": {
		// 父组织的一些基本信息如名称、类型、简介
	},
	"introduction": "",
	"description": "",
	"info": ""
}
```

### 列出所有组织列表
 **Request:**
```
HTTP/1.1 GET /organizations?skip=0&take=15
```
 * `skip` 表示需要跳过的信息条数，默认为 `0`
 * `take` 表示需要显示的信息条数，默认为 `15`


 **Response:**
```
HTTP/1.1 200 OK
Content-Type: application/json

[
	{
		"id": 1,
		"name": "",
		"type": 0,
		"introduction": ""
	},
	{
		"id": 2
		...
	},
	...
]
```

### 查看某个组织的详细信息
 **Request:**
```
HTTP/1.1 GET /organizations/{id}
```

 **Response**
 同创建新组织的回复

### 查看某组织结构
 注意！该操作查询时间**可能**相对较长，因为需要递归查询组织层次

 **Request:**
```
HTTP/1.1 GET /organizations/{id}/structure
```

 **Response**
 组织的树形结构，每个组织的子组织都以数组的形式在组织的 `children` 字段下

### 查看某组织的直接成员
 **Request:**
```
HTTP/1.1 GET /organizations/{id}/members
```

 **Response**
 仅显示当前组织的信息以及当前组织的成员信息，不包括其下属组织。

### 查看某组织所有成员
 注意！该操作查询时间**可能**相对较长，因为需要递归查询组织层次后查询成员

 **Request:**
```
HTTP/1.1 GET /organizations/{id}/members?all=1
```

 **Response**
 组织的树形结构上附加 members 属性，其中包含成员的详细信息


### 编辑组织信息
 **Request:**
```
HTTP/1.1 UPDATE /organizations/{id}
Content-Type: application/json

// 要更改的字段, json
```

 **Response:**
 如果成功，返回修改后的组织信息
 如果失败，返回
```
{
	"status": "fail",
	"message": ""
}
```
