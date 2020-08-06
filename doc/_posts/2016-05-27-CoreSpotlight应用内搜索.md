---
title: 【iOS Framework】CoreSpotlight应用内搜索
description: CoreSpotlight应用内搜索
categories:
 - iOS
 - iOS Framework
tags:
 - CoreSpotlight
---

## 步骤1、引入CoreSpotlight.framework

```objectivec
@import CoreSpotlight;
```

## 步骤2、 清空之前添加的CSSearchableItem

        大多数app的数据每天都在不停地更新，所以我们的搜索内容也要不断地更新。因此，为防止数据冗余，我们需要先清空之前添加的索引内容，即CSSearchableItem，方法如下：

```objectivec
//清空指定的Identifiers搜索内容,第一个传入的参数是数据的唯一标识的数组
[[CSSearchableIndex defaultSearchableIndex] deleteSearchableItemsWithDomainIdentifiers:@[@"BBS"] completionHandler:^(NSError * _Nullable error) {
         
}];

//清空所有搜索内容
[[CSSearchableIndex defaultSearchableIndex]deleteAllSearchableItemsWithCompletionHandler:^(NSError * _Nullable error) {
      
}];
```

## 步骤3、创建CSSearchableItemAttributeSet、CSSearchableItem

```objectivec
//1 创建可变数组，存放所有的CSSearchableItem
_searchItems = [[NSMutableArray alloc]init];

//2 根据数据源，创建CSSearchableItemAttributeSet、CSSearchableItem，并将item添加至数组中
//CSSearchableItemAttributeSet 可以理解为 上下文、是数据源和搜索内容链接的桥梁

//a.创建CSSearchableItemAttributeSet
CSSearchableItemAttributeSet * attritable = [[CSSearchableItemAttributeSet alloc]initWithItemContentType:@"image"];

attritable.title = model.userName;//标题

attritable.contentDescription = model.commentContent;//内容描述

attritable.thumbnailData = UIImageJPEGRepresentation(userImg,0.5);//内容相关的图片的NSData对象
         
//b.创建CSSearchableItem、并设定其唯一标识符，第一个为该内容的唯一标识，第二个是该内容所属类型的标识         
CSSearchableItem * item = [[CSSearchableItem alloc]initWithUniqueIdentifier:[NSString stringWithFormat:@"BBS_%@",model.Id] domainIdentifier:@"BBS" attributeSet:attritable];

//c.添加至数组
[self.searchItems addObject:item];
```

## 步骤4、更新所有搜索内容 items

```objectivec
[[CSSearchableIndex defaultSearchableIndex] indexSearchableItems:self.searchItems completionHandler:^(NSError * _Nullable error) {
        if (error) {
            NSLog(@"ERROR %@",error);
        }
}];
```

## 步骤5、接收系统搜索内容单元格的点击事件

这个方法 可以可以在AppDelegate中实现 ：

```objectivec
- (BOOL)application:(UIApplication *)application continueUserActivity:(NSUserActivity *)userActivity restorationHandler:(void (^)(NSArray * _Nullable))restorationHandler{

    //获取该搜索item的唯一标识符
    NSString * idf = userActivity.userInfo[@"kCSSearchableItemActivityIdentifier"] ;

    //进行相关操作
    return true;
}
```