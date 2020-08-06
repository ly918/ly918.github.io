---
title: 【iOS基础知识】static 和 const 联合使用
description: 开发中常用static修饰全局变量，只改变作用域，改变全局变量作用域，可以防止重复声明全局变量。
categories:
 - iOS
 - iOS基础知识
tags:
 - static
 - const
---

        开发中常用static修饰全局变量，只改变作用域，改变全局变量作用域，可以防止重复声明全局变量。开发中声明的全局变量，有些不希望外界改动，只允许读取，举例如下：

```
static const int a = 20;
```

        声明一个静态的全局只读常量：iOS中staic和const常用使用场景，是用来代替宏，把一个经常使用的字符串常量，定义成静态全局只读变量，如下所示（其中key值是不可以被修改的。）：

```
static  NSString * const key = @"name";
```

        如果const修饰 \*key1 \*key只读，key1是可以被改变的。

```
static  NSString const *key1 = @"name";
```