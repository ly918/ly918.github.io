---
title: 【iOS UIKit】UITextField(下)
description:  UITextField(下)
categories:
 - iOS
 - iOS UIKit
tags:
 - UITextField
---

​
## 1、重绘

除了UITextField对象的风格选项，你还可以定制化UITextField对象，为他添加许多不同的重写方法，来改变文本字段的显示行为。这些方法都会返回一个CGRect结构，制定了文本字段每个部件的边界范围。以下方法都可以重写。

```objectivec

– textRectForBounds:　　    //重写来重置文字区域
– drawTextInRect:　　        //改变绘文字属性.重写时调用super可以按默认图形属性绘制,若自己完全重写绘制函数，就不用调用super了.
– placeholderRectForBounds:　//重写来重置占位符区域
– drawPlaceholderInRect:　　//重写改变绘制占位符属性.重写时调用super可以按默认图形属性绘制,若自己完全重写绘制函数，就不用调用super了.
– borderRectForBounds:　　//重写来重置边缘区域
– editingRectForBounds:　　//重写来重置编辑区域
– clearButtonRectForBounds:　　//重写来重置clearButton位置,改变size可能导致button的图片失真
– leftViewRectForBounds:
– rightViewRectForBounds:
```

## 2、delegate

```objectivec
- (BOOL)textFieldShouldBeginEditing:(UITextField *)textField{    
//返回一个BOOL值，指定是否循序文本字段开始编辑  
    return YES;  
}  
 
- (void)textFieldDidBeginEditing:(UITextField *)textField{  
//开始编辑时触发，文本字段将成为first responder  
}  
 
- (BOOL)textFieldShouldEndEditing:(UITextField *)textField{  
//返回BOOL值，指定是否允许文本字段结束编辑，当编辑结束，文本字段会让出first responder  
//要想在用户结束编辑时阻止文本字段消失，可以返回NO  
//这对一些文本字段必须始终保持活跃状态的程序很有用，比如即时消息  
    return NO;  
}  
 
- (BOOL)textField:(UITextField*)textField shouldChangeCharactersInRange:(NSRange)range replacementString:(NSString *)string{  
//当用户使用自动更正功能，把输入的文字修改为推荐的文字时，就会调用这个方法。  
//这对于想要加入撤销选项的应用程序特别有用  
//可以跟踪字段内所做的最后一次修改，也可以对所有编辑做日志记录,用作审计用途。     
//要防止文字被改变可以返回NO  
//这个方法的参数中有一个NSRange对象，指明了被改变文字的位置，建议修改的文本也在其中  
     return YES;  
}  
 
- (BOOL)textFieldShouldClear:(UITextField *)textField{  
//返回一个BOOL值指明是否允许根据用户请求清除内容  
//可以设置在特定条件下才允许清除内容  
     return YES;  
}  
 
-(BOOL)textFieldShouldReturn:(UITextField *)textField{  
//返回一个BOOL值，指明是否允许在按下回车键时结束编辑  
//如果允许要调用resignFirstResponder 方法，这回导致结束编辑，而键盘会被收起[textField resignFirstResponder];
//查一下resign这个单词的意思就明白这个方法了  
     return YES;  
}  
```