

#import <Foundation/Foundation.h>

@interface Film : NSObject
@property (strong, nonatomic) NSString *title;
@property (strong, nonatomic) NSString *year;
@property (strong, nonatomic) NSString *imdbID;
@property (strong, nonatomic) NSString *type;
@property (strong, nonatomic) NSString *poster;

@property (strong, nonatomic) NSMutableArray *films;

-(instancetype) initWithAttributes: (NSDictionary *)attributes;

@end
