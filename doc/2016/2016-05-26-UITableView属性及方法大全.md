---
title: 【iOS UIKit】UITableView属性及方法大全
description:  UITableView属性及方法大全
categories:
 - iOS
 - iOS UIKit
tags:
 - UITableView
---

​
# **UITableView：表视图**

继承UIScrollView并遵守NSCoding协议

## 1 属性

```objectivec
frame-------------设置控件的位置和大小

backgroundColor--------设置控件的颜色

style--------获取表视图的样式

dataSource---------设置UITableViewDataSource的代理

delegate---------设置UITableViewDelegate代理

sectionHeaderHeight------设置组表视图的头标签高度

sectionFooterHeight--------设置级表视图的尾标签高度

backgroundView----------设置背景视图，只能写入

editing----------是否允许编辑，默认是NO

allowsSelection----------在非编辑下，行是否可以选中，默认为YES

allowsSelectionDuringEditing----------控制某一行时，是否可以编辑，默认为NO

allowsMultipleSelection--------是否可以选择多行，默认为NO

allowsMutableSelectionDuringEditing----------在选择多行的情况下，是否可以编辑，默认为NO

sectionIndexMinimumDisplayRowCount-------------显示某个组索引列表在右边当行数达到这个值，默认是NSInteger的最大值

sectionIndexColor------------选择某个部分的某行改变这一行上文本的颜色

sectionIndexTrackingBackgroundColor--------设置选中某个部分的背景颜色

separatorStyle----------设置单元格分隔线的样式

separatorColor---------设置选中单元格分隔线的颜色

tableHeaderView---------设置组表的头标签视图

tableFooterView----------设置组表的尾标签视图

//UITableView类目属性

section--------获取当前在哪个组内

row------------获取当前单元格是第几行
```

## 2 方法：

```objectivec
//初始化方法：

initWithFrame：-----------设置表的大小和位置

initWithFrame：style---------设置表的大小，位置和样式（组，单一）

setEditing：----------表格进入编辑状态，无动画

setEditing： animated：---------表格进入编辑状态，有动画

reloadData---------------刷新整个表视图

reloadSectionIndexTitles--------刷新索引栏

numberOfSections-----------获取当前所有的组

numberOfRowsInSection：---------获取某个组有多少行

rectForSection：----------获取某个组的位置和大小

rectForHeaderInSection：---------获取某个组的头标签的位置和大小

rectForFooterInSection：-----------获取某个组的尾标签的位置和大小

rectForRowAtIndex：-----------获取某一行的位置和大小

indexPathForRowAtPoint-------------点击某一个点，判断是在哪一行上的信息。

indexPathForCell：------------获取单元格的信息

indexPathsForRowsInRect：---------在某个区域里会返回多个单元格信息

cellForRowAtIndexPath：-------------通过单元格路径得到单元格

visibleCells-----------返回所有可见的单元格

indexPathsForVisibleRows--------返回所有可见行的路径

headerViewForSection：--------设置头标签的视图

footerViewForSection；----------设置尾标签的视图

beginUpdates--------只添加或删除才会更新行数

endUpdates---------添加或删除后会调用添加或删除方法时才会更新

insertSections：withRowAnimation：-----------插入一个或多个组，并使用动画

insertRowsIndexPaths：withRowAnimation：-------插入一个或多个单元格，并使用动画

deleteSections：withRowAnimation：--------删除一个或多个组，并使用动画

deleteRowIndexPaths：withRowAnimation：--------删除一个或多个单元格，并使用动画

reloadSections：withRowAnimation：---------更新一个或多个组，并使用动画

reloadRowIndexPaths：withRowAnimation：-------------更新一个或多个单元格，并使用动画

moveSection：toSection：-------------移动某个组到目标组位置

moveRowAtIndexPath：toIndexPath：-----------移动个某个单元格到目标单元格位置

indexPathsForSelectedRow----------返回选择的一个单元格的路径

indexPathsForSelectedRows---------返回选择的所有的单元格的路径



selectRowAtIndexPath：animation：scrollPosition---------设置选中某个区域内的单元格 

deselectRowAtIndexPath：animation：----------取消选中的单元格

//重用机制

dequeueReusableCellWithIdentifier：---------获取重用队列里的单元格
```

## UITableViewDataSource代理方法：

```objectivec
numberOfSectionsInTableView：------------设置表格的组数

tableView：numberOfRowInSection：----------设置每个组有多少行

tableView：cellForRowAtIndexPath：---------设置单元格显示的内容

tableView：titleForHeaderInSection：---------设置组表的头标签视图

tableView：titleForFooterInSection：-----------设置组表的尾标签视图

tableView：canEditRowAtIndexPath：---------设置单元格是否可以编辑

tableView：canMoveRowAtIndexPath：--------设置单元格是否可以移动

tableView：sectionIndexTitleForTableView：atIndex：-------设置指定组的表的头标签文本

tableView：commitEditingStyle：forRowAtIndexPath：----------编辑单元格（添加，删除）

tableView：moveRowAtIndexPath：toIndexPath-------单元格移动
```

## UITableViewDelegate代理方法：

```objectivec
tableView：  willDisplayCell： forRowAtIndexPath：-----------设置当前的单元格

tableView： heightForRowAtIndexPath：-----------设置每行的高度

tableView：tableView heightForHeaderInSection：-----------设置组表的头标签高度

tableView：tableView heightForFooterInSection：-------------设置组表的尾标签高度

tableView： viewForHeaderInSection：----------自定义组表的头标签视图

tableView： viewForFooterInSection： ----------自定义组表的尾标签视图

tableView： accessoryButtonTappedForRowWithIndexPath：-----------设置某个单元格上的右指向按钮的响应方法

tableView： willSelectRowAtIndexPath：-----------获取将要选择的单元格的路径

tableView： didSelectRowAtIndexPath：-----------获取选中的单元格的响应事件

tableView： tableView willDeselectRowAtIndexPath：------------获取将要未选中的单元格的路径

tableView： didDeselectRowAtIndexPath：-----------获取未选中的单元格响应事件
```

## 执行顺序如下：

### 第一轮：

```objectivec
1、numberOfSectionsInTableView    ：假如section=2，此函数只执行一次，假如section=0，下面函数不执行，默认为1

2、heightForHeaderInSection  ，执行两次，此函数执行次数为section数目

3、heightForFooterInSection  ，函数属性同上，执行两次

4、numberOfRowsInSection    ，此方法执行一次

5、heightForHeaderInSection     ，此方法执行了两次，我其实有点困惑为什么这里还要调用这个方法

6、heightForFooterInSection   ，此方法执行两次，

7、numberOfRowsInSection，执行一次

8、heightForRowAtIndexPath  ，行高，先执行section=0，对应的row次数
```

### 第二轮：

```objectivec
1、numberOfSectionsInTableView ，一次

2、heightForHeaderInSection  ，section次数

3、heightForFooterInSection    ，section次数  

4、numberOfRowsInSection    ，一次

5、heightForHeaderInSection  ，执行section次数

6、heightForFooterInSection，执行section次数

7、numberOfRowsInSection，执行一次

8、heightForRowAtIndexPath，行高，先执行一次

9、cellForRowAtIndexPath  

10、willDisplayCell

 然后8、9、10依次执行直到所有的cell被描画完毕
```