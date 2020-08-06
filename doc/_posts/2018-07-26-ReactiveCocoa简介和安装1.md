---
title: 【iOS编程思想】ReactiveCocoa (1)简介和安装
description:  ReactiveCocoa，简称RAC，是函数响应式编程框架。RAC具有函数式编程和响应式编程的特性。它主要吸取了.Net的 Reactive Extensions的设计和实现。
categories:
 - iOS
 - iOS编程思想
tags:
 - ReactiveCocoa
---


### 简介：

ReactiveCocoa，简称RAC，是函数响应式编程框架。RAC具有函数式编程和响应式编程的特性。它主要吸取了.Net的 Reactive Extensions的设计和实现。

### 为什么我们要用它

1） 开发过程中，状态以及状态之间依赖过多,RAC更加有效率地处理事件流，而无需显式去管理状态。在OO或者过程式编程中，状态变化是最难跟踪，最头痛的事。这个也是最重要的一点。

2） 减少变量的使用，由于它跟踪状态和值的变化，因此不需要再申明变量不断地观察状态和更新值。

3） 提供统一的消息传递机制，将oc中的通知，action，KVO以及其它所有UIControl事件的变化都进行监控，当变化发生时，就会传递事件和值。

4） 当值随着事件变换时，可以使用map，filter，reduce等函数便利地对值进行变换操作。

### 通过Pod安装：

1、创建 Podfile：

终端cd到项目所在目录，输入下面的命令，创建Podfile（前提是已经正确安装了CocoaPods ，详情请看之前的关于CocoaPods安装的博客）：

> $ vim Podfile

2、在Podfile中输入：

> use_frameworks!
> 
> pod 'ReactiveCocoa', '~> 4.0.2-alpha-1'

3、退出并保存，执行以下命令：

> $ pod install

至此，RAC已安装完毕，下次来结束它的基础用法吧！ 

**_Github:_**

> [https://github.com/ly918/Demos](https://github.com/ly918/Demos)