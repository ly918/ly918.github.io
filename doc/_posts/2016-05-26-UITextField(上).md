---
title: 【iOS UIKit】UITextField(上)
description:  UITextField(上)
categories:
 - iOS
 - iOS UIKit
tags:
 - UITextField
---

​
## 1、设置边框风格

```objectivec
 textF.borderStyle = UITextBorderStyleRoundedRect;

  typedef enum {

    UITextBorderStyleNone, 

    UITextBorderStyleLine,

    UITextBorderStyleBezel,

    UITextBorderStyleRoundedRect  

  } UITextBorderStyle;
```

## 2、设置背景色、背景图、禁用时的背景图

```objectivec
  textF.backgroundColor = [UIColor whiteColor];

  textF.background = [UIImage imageNamed:@"dd.png"];

  textF.disabledBackground = [UIImage imageNamed:@"cc.png"];
```

## 3、输入框中是否有个叉号，在什么时候显示，用于一次性清空输入框中的内容

```objectivec
textF.clearButtonMode = UITextFieldViewModeAlways;
typedef enum {
    UITextFieldViewModeNever,  重不出现
    UITextFieldViewModeWhileEditing, 编辑时出现
    UITextFieldViewModeUnlessEditing,  除了编辑外都出现
    UITextFieldViewModeAlways   一直出现
} UITextFieldViewMode;
```

## 4、是否使用暗文

```objectivec
textF.secureTextEntry = YES;
```

## 5、设置键盘的样式

```objectivec
textF.keyboardType = UIKeyboardTypeNumberPad;
 
typedef enum {
    UIKeyboardTypeDefault,       //默认键盘，支持所有字符         
    UIKeyboardTypeASCIICapable, // 支持ASCII的默认键盘
    UIKeyboardTypeNumbersAndPunctuation,  //标准电话键盘，支持＋＊＃字符
    UIKeyboardTypeURL,           // URL键盘，支持.com按钮 只支持URL字符
    UIKeyboardTypeNumberPad,     //数字键盘
    UIKeyboardTypePhonePad,      //电话键盘
    UIKeyboardTypeNamePhonePad,   //电话键盘，也支持输入人名
    UIKeyboardTypeEmailAddress,   //用于输入电子 邮件地址的键盘     
    UIKeyboardTypeDecimalPad,     //数字键盘 有数字和小数点
    UIKeyboardTypeTwitter,        //优化的键盘，方便输入@、#字符
    UIKeyboardTypeAlphabet = UIKeyboardTypeASCIICapable, 
} UIKeyboardType;
```

## 6、首字母是否大写

```objectivec
textF.autocapitalizationType = UITextAutocapitalizationTypeNone;
 
typedef enum {
    UITextAutocapitalizationTypeNone, 不自动大写
    UITextAutocapitalizationTypeWords,  单词首字母大写
    UITextAutocapitalizationTypeSentences,  句子的首字母大写
    UITextAutocapitalizationTypeAllCharacters, 所有字母都大写
} UITextAutocapitalizationType;
```

## 7、return键字样

```objectivec
textF.returnKeyType =UIReturnKeyDone;
 
typedef enum {
    UIReturnKeyDefault, //默认 灰色按钮，标有Return
    UIReturnKeyGo,      //标有Go的蓝色按钮
    UIReturnKeyGoogle,//标有Google的蓝色按钮，用语搜索
    UIReturnKeyJoin,//标有Join的蓝色按钮
    UIReturnKeyNext,//标有Next的蓝色按钮
    UIReturnKeyRoute,//标有Route的蓝色按钮
    UIReturnKeySearch,//标有Search的蓝色按钮
    UIReturnKeySend,//标有Send的蓝色按钮
    UIReturnKeyYahoo,//标有Yahoo的蓝色按钮
    UIReturnKeyYahoo,//标有Yahoo的蓝色按钮
    UIReturnKeyEmergencyCall,// 紧急呼叫按钮
} UIReturnKeyType;
```

## 8、键盘外观

```objectivec
textF.keyboardAppearance=UIKeyboardAppearanceDefault；
typedef enum {
UIKeyboardAppearanceDefault，   //默认外观，浅灰色
UIKeyboardAppearanceAlert，     //深灰 石墨色
} UIReturnKeyType;
```

## 9、最右侧加自定义视图(如下)   左侧类似

```objectivec
 text.rightView=CustomView;

 textF.rightViewMode = UITextFieldViewModeAlways; 

typedef enum {

    UITextFieldViewModeNever,

    UITextFieldViewModeWhileEditing,

    UITextFieldViewModeUnlessEditing,

    UITextFieldViewModeAlways

} UITextFieldViewMode;
```

## 10、是否纠错

```objectivec
textF.autocorrectionType = UITextAutocorrectionTypeNo;
 
typedef enum {
    UITextAutocorrectionTypeDefault, //默认
    UITextAutocorrectionTypeNo,   //不自动纠错
    UITextAutocorrectionTypeYes,  //自动纠错
} UITextAutocorrectionType;
```

## 11、收键盘

```objectivec
[textF resignFirstResponder];  
```