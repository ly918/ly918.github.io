---
title: 【iOS编程思想】ReactiveCocoa (5)常用的宏
description:  ReactiveCocoa (5)常用的宏
categories:
 - iOS
 - iOS编程思想
tags:
 - ReactiveCocoa
---

## 1、建立KVO

宏的样子：

![](http://static.oschina.net/uploads/space/2016/0802/145436_zYHS_2279344.png)

使用方法：

```objectivec
//1 KVO
- (void)KVO{
    // 只要这个对象的属性一改变就会产生信号
    [RACObserve(self.view, frame) subscribeNext:^(id x) {
        NSLog(@"%@",x);
    }];
}
```

## 2、包装元组

宏的样子：

![](http://static.oschina.net/uploads/space/2016/0802/145523_GSwb_2279344.png)

使用方法：

```objectivec
//2 包装元组
- (void)RACTuplePack{
    //RACTuplePack()    包装元组
    RACTuple * tuple = RACTuplePack(@1,@2);
    
    NSLog(@"%@",tuple[0]);
}
```

## 3、绑定信号

宏的样子：

![](http://static.oschina.net/uploads/space/2016/0802/145639_J5X9_2279344.png)

使用方法：

```objectivec
//3 RAC()
- (void)RAC{
    //监听文本框内容
    [_textField.rac_textSignal subscribeNext:^(id x) {
        _label.text = x;
    }];
    
    //用来给某个对象的某个属性绑定信号 只要产生信号内容 就会把内容给属性赋值
    RAC(_label,text) = _textField.rac_textSignal;
}
```

## 4、@weakify @strongify

```objectivec
@weakify(self);
相当于：
__weak typeof(self) weakSelf = self;

@strongify(self);
相当于：
__strong typeof(weakSelf) strongSelf = weakSelf;
```

用法：

```objectivec
@weakify(self);

_signal = [RACSignal createSignal:^RACDisposable *(id<RACSubscriber> subscriber) {
    
    @strongify(self);
    return nil;
    
}];
```

这两个宏一定成对出现，先weak再strong.可以很好的管理Block内部对self的引用。