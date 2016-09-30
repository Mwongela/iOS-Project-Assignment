//
//  EventsViewController.m
//  FacebookDemo
//
//  Created by ilabafrica on 11/08/2016.
//  Copyright © 2016 strathmore. All rights reserved.
//

#import "EventsViewController.h"
#import <FBSDKLoginKit/FBSDKLoginKit.h>
#import <FBSDKCoreKit/FBSDKCoreKit.h>
#import <FBSDKShareKit/FBSDKShareKit.h>

@interface EventsViewController ()

@end

@implementation EventsViewController
@synthesize event = _event;
@synthesize imgImage = _imgImage, lblName = _lblName, lblDescription = _lblDescription;
@synthesize txtViewName = _txtViewName, txtViewDescription = _txtViewDescription;

- (void)viewDidLoad {
    [super viewDidLoad];
    // Do any additional setup after loading the view.
    [_imgImage setImage:[UIImage imageNamed:_event.image]];
    //    [_lblName setText:_languages.name];
    //    _lblDescription.text = _languages.langDescription;
    [_txtViewName setText:_event.name];
    _txtViewDescription.text = _event.eventDescription;
    FBSDKShareLinkContent *content = [[FBSDKShareLinkContent alloc] init];
    content.contentTitle= _event.name;
    content.contentDescription= _event.eventDescription;
    //content.photos=_Events.image;
    //    NSURL *imageURL =
    //    [NSURL URLWithString:@"hike.jpg"];
    
    content.contentURL = [NSURL
                          URLWithString:@"https://www.facebook.com"], [UIImage imageNamed:_event.name];
    //content.imageURL=[NSURL URLWithString:@"wed.jpg"];
    //content.image= _Events.image;
    FBSDKShareButton *shareButton = [[FBSDKShareButton alloc] init];
    shareButton.shareContent = content;
    //shareButton.
    //    shareButton.shareContent=_lblName;
    shareButton.center = self.view.center;
    [self.view addSubview:shareButton];
}

- (void)didReceiveMemoryWarning {
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

/*
#pragma mark - Navigation

// In a storyboard-based application, you will often want to do a little preparation before navigation
- (void)prepareForSegue:(UIStoryboardSegue *)segue sender:(id)sender {
    // Get the new view controller using [segue destinationViewController].
    // Pass the selected object to the new view controller.
}
*/

@end
