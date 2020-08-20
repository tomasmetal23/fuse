import { Injectable } from '@angular/core';
import {
	HttpClient,
	HttpRequest,
	HttpEventType,
	HttpResponse
} from '@angular/common/http';
import { Observable, Subject } from 'rxjs';
import { Globals } from '../globals';

@Injectable({
	providedIn: 'root'
})
export class ExpedientService {
	private uri: string;
	private module: string;
	private httpOptions: any;
	private httpOptionsAsync: any;

	constructor(private http: HttpClient, private global: Globals) {
		this.uri = global.api;
		this.module = 'init/catalogs';
		this.httpOptions = global.httpOptions;
		this.httpOptionsAsync = global.httpOptionsAsync;
	}

	get(file_id: number): Observable<any> {
		return this.http.get(this.uri + 'files/' + file_id, this.httpOptions);
	}


	getList(search: string, page: number): Observable<any> {
		const urlParams = `?search=${search}&page=${page + 1}`;
		return this.http.get(`${this.uri}files${urlParams}`, this.httpOptions);
	}

	getCatalogs(): Observable<any> {
		return this.http.get(this.uri + this.module, this.httpOptions);
	}

	store(form: any): Observable<any> {
		return this.http.post(this.uri + 'files', form, this.httpOptions);
	}

	update(form: any, id: number): Observable<any> {
		return this.http.put(this.uri + 'files/' + id, form, this.httpOptions);
	}

	saveImage(file_id: string, files: any): { [key: string]: Observable<number> } {
		const status = {};

		files.forEach(file => {
			const formData: FormData = new FormData();
			formData.append('file_id', file_id);
			formData.append('file', file);

			const req = new HttpRequest(
				'POST',
				this.uri + 'files/media/victim-image',
				formData,
				this.httpOptionsAsync
			);
			const progress = new Subject<number>();
			const startTime = new Date().getTime();

			this.http.request(req).subscribe(event => {
				if (event.type === HttpEventType.UploadProgress) {
					const percentDone = Math.round((100 * event.loaded) / event.total);
					progress.next(percentDone);
				} else if (event instanceof HttpResponse) {
					progress.complete();
				}
			});

			status[file.name] = {
				progress: progress.asObservable()
			};
		});

		return status;
	}

	delete(media_id: number): Observable<any> {
		return this.http.delete(this.uri + 'files/media/' + media_id, this.httpOptions);
	}
}
