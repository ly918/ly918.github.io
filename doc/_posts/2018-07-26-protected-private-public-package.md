---
title: 【iOS Tips】007-protected-private-public-package
description:  protected 该类和所有子类中的方法可以直接访问这样的变量。private 该类中的方法可以访问，子类不可以访问。public   可以被所有的类访问。package 本包内使用，跨包不可以。
categories:
 - iOS
 - iOS Tips
tags:
 - protected
 - private
 - public
 - package
---

```objectivec
@protected 该类和所有子类中的方法可以直接访问这样的变量。
@private 该类中的方法可以访问，子类不可以访问。
@public   可以被所有的类访问
@package 本包内使用，跨包不可以
```