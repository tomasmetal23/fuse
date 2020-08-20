import { Component, ViewEncapsulation } from '@angular/core';
import { GoogleAnalyticsService } from 'app/services/google-analytics.service';

@Component({
	selector: 'content',
	templateUrl: './content.component.html',
	styleUrls: ['./content.component.scss'],
	encapsulation: ViewEncapsulation.None
})
export class ContentComponent {

	constructor(private googleAnalyticsService: GoogleAnalyticsService) {
	}

	ngOnInit() {
		// subscribe to the ga posts
		this.googleAnalyticsService.subscribe();
	}

	ngOnDestroy() {
		// unsubscribe to the post
		this.googleAnalyticsService.unsubscribe();
	}
}
