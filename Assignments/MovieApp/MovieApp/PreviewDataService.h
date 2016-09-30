

#import <Foundation/Foundation.h>
#import "AppDelegate.h"
#import "BaseDataService.h"
#import "PreviewFilm.h"

@interface PreviewDataService : BaseDataService


-(PreviewFilm *) getFilmPreviewFromAPI:(NSString *)urlParameter;


@end
