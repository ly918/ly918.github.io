---
title: 【iOS编程思想】ReactiveCocoa (2)信号的订阅、取消订阅、接收
description:  ReactiveCocoa (2)信号的订阅、取消订阅、接收
categories:
 - iOS
 - iOS编程思想
tags:
 - ReactiveCocoa
---


## 订阅信号及接收

### 1、创建信号（冷信号）

创建信号，需要传入订阅者

```objectivec
//didSubscriber 调用：只要一个信号被订阅就会调用
//didSubscriber 作用：发送数据
RACDisposable * (^didSubscribe)(id <RACSubscriber> subscriber) = ^RACDisposable * (id <RACSubscriber> subscriber) {
    NSLog(@"信号被订阅");
    //3 发送数据
    [subscriber sendNext:@1];
    return nil;
};

//1 创建信号（冷信号）
RACSignal * signal = [RACSignal createSignal:didSubscribe];
```

### 2、订阅信号（热信号）

```objectivec
//2 订阅信号（热信号）
[signal subscribeNext:^(id x) {
       
    //nextBlock 调用：只要订阅者发送数据就会调用
    //nextBlock 作用：处理数据，展示到UI上面
        
    //x:信号发送的内容
    NSLog(@"信号发送的内容：%@",x);
        
}];
```

### 3、发送信号

这一步，在创建信号时（第一步，穿件订阅者时）已经写好！

**运行结果：**

![](http://static.oschina.net/uploads/space/2016/0730/175528_w5ro_2279344.png)

## 取消订阅及接收

### 1、创建信号

```objectivec
RACSignal * signal = [RACSignal createSignal:^RACDisposable *(id<RACSubscriber> subscriber) {
       
        NSLog(@"信号被订阅");
        //3 发送信号
        [subscriber sendNext:@"123"];
        
        return [RACDisposable disposableWithBlock:^{
            
            //只要信号取消订阅 就会执行这
            //清空资源
            NSLog(@"信号被取消订阅了");
            
        }];
        
}];
```

### 2、订阅信号

```objectivec
RACDisposable * disposable = [signal subscribeNext:^(id x) {
        
    NSLog(@"信号发送的内容：%@",x);
}];
```

### 3、取消订阅

```objectivec
[disposable dispose];
```

**运行结果：**

![](http://static.oschina.net/uploads/space/2016/0730/175756_I7KS_2279344.png)

## 一个实例：

有一个BlueView，点击其上的按钮，在BlueView类中发送信号，在控制器中接收到信号。

### 1、BlueView中的信号属性：

```objectivec
@interface BlueView : UIView

@property (nonatomic, strong)RACSubject * btnClickSignal;

@end
```

懒加载信号属性：

```objectivec
- (RACSubject *)btnClickSignal{
    if (!_btnClickSignal) {
        _btnClickSignal = [RACSubject subject];
    }
    return _btnClickSignal;
}
```

### 2、发送信号：

点击按钮事件触发发送信号。

```objectivec
- (IBAction)btnClick:(id)sender{
    NSLog(@"发送了信号");
    //发送信号
    [self.btnClickSignal sendNext:@"我被点击了"];
}
```

### 3、在控制器中接收信号：

```objectivec
//接收信号
[_blueView.btnClickSignal subscribeNext:^(id x) {
    NSLog(@"接收到的信号：%@",x);
}];
```

**运行点击按钮，打印结果：**

![](http://static.oschina.net/uploads/space/2016/0730/180413_Fiwo_2279344.png)

至此我们学习了解了，RAC对信号的订阅、取消订阅、接收等处理。

**_Github:_**

> [https://github.com/ly918/Demos](https://github.com/ly918/Demos)