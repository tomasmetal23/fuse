import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Globals } from 'app/globals';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})

export class AreaService {
  private uri: string;
  private resource: string;
  private httpOptions: any;
  private httpOptionsAsync: any;

  constructor(private http: HttpClient, private global: Globals) {
    this.uri = global.api;
    this.resource = 'areas';
    this.httpOptions = global.httpOptions;
    this.httpOptionsAsync = global.httpOptionsAsync;  
  }

  getList(id: number): Observable<any> {
    return this.http.get(this.uri + 'direcciones' + '/' + id + '/' + this.resource, this.httpOptions);
  }

  store(params: any): Observable<any> {
    return this.http.post(this.uri + this.resource, params, this.httpOptions);
  }

  delete(id: number): Observable<any> {
    return this.http.delete(this.uri + this.resource + '/' + id, this.httpOptions);
  }

  update(id: number, params: any): Observable<any> {
    return this.http.put(this.uri + this.resource + '/' + id, params, this.httpOptions);
  }
}
