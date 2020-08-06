---
title: 【iOS编程思想】ReactiveCocoa (3)解析集合
description:  ReactiveCocoa (3)解析集合
categories:
 - iOS
 - iOS编程思想
tags:
 - ReactiveCocoa
---

## 字典

### 1、使用rac_sequence.sinal，解析这个字典

```objectivec
//字典
NSDictionary * dict = @{@"account":@"aaa",
                        @"name":@"modi",
                        @"age":@18};

//转换成集合
[dict.rac_sequence.signal subscribeNext:^(id x) {
    
    //RACTupleUnpack 用来解析元组
    //宏里面的参数 传需要解析出来的变量名
    
    //= 右边 放需要解析的元组
    RACTupleUnpack(NSString * key,NSString * value) = x;
    
    NSLog(@"%@ = %@",key,value);
    
}];
```

解析打印：

![](http://static.oschina.net/uploads/space/2016/0801/104114_y56X_2279344.png)

### 2、宏 RACTupleUnpack 的作用

它可以用来解析元组，宏里面的参数传需要解析出来的变量名，= 右边放需要解析的元组（x）。

下面是文档中的示例：

![](http://static.oschina.net/uploads/space/2016/0801/104222_vkoK_2279344.png)

## 数组

### 1、使用rac_sequence.sinal，解析这个数组

```objectivec
NSArray * arr = @[@"123",@"456",@1];

//链式
[arr.rac_sequence.signal subscribeNext:^(id x) {
    NSLog(@"%@",x);
}];

```

解析打印：

![](http://static.oschina.net/uploads/space/2016/0801/104342_1blH_2279344.png)

## 元组

```objectivec
NSArray * arr = @[@"123",@"456",@1];
//元组
RACTuple * tuple = [RACTuple tupleWithObjectsFromArray:arr];
NSString * str = tuple[0];
    
NSLog(@"%@",str);
```

解析打印：

![](http://static.oschina.net/uploads/space/2016/0801/104423_w2eh_2279344.png)

## 一个实例：（解析plist文件）

### plist结构图：

![](http://static.oschina.net/uploads/space/2016/0801/104506_00lq_2279344.png)

### 1、读取plist

```objectivec
//plist bundlePath
NSString * filePath = [[NSBundle mainBundle] pathForResource:@"flags.plist" ofType:nil];
//读取plist
NSArray * dictArr = [NSArray arrayWithContentsOfFile:filePath];
NSLog(@"读取到的数据 %@",dictArr);
```

读取到的数据，即字典数组：

![](http://static.oschina.net/uploads/space/2016/0801/104618_im8R_2279344.png)

### 2、设计数据模型Flag

#### 2.1、给该数据模型一个解析方法：Dict -> Flag对象

```objectivec
@interface Flag : NSObject

@property (nonatomic, strong) NSString * name;

@property (nonatomic, strong) NSString * icon;

+ (instancetype)flagWithDict:(NSDictionary *)dict;

@end
```

#### 2.2、解析方法实现：

```objectivec
+ (instancetype)flagWithDict:(NSDictionary *)dict{
    Flag * f = [[Flag alloc]init];
    [f setValuesForKeysWithDictionary:dict];
    return f;
}
```

### 3、解析数组

#### 3.1、基本用法

```objectivec
//基本用法
NSMutableArray * arr = [NSMutableArray array];

[dictArr.rac_sequence.signal subscribeNext:^(id x) {
    //遍历元素
    Flag * flag = [Flag flagWithDict:x];
    [arr addObject:flag];
}];

NSLog(@"基本用法：%@",arr);
```

#### 3.2、高级用法

该方法可以将集合中所有的元素映射成一个新的对象，即将plist文件中的字典数组转化为Flag对象的数组。

```objectivec
//高级用法
//把集合中所有元素映射成一个新的对象
NSArray * arr = [[dictArr.rac_sequence map:^id(id value) {
    //集合中的元素
    //id 返回对象就是映射的值
    return [Flag flagWithDict:value];
}] array];

NSLog(@"高级用法：%@",arr);

```

解析结果打印：

![](http://static.oschina.net/uploads/space/2016/0801/105015_zAXP_2279344.png)

就这样我们很方便的就把字典数组转化为了对象数组。

**_github:_**

> [https://github.com/ly918/Demos](https://github.com/ly918/Demos)