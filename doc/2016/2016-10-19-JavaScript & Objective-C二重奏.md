---
title: 【iOS & Web】JavaScript & Objective-C二重奏
description: JS call OC & OC Call JS

categories:
 - iOS
 - iOS & Web
tags:
 - Web
 - JS
---

# 一、JS call OC

## 方法1：

通拦截协议头来获取协议字符串。在UIWebView中的代理方法中有这样的方法，如下图所示：

```objectivec
//UIWebView每次请求内容之前，都会调用这个方法，通过返回YES/NO来决定UIWebView是否进行request请求。
//我们可以通过URL的协议头及字符串来区别普通的URL请求
//JS传递给OC的参数可以通过URL带过来，如果参数内容过长可以通过post请求来传递，本地在拦截request后，可以将HTTPBody中的请求内容解析出来。
- (BOOL)webView:(UIWebView *)webView shouldStartLoadWithRequest:(NSURLRequest *)request navigationType:(UIWebViewNavigationType)navigationType{
    return YES;
}
```

下面是我写的简单的H5页面通过JS请求一个自定义协议的URL，然后通过UIWebView来拦截：

### _**Demo1:**_

#### 第一种： 无参数的协议URL

H5和JS代码如下：

```html
<!-- H5代码 -->
    <input type="button" onclick="shareWexin()" value="无参协议的URL">

    <!-- JS 代码 -->
    <script type="text/javascript">
        function shareWexin() {
            //这里objc是协议头，作为iOS端拦截的标识
            //shareWX即为‘协议名’、作为iOS方法的识别
            window.location.href="objc://shareWX";
        }
    </script>
```

UIWebView代理中的协议拦截：

```objectivec
- (BOOL)webView:(UIWebView *)webView shouldStartLoadWithRequest:(NSURLRequest *)request navigationType:(UIWebViewNavigationType)navigationType{
    
    NSString *urlString = [[request URL] absoluteString];
    
    NSLog(@"协议URL => %@",urlString);
    
    NSArray *urlComps = [urlString componentsSeparatedByString:@"://"];
    
    if([urlComps count] && [[urlComps objectAtIndex:0] isEqualToString:@"objc"]){
        
        NSLog(@"方法名 => %@",urlComps.lastObject);
        
        return NO;
    }
    return YES;
}
```

点击网页中的按钮打印如下所示：

![](http://static.oschina.net/uploads/space/2016/1019/165141_UE71_2279344.png)

现在我们成功拦截到了协议，后续的处理就不用我多说了吧！

#### 第二种： 有参数的协议URL

H5和JS代码如下：

```html
<body>
    <h2>第一种方法</h2>
    <h4>请求有参协议的URL</h4>
    <!-- H5代码 -->
    <input type="button" onclick="shareQQ()" value="有参协议的URL">

    <!-- JS 代码 -->
    <script type="text/javascript">
        function shareQQ() {
            //这里objc是协议头，作为iOS端拦截的标识
            //shareWX即为‘协议名’、作为iOS方法的识别
            //type=qq 即为参数
            window.location.href="objc://shareQQ?type=qq";
        }
    </script>
</body>
```

UIWebView代理中的协议拦截：

```objectivec
- (BOOL)webView:(UIWebView *)webView shouldStartLoadWithRequest:(NSURLRequest *)request navigationType:(UIWebViewNavigationType)navigationType{
    
    NSString *urlString = [[request URL] absoluteString];
    
    NSLog(@"协议URL => %@",urlString);
    
    NSArray *urlComps = [urlString componentsSeparatedByString:@"://"];
    
    if([urlComps count] && [[urlComps objectAtIndex:0] isEqualToString:@"objc"]){
        
        NSLog(@"方法名及参数URL => %@",urlComps.lastObject);
        
        NSString * parmeterURL = [urlComps lastObject];

        //获取参数
        NSArray * parmeters = [parmeterURL componentsSeparatedByString:@"?"];
        
        NSString * parStr = [parmeters lastObject];
        
        NSLog(@"携带参数的字符串 => %@",parStr);
        
        return NO;
    }
    return YES;
}
```

点击网页中的按钮打印如下所示：

![](http://static.oschina.net/uploads/space/2016/1019/171032_Xezx_2279344.png)

现在我们成功拦截到了协议中的方法名和参数，这样你就可以进行后续的处理了！

**问题：**

这种方法主要是通过JS调用一个我们自己的通用协议URL，iOS端通过拦截的方法，来达到JS调用OC的目的，但是这存在不少问题，比如JS如果连续请求两次以上协议，iOS端只能拦截最后一个，这样就无法真正的做到JS调用OC；另外通过拦截的方法的在执行效率上比较慢！

那么还有更好的方法么？当然这就需要我们用到_JavaScriptCore_来实现了，一下是第二种方法：

## 方法2：

通过注入JS代码来消除JS异常情况，并实现上下文的Block回调，来实现调用OC的目的，下面为具体的步骤：

一、引入_JavaScriptCore_库_：_

```objectivec
@import JavaScriptCore;
```

二、在页面加载完成后，获取JS上下文:

```objectivec
//获取JS上下文
    JSContext *context = [self.webView valueForKeyPath:@"documentView.webView.mainFrame.javaScriptContext"];
```

三、注入JS代码来触发block：

```objectivec
//定义好JS要调用的方法,如shareWB
    context[@"shareWB"] = ^() {
        
        // your code
    };
```

### _Demo2:_

第一种： 无参数的方法

通过JS调用和iOS端协商好的方法，在JS中并未实现，所以在JS中属于异常的情况，下面为H5和JS代码:

```html
<h2>第二种方法</h2>
<input type="button" onclick="shareWebo()" value="第二种方法">

<script type="text/javascript">
    function shareWebo() {
        //这是和iOS端协商好的方法，在JS中并未实现，所以在JS中属于异常的情况
        shareWB();
    }
</script>
```

捕获异常，即注入JS代码使消除异常情况，OC主要代码：

```objectivec
- (void)webViewDidFinishLoad:(UIWebView *)webView{
    NSLog(@"页面加载完成");
    
    //获取JS上下文
    JSContext *context = [self.webView valueForKeyPath:@"documentView.webView.mainFrame.javaScriptContext"];
    //定义好JS要调用的方法,如shareWB
    context[@"shareWB"] = ^() {
        
        NSLog(@"shareWB 我被调用了！");
        
        NSArray *args = [JSContext currentArguments];

        for (JSValue *jsVal in args) {
            NSLog(@"%@", jsVal.toString);
        }
        
    };
}
```

点击网页中的按钮打印如下所示：

![](http://static.oschina.net/uploads/space/2016/1019/172535_4eor_2279344.png)

第二种： 有参数的方法

下面为H5和JS代码:

```html
<h4>有参数的方法</h4>
<input type="button" onclick="shareMessage()" value="有参数的方法">

<script type="text/javascript">
    function shareMessage(){
        //带参数的 未实现的方法, JS中同样属于异常的情况
        shareMsg("p1","p2");
    }
</script>
```

OC主要代码：

```objectivec
- (void)webViewDidFinishLoad:(UIWebView *)webView{
    NSLog(@"页面加载完成");
    
    //获取JS上下文
    JSContext *context = [self.webView valueForKeyPath:@"documentView.webView.mainFrame.javaScriptContext"];

    context[@"shareMsg"] = ^() {
        
        NSLog(@"shareMsg 我被调用了！");
        
        NSArray *args = [JSContext currentArguments];
        
        for (JSValue *jsVal in args) {
            NSLog(@"参数 => %@", jsVal.toString);
        }
        
    };
    
}
```

点击网页中的按钮打印如下所示：

![](http://static.oschina.net/uploads/space/2016/1019/173324_xLBs_2279344.png)

**问题：**

**可以同时触发多个事件么？以下是测试结果：**

**在JS中调用两个方法：**

```html
<script type="text/javascript">

        function shareMessage(){
            //带参数的 未实现的方法, JS中同样属于异常的情况
            shareWB();
            shareMsg("p1","p2");
        }
    </script>
```

OC中的打印结果：

![](http://static.oschina.net/uploads/space/2016/1019/173725_pdRl_2279344.png)

**经测试，答案是肯定的！**

下面我们探讨一下OC Call JS:

# 二、OC Call JS

### 方法一：

通过向UIWebView注入JS方法来调用JS内部的方法，如下所示：

```objectivec
- (IBAction)callJS:(id)sender {
    //调用js方法的字符串
    NSString *jsStr = [NSString stringWithFormat:@"alertMsg('%@')",@"提示的信息"];
    
    //将js注入webView
    [self.webView stringByEvaluatingJavaScriptFromString:jsStr];
}
```

以下是JS主要代码：

```html
    <script type="text/javascript">
        //被oc调用的方法
        function alertMsg(msg) {
            alert(msg);
        }
    </script>
```

以下是运行的效果，看这个弹出可以JS调用的哦：

![](http://static.oschina.net/uploads/space/2016/1019/175108_Iz7x_2279344.png)

### 方法二：

使用JavaScriptCore来和JS交互

```objectivec
- (IBAction)callJS:(id)sender {
    //获取JS上下文
    JSContext *context = [self.webView valueForKeyPath:@"documentView.webView.mainFrame.javaScriptContext"];
    
    //JS代码字符串
    NSString *JS = @"alertMsg('提示信息2')";
    [context evaluateScript:JS];
}

```

以下是JS主要代码：

```html
    <script type="text/javascript">
        //被oc调用的方法
        function alertMsg(msg) {
            alert(msg);
        }
    </script>
```

以下是运行的效果，看这个弹出可以JS调用的哦：

![](http://static.oschina.net/uploads/space/2016/1019/175816_8NR7_2279344.png)

**注意：**

以上两种方法都是同步方法，如果JS比较耗时，会造成界面卡顿，建议将JS耗时的程序放在异步线程中执行！比如alert()方法就会阻塞UI主线程_(注意：按钮‘注入JS’此时为高亮状态，说明弹窗阻塞了主线程，在等待用户响应)_，我们可以通过setTimeout()方法来实现异步执行的目的，如下所示：

```html
    <script type="text/javascript">
        //被oc调用的方法
        function alertMsg(msg) {
            //异步执行
            setTimeout(function(){
                alert(msg);
            },1);
        }
    </script>
```

以下为运行结果，_‘注入JS’按钮恢复了正常状态，说明此时alert()是异步执行的。_

  
![](http://static.oschina.net/uploads/space/2016/1019/181051_MhWI_2279344.png)