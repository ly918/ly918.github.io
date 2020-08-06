---
title: 【iOS编程思想】ReactiveCocoa (6) 多次订阅一次请求
description:  ReactiveCocoa (6) 多次订阅一次请求
categories:
 - iOS
 - iOS编程思想
tags:
 - ReactiveCocoa
---


### 每次订阅时都会发送请求。

```objectivec
//1 创建信号
RACSignal * signal = [RACSignal createSignal:^RACDisposable *(id<RACSubscriber> subscriber) {
    NSLog(@"发送数据的请求");
    //3 发送请求
    [subscriber sendNext:@1];
    
    return nil;
}];

//2 订阅信号
[signal subscribeNext:^(id x) {
    NSLog(@"订阅者一 %@",x);
}];

[signal subscribeNext:^(id x) {
    NSLog(@"订阅者二 %@",x);
}];
```

测试结果：

![](http://static.oschina.net/uploads/space/2016/0804/162749_4B8j_2279344.png)

如何做到多次订阅一次请求呢？有下面两个方法：

### 1、RACSubject 多次订阅 一起请求

```objectivec
RACSubject * subject = [RACSubject subject];

[subject subscribeNext:^(id x) {
    NSLog(@"1 %@",x);
}];

[subject subscribeNext:^(id x) {
    NSLog(@"2 %@",x);
}];
//一次请求
[subject sendNext:@1];
```

运行测试：

![](http://static.oschina.net/uploads/space/2016/0804/162526_nJhd_2279344.png)

### 2、RACMulticastConnection 把信号转换为连接类

不管订阅多少次，只会请求一次，连接类必须有信号。

```objectivec
//1 创建信号
RACSignal * signal = [RACSignal createSignal:^RACDisposable *(id<RACSubscriber> subscriber) {
    
    NSLog(@"发送数据的请求");
    
    [subscriber sendNext:@"发送的数据"];
    return nil;
}];

//2 把信号转换成连接类
RACMulticastConnection * cnt = [signal multicast:[RACSubject subject]];

//3 订阅连接类信号
[cnt.signal subscribeNext:^(id x) {
    NSLog(@"订阅者：%@",x);
}];

[cnt.signal subscribeNext:^(id x) {
    NSLog(@"订阅者二 %@",x);
}];

//4 连接
[cnt connect];
```

测试结果：  
![](http://static.oschina.net/uploads/space/2016/0804/163515_onad_2279344.png)