# Database
## users                通常用户信息表
id          id
name        用户名称
login_name  登录所用用户名（学号、组织编号等
password    密码
type        用户类型
logined		是否登陆过，初始为 false

#### type
0	学生

## organizations         组织信息表
id              组织id
name            组织名称
type            组织类型（见详细说明
belongs         组织隶属于（的组织id
introduction    组织介绍
description     详细说明
info            详细信息（如创建时间等不常需要改变的属性 - [json]

#### type   // ?
0   学校
1   学院
2   社团
3   虚拟组织[辅导员-学生]

## users_organizations   用户-组织关系表
user_id         用户id
org_id          组织id
relation        两者关系
privilege       用户-组织权限
situation       用户职位称呼

#### relation
0   普通成员
1   创建者
2   组织最高管理者
3   组织普通管理者
// 4   待审核成员
5

## activities           活动信息表
id                      活动id
name                    活动名称
organization_id         举办方组织id
starts_at               活动开始时间
ends_at                 活动结束时间
introduction            活动介绍
description             活动详细说明
status                  活动状态
target                  活动目标人群
extra                   活动详细字段[json]

#### target
0   不做限制
1   组织内成员
2..

#### status
0   草稿
1   已申报待审核完成
2   已审核完成待发布
3   已发布的可报名的活动
4   禁止报名的活动
5   已结束的活动

#### type
待定

## tags  				标签表
id
name
description

## activities_tags      活动-标签关系表
activities_id
tags_id

## users_activities     用户-活动关系表
user_id                 用户id
activities_id           活动id
relation                两者关系

#### relation
0   已报名活动待审核
1   已成功报名活动
2   报名失败
3   成功参与活动
4   报名但未参加活动
5   关注的活动

# 组织权限定义
* 审核该组织申报的活动
* 查看该组织正在申报的活动
* 修改组织名称
* 修改组织介绍
// * 审核新成员
* 撰写活动草稿
* 申报活动
* 修改已经提交申报的活动信息
* 发布活动
