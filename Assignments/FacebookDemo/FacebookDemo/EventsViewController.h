//
//  EventsViewController.h
//  FacebookDemo
//
//  Created by ilabafrica on 11/08/2016.
//  Copyright © 2016 strathmore. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "Event.h"

@interface EventsViewController : UIViewController
@property (weak, nonatomic) IBOutlet UIImageView *imgImage;
@property (weak, nonatomic) IBOutlet UILabel *lblName;
@property (weak, nonatomic) IBOutlet UILabel *lblDescription;
@property (weak, nonatomic) IBOutlet UITextField *txtViewName;
@property (weak, nonatomic) IBOutlet UITextField *txtViewDescription;
@property (strong, nonatomic) Event *event;
@end
