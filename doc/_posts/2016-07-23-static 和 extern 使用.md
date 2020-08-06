---
title: 【iOS基础知识】static 和 extern 使用
description: static 和 extern 使用
categories:
 - iOS
 - iOS基础知识
tags:
 - static
 - extern
---

## static作用:

#### 1、修饰局部变量：

-   延长局部变量的生命周期,程序结束才会销毁。
    
-   局部变量只会生成一份内存,只会初始化一次。
    
-   改变局部变量的作用域。
    

如：

```
- (void)test
{
    // static修饰局部变量
    static int age = 0;
    age++;
    NSLog(@"%d",age);
}
```

如果连续调用两次test，会发现age打印结果如下图所示，age值初始化了一次，并且声明周期被延长了。

![](http://static.oschina.net/uploads/space/2016/0723/153351_KZRz_2279344.png)

#### 2、修饰全局变量 

-   只能在本文件中访问,修改全局变量的作用域,生命周期不会改
    
-   避免重复定义全局变量
    

## extern作用：

只是用来获取全局变量(包括全局静态变量)的值，不能用于定义变量

#### extern工作原理:

先在当前文件查找有没有全局变量，没有找到，才会去其他文件查找。

例如我们在该文件定义了一个全局变量：

```
// static修饰全局变量
static int age = 20;
```

我们使用它时，需要用extern int age; 打印结果如下，它会自动为我们寻找全局变量age，而非test中的age。

![](http://static.oschina.net/uploads/space/2016/0723/153607_BMOD_2279344.png)