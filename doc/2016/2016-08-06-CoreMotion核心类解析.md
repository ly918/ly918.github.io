---
title:  【iOS Framework】CoreMotion核心类解析
description: 在小小的iPhone手机中集成了许多传感器，比如：影响传感器，亮度传感器，声波传感器，压力传感器，温度传感器，加速度传感器，角速度传感器(陀螺仪)等待。“智能手机”的根源也在于此。
categories:
 - iOS
 - iOS Framework
tags:
 - CoreMotion
 - 传感器
---

在小小的iPhone手机中集成了许多传感器，比如：影响传感器，亮度传感器，声波传感器，压力传感器，温度传感器，加速度传感器，角速度传感器(陀螺仪)等待。“智能手机”的根源也在于此。

## 一、CoreMotion概述

CoreMotion，顾名思义，它是运动传感器的核心库。该库主要包含：加速度传感器、陀螺仪、磁力仪等。

## 二、CoreMotion API解析

### 1、头文件解析

```objectivec
#import <CoreMotion/CMAccelerometer.h>//加速度计
#import <CoreMotion/CMAltimeter.h>//高度计
#import <CoreMotion/CMAltitude.h>//高度数据
#import <CoreMotion/CMAttitude.h>//姿态数据
#import <CoreMotion/CMAuthorization.h>//授权信息
#import <CoreMotion/CMAvailability.h>//宏定义
#import <CoreMotion/CMDeviceMotion.h>//设备动作数据模型
#import <CoreMotion/CMError.h>//错误码定义
#import <CoreMotion/CMErrorDomain.h>//错误域定义
#import <CoreMotion/CMGyro.h>//陀螺仪
#import <CoreMotion/CMLogItem.h>//数据模型的基类
#import <CoreMotion/CMMagnetometer.h>//磁力计
#import <CoreMotion/CMMotionActivity.h>//运动状态数据模型
#import <CoreMotion/CMMotionActivityManager.h>//运动状态数据管理类
#import <CoreMotion/CMMotionManager.h>//设备动作管理类
#import <CoreMotion/CMPedometer.h>//步程计
#import <CoreMotion/CMStepCounter.h>//计步器
#import <CoreMotion/CMSensorRecorder.h>//传感器记录仪,可以使应用程序即使不打开也可以记录一些数据
```

### 2、CMMotionManager API解析

```objectivec
//CMMotionManager

/**
 加速计数据采集的时间间隔，以s为单位。
 在startAccelerometerUpdatesToQueue:withHandler:之前设置
 你可以通过CMAcceleration对象的时间戳确定真正的采集时间
 */
@property(assign, nonatomic) NSTimeInterval accelerometerUpdateInterval __TVOS_PROHIBITED;

/*
 加速计是否可用
 */
@property(readonly, nonatomic, getter=isAccelerometerAvailable) BOOL accelerometerAvailable __TVOS_PROHIBITED;

/*
 加速计是否处于活动状态
 */
@property(readonly, nonatomic, getter=isAccelerometerActive) BOOL accelerometerActive __TVOS_PROHIBITED;

/*
 返回最新的加速计数据，可能为nil
 */

@property(readonly, nullable) CMAccelerometerData *accelerometerData __TVOS_PROHIBITED;

/*
 开始采集，可通过accelerometerData属性获取最新数据
 */
- (void)startAccelerometerUpdates __TVOS_PROHIBITED;

/*
 开始采集。需要传入一个操作队列NSOperationQueue,当停止加速计，这个queue会被取消。在withHandler中获取采集的数据
 */
- (void)startAccelerometerUpdatesToQueue:(NSOperationQueue *)queue withHandler:(CMAccelerometerHandler)handler __TVOS_PROHIBITED;

/*
 停止采集
 */
- (void)stopAccelerometerUpdates __TVOS_PROHIBITED;

/*
 陀螺仪数据采集的时间间隔，以s为单位。
 在startGyroUpdatesToQueue:withHandler:之前设置
 你可以通过CMGyroData对象的时间戳确定真正的采集时间
 */
@property(assign, nonatomic) NSTimeInterval gyroUpdateInterval __TVOS_PROHIBITED;

/*
 陀螺仪是否可用
 */
@property(readonly, nonatomic, getter=isGyroAvailable) BOOL gyroAvailable __TVOS_PROHIBITED;

/*
 陀螺仪是否处于活动状态
 */
@property(readonly, nonatomic, getter=isGyroActive) BOOL gyroActive __TVOS_PROHIBITED;

/*
 最新陀螺仪采集样本数据
 */
@property(readonly, nullable) CMGyroData *gyroData __TVOS_PROHIBITED;

/*
 开始采集
 */
- (void)startGyroUpdates __TVOS_PROHIBITED;

/*
 开始采集。需要传入NSOperationQueue操作队列，停止采集，该队列会被取消
 */
- (void)startGyroUpdatesToQueue:(NSOperationQueue *)queue withHandler:(CMGyroHandler)handler __TVOS_PROHIBITED;

/*
 停止采集
 */
- (void)stopGyroUpdates __TVOS_PROHIBITED;

/*
 磁力仪采集周期
 */
@property(assign, nonatomic) NSTimeInterval magnetometerUpdateInterval NS_AVAILABLE(NA, 5_0) __TVOS_PROHIBITED;

/*
 磁力仪是否可用
 */
@property(readonly, nonatomic, getter=isMagnetometerAvailable) BOOL magnetometerAvailable NS_AVAILABLE(NA, 5_0) __TVOS_PROHIBITED;

/*
 磁力仪是否处于活动状态
 */
@property(readonly, nonatomic, getter=isMagnetometerActive) BOOL magnetometerActive NS_AVAILABLE(NA, 5_0) __TVOS_PROHIBITED;

/*
 磁力仪采集数据
 */
@property(readonly, nullable) CMMagnetometerData *magnetometerData NS_AVAILABLE(NA, 5_0) __TVOS_PROHIBITED;

/*
 开始采集
 */
- (void)startMagnetometerUpdates NS_AVAILABLE(NA, 5_0) __TVOS_PROHIBITED;

/*
 开始采集
 */
- (void)startMagnetometerUpdatesToQueue:(NSOperationQueue *)queue withHandler:(CMMagnetometerHandler)handler NS_AVAILABLE(NA, 5_0) __TVOS_PROHIBITED;

/*
 停止采集
 */
- (void)stopMagnetometerUpdates NS_AVAILABLE(NA, 5_0) __TVOS_PROHIBITED;

/*
 设备运动数据采集周期
 */
@property(assign, nonatomic) NSTimeInterval deviceMotionUpdateInterval __TVOS_PROHIBITED;

/*
 返回设备可用的姿态参考坐标系
 */
+ (CMAttitudeReferenceFrame)availableAttitudeReferenceFrames NS_AVAILABLE(NA, 5_0) __TVOS_PROHIBITED;

/*
 返回当前使用的参考系
 *
 */
@property(readonly, nonatomic) CMAttitudeReferenceFrame attitudeReferenceFrame NS_AVAILABLE(NA, 5_0) __TVOS_PROHIBITED;

/*
 通过设备任何一个姿态参考系来确定设备的运动采集是否可用
 */
@property(readonly, nonatomic, getter=isDeviceMotionAvailable) BOOL deviceMotionAvailable __TVOS_PROHIBITED;

/*
 当前运动采集是否处于活动状态
 */
@property(readonly, nonatomic, getter=isDeviceMotionActive) BOOL deviceMotionActive __TVOS_PROHIBITED;

/*
 返回最新的设备运动采集数据
 */
@property(readonly, nullable) CMDeviceMotion *deviceMotion __TVOS_PROHIBITED;

/*
 开始采集运动数据
 */
- (void)startDeviceMotionUpdates __TVOS_PROHIBITED;

/*
 开始采集运动数据
 */
- (void)startDeviceMotionUpdatesToQueue:(NSOperationQueue *)queue withHandler:(CMDeviceMotionHandler)handler __TVOS_PROHIBITED;

/*
 开始采集运动数据，需要传入参考系
 */
- (void)startDeviceMotionUpdatesUsingReferenceFrame:(CMAttitudeReferenceFrame)referenceFrame NS_AVAILABLE(NA, 5_0) __TVOS_PROHIBITED;

/*
 开始采集运动数据，需要传入参考系...
 */
- (void)startDeviceMotionUpdatesUsingReferenceFrame:(CMAttitudeReferenceFrame)referenceFrame toQueue:(NSOperationQueue *)queue withHandler:(CMDeviceMotionHandler)handler NS_AVAILABLE(NA, 5_0) __TVOS_PROHIBITED;

/*
 停止采集
 */
- (void)stopDeviceMotionUpdates __TVOS_PROHIBITED;

/*
 是否显示运动设备 默认为NO
 */
@property(assign, nonatomic) BOOL showsDeviceMovementDisplay NS_AVAILABLE(NA, 5_0) __TVOS_PROHIBITED;

```

### 3、加速度传感器采样的使用

3.1、下面通过一个简单的demo，来看看加速度传感器采样的使用。

```objectivec
#import "AccelerometerViewController.h"
#import <CoreMotion/CoreMotion.h>

@interface AccelerometerViewController ()
@property (weak, nonatomic) IBOutlet UILabel *infoL;//显示x,y,z轴方向上的加速度
@property (nonatomic, strong)CMMotionManager *motionManager;//运动行为管理者
@property (nonatomic, strong)UIDynamicAnimator *animator;//动力学动画
@property (nonatomic, strong)UIGravityBehavior *gravityBehavior;//重力行为
@property (nonatomic, strong)UICollisionBehavior *collisionBehavior;//碰撞检测行为
@end

@implementation AccelerometerViewController
- (void)dealloc{
    NSLog(@"AccelerometerViewController Dealloc!");
}

- (void)viewWillAppear:(BOOL)animated{
    [super viewWillAppear:animated];
    if (self.motionManager.accelerometerAvailable) {//是否可用
        [self.motionManager stopAccelerometerUpdates];//停止
        [self.motionManager startAccelerometerUpdatesToQueue:[NSOperationQueue currentQueue] withHandler:^(CMAccelerometerData * _Nullable accelerometerData, NSError * _Nullable error) {
            [self updateData:accelerometerData];
        }];
    }
    
}

- (void)viewWillDisappear:(BOOL)animated{
    [super viewWillDisappear:animated];
    [_motionManager stopAccelerometerUpdates];
}

- (void)viewDidLoad {
    [super viewDidLoad];

    //创建球
    NSMutableArray *balls = [NSMutableArray array];
    for (int i=0; i<=1; i++) {
        UIView *ball = [[UIView alloc]initWithFrame:CGRectMake(0, 0, 60, 60)];
        [self.view addSubview:ball];
        [self.view sendSubviewToBack:ball];
        ball.backgroundColor = [UIColor colorWithRed:arc4random()%256/256.f green:arc4random()%256/256.f blue:arc4random()%256/256.f alpha:1];
        [balls addObject:ball];
    }
    
    _animator = [[UIDynamicAnimator alloc]initWithReferenceView:self.view];
    //重力
    _gravityBehavior = [[UIGravityBehavior alloc]initWithItems:balls];
    _gravityBehavior.gravityDirection = CGVectorMake(0, 0);//初始化方向矢量
    [_animator addBehavior:_gravityBehavior];
    //碰撞
    _collisionBehavior = [[UICollisionBehavior alloc]initWithItems:balls];
    _collisionBehavior.translatesReferenceBoundsIntoBoundary = YES;//将参考边界转换为边界
    [_animator addBehavior:_collisionBehavior];
    
}

- (void)updateData:(CMAccelerometerData *)data{
    NSLog(@"x=%f y=%f z=%f",data.acceleration.x,data.acceleration.y,data.acceleration.z);
    self.infoL.text = [NSString stringWithFormat:@"x:%f y:%f z:%f",data.acceleration.x,data.acceleration.y,data.acceleration.z];
    self.gravityBehavior.gravityDirection = CGVectorMake(data.acceleration.x, -data.acceleration.y);
}

- (CMMotionManager *)motionManager{
    if (!_motionManager) {
        _motionManager = [[CMMotionManager alloc]init];
        _motionManager.accelerometerUpdateInterval = 1;
    }
    return _motionManager;
}
@end

```

加速度计的原理很简单，现在手机里面基本配备的都是3维线传感器，也就是说，用来测量x，y，z三个轴上的加速力。加速力就是当物体在加速过程中作用在物体上的力，就好比地球引力，也就是重力。CMAccelerometerData中的acceleration结构体的x,y,z值可参考下图所示：

![](https://static.oschina.net/uploads/img/201808/06114138_hhJS.png)

### 4、陀螺仪的使用

和加速度传感器类似：

```objectivec
#import "GyroViewController.h"
#import <CoreMotion/CoreMotion.h>

@interface GyroViewController ()
@property (nonatomic, strong)CMMotionManager *motionManager;

@end

@implementation GyroViewController
- (void)dealloc{
    NSLog(@"GyroViewController Dealloc!");
}

- (void)viewWillAppear:(BOOL)animated{
    [super viewWillAppear:animated];
    if (self.motionManager.gyroAvailable) {//是否可用
        [self.motionManager stopGyroUpdates];//停止
        [self.motionManager startGyroUpdatesToQueue:[NSOperationQueue currentQueue] withHandler:^(CMGyroData * _Nullable gyroData, NSError * _Nullable error) {
            [self updateData:gyroData];
        }];
    }
}

- (void)viewWillDisappear:(BOOL)animated{
    [super viewWillDisappear:animated];
    [_motionManager stopGyroUpdates];
}

- (void)updateData:(CMGyroData *)data{
    NSLog(@"%@",data);
}

- (void)viewDidLoad {
    [super viewDidLoad];
    // Do any additional setup after loading the view.
}

- (CMMotionManager *)motionManager{
    if (!_motionManager) {
        _motionManager = [[CMMotionManager alloc]init];
        _motionManager.gyroUpdateInterval = 1;
    }
    return _motionManager;
}

@end

```

陀螺仪的主要作用，是基于角动量守恒的理论，沿着某个特定的坐标轴测量旋转速率。在使用中，陀螺仪的转子在高速旋转时，始终指向一个固定的方向，当运动物体的运动方向偏离预定方向时，陀螺仪就可以感受出来。CMGyroData中的rotationRate的x,y,z三个轴瞬时角速度如下图所示：

![](https://static.oschina.net/uploads/img/201808/06114138_DGQ9.png)

### 五、摇一摇

使用到UIResponder类中的方法如下所示：

```objectivec
- (void)motionBegan:(UIEventSubtype)motion withEvent:(UIEvent *)event{
    NSLog(@"motionBegan");
}

- (void)motionEnded:(UIEventSubtype)motion withEvent:(UIEvent *)event{
    NSLog(@"motionEnded");
}

- (void)motionCancelled:(UIEventSubtype)motion withEvent:(UIEvent *)event{
    NSLog(@"motionCancelled");
}

```

### 六、计步器：查询步数等

1、在Info.plist中添加运动数据请求权限信息：

![](https://oscimg.oschina.net/oscnet/ffbd9f9ec335c7c8fd4c0b8dd3c6cb228be.jpg)

2、检查可用性及权限：

```objectivec
//1
    if (![CMPedometer isStepCountingAvailable]) {
        //计步器不可用
        return;
    }
    if (@available(iOS 11.0, *)) {
        if ([CMPedometer authorizationStatus]==CMAuthorizationStatusDenied||[CMPedometer authorizationStatus]==CMAuthorizationStatusRestricted) {
            //检查权限
            return;
        }
    }
```

3、查询时间段步数

```objectivec
//2
    _pedometer = [[CMPedometer alloc]init];
    NSDate *now = [NSDate date];
    NSTimeInterval aWeekBefore = [now timeIntervalSince1970] - 60 * 60 * 24 * 7;
    
    [_pedometer queryPedometerDataFromDate:[NSDate dateWithTimeIntervalSince1970:aWeekBefore] toDate:now withHandler:^(CMPedometerData * _Nullable pedometerData, NSError * _Nullable error) {
        dispatch_async(dispatch_get_main_queue(), ^{
            NSLog(@"%@",pedometerData);
            self.stepL.text = pedometerData.numberOfSteps.stringValue;
        });
    }];
```