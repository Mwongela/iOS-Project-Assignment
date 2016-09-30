
#import <Foundation/Foundation.h>
#import "BaseDataService.h"

@interface SearchDataService : BaseDataService


-(NSMutableArray *) getSearchedFilmFromAPI:(NSString *)searchParam;



@end
