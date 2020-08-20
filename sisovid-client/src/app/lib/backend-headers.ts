import { HttpHeaders, } from '@angular/common/http';
import { RequestOptions } from '@angular/http';

export class BackendHeaders {
	constructor() { }

	public setHeaders(extraHeaders: any = null): any {
		const headers = {
			'Content-Type': 'application/json',
			'Authorization': `Bearer ${localStorage.getItem('token')}`
		};

		if (extraHeaders) {
			for (const k in extraHeaders) {
				if (extraHeaders.hasOwnProperty(k)) {
					headers[k] = extraHeaders[k];
				}
			}
		}

		return new HttpHeaders(headers);
	}

	public setRequestOptions(extraOptions: any = null): any {
		const options: any = {
			headers: this.setHeaders(),
		};

		if (extraOptions) {
			for (const k in extraOptions) {
				if (extraOptions.hasOwnProperty(k)) {
					options[k] = extraOptions[k];
				}
			}
		}

		return new RequestOptions(options);
	}
}