//
//  HomeViewController.m
//  FacebookDemo
//
//  Created by ilabafrica on 11/08/2016.
//  Copyright © 2016 strathmore. All rights reserved.
//

#import "HomeViewController.h"
#import "Event.h"
#import "EventsViewController.h"

@interface HomeViewController ()
@end

@implementation HomeViewController{
    
    NSArray *events;
}

- (void)viewDidLoad {
    [super viewDidLoad];
    self.myTableView.delegate = self;
    //self.myTableView.datasource = self;
    // Do any additional setup after loading the view.
    Event *event1 = [Event new];
    event1.name = @"6 AM";
    event1.eventDescription = @"6 AM Entertainment";
    event1.image = @"6am";
    
    Event *event2 = [Event new];
    event2.name = @"Safaricom 7s";
    event2.eventDescription = @"Enjoy live Rugby at Safaricom Stadium";
    event2.image = @"safcom7";
    
    Event *event3 = [Event new];
    event3.name = @"Blankets and Wine";
    event3.eventDescription = @"Live Band Performance";
    event3.image = @"BnW";
    
    Event *event4 = [Event new];
    event4.name = @"Kid's Festival";
    event4.eventDescription = @"Back to school fun games";
    event4.image = @"kids";
    
    events = [NSArray arrayWithObjects:event1,event2,event3,event4, nil];
}

- (void)didReceiveMemoryWarning {
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}
- (NSInteger)tableView:(UITableView *)tableView numberOfRowsInSection:(NSInteger)section{
    return [events count];
}
-(UITableViewCell *)tableView:(UITableView *)tableView cellForRowAtIndexPath:(NSIndexPath *)indexPath{
    static NSString *simpleTableIdentifier = @"SimpleTableItem";
    
    UITableViewCell *cell = [tableView dequeueReusableCellWithIdentifier:simpleTableIdentifier];
    
    if(cell == nil){
        cell = [[UITableViewCell alloc] initWithStyle:UITableViewCellStyleSubtitle reuseIdentifier:simpleTableIdentifier];
    }
    Event *evt = ((Event *)events[indexPath.row]);
    
    cell.textLabel.text = evt.name;
    cell.detailTextLabel.text=evt.eventDescription;
    cell.imageView.image = [UIImage imageNamed:evt.image];
    return cell;
}

-(void)prepareForSegue:(UIStoryboardSegue *)segue sender:(id)sender{
    NSInteger index = [self.myTableView indexPathForSelectedRow].row;
    
    if([segue.identifier isEqualToString:@"DisplayDetails"]){
        [(EventsViewController*)segue.destinationViewController setEvent:[self objectInListAtIndex:index]];
        //        [(DetailsViewController *)segue.destinationViewController setLanguages:[self objectInListAtIndex: index]];
    }
}
-(Event *)objectInListAtIndex: (NSInteger)index{
    return [events objectAtIndex:index];
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
