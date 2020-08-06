---
title: 【iOS编程思想】ReactiveCocoa (4)常用方法集
description:  ReactiveCocoa (4)常用方法集
categories:
 - iOS
 - iOS编程思想
tags:
 - ReactiveCocoa
---

## 1、代替代理

  
实质是监听某对象是否调用了某一方法。在blueView中有一个btnClick()方法，即按钮的触发方法，我们监听这个方法，即传入这个选择器。

```objectivec
//RACSubject rac_signalForSelector
//只要传值就必须使用RACSubject
[[_blueView rac_signalForSelector:@selector(btnClick:)] subscribeNext:^(id x) {
    NSLog(@"控制器知道按钮被点击了");
}];

```

结果打印：

![](http://static.oschina.net/uploads/space/2016/0801/110041_Sxe9_2279344.png)

## 2、代替KVO

触发touchBegin中改变blueView得frame，即可监听到frame的改变。

```objectivec
[[_blueView rac_valuesForKeyPath:@"frame" observer:nil] subscribeNext:^(id x) {
    NSLog(@"修改的值 %@",x);
}];
```

打印结果：

可以注意到在view初始化、主动改变frame时都监听到了。

![](http://static.oschina.net/uploads/space/2016/0801/110426_wKri_2279344.png)

## 3、监听事件

比如监听按钮点击事件。

```objectivec
[[_btn rac_signalForControlEvents:UIControlEventTouchUpInside] subscribeNext:^(id x) {
     NSLog(@"别点我!!");
}];
```

打印结果：

![](http://static.oschina.net/uploads/space/2016/0801/110616_UP1M_2279344.png)

## 4、代替通知

键盘将要显示是的通知。

```objectivec
[[[NSNotificationCenter defaultCenter]rac_addObserverForName:UIKeyboardWillShowNotification object:nil]subscribeNext:^(id x) {
        NSLog(@"键盘将要显示时发送的通知:%@",x);
}];
```

打印结果：

![](http://static.oschina.net/uploads/space/2016/0801/110748_Rond_2279344.png)

## 5、监听文本框

使用rac_textSignal来监听文本框text。

```objectivec
[_textField.rac_textSignal subscribeNext:^(id x) {
     NSLog(@"监听文本框文字：%@",x);
}];
```

打印结果：

发现在初始化和开始编辑是都打印：

![](http://static.oschina.net/uploads/space/2016/0801/111003_ZBqA_2279344.png)

输入文字时的打印结果：

![](http://static.oschina.net/uploads/space/2016/0801/111115_yIQb_2279344.png)

github:

> [https://github.com/ly918/Demos](https://github.com/ly918/Demos)