import { HttpHeaders } from '@angular/common/http';
import { Constants } from './constants/backend';

export class Globals {

  api = Constants.API_URL;

  get httpOptions(): any {
    return { headers: new HttpHeaders({ 'Content-Type': 'application/json' }) };
    // return { headers: new HttpHeaders({ 'Content-Type': 'application/json', 'token': this.storage.get('token') }) };
  }

  get httpOptionsAsync(): any {
    return  { headers: new HttpHeaders({ }), reportProgress: true };
    // return  { headers: new HttpHeaders({ 'token': this.storage.get('token') }), reportProgress: true };
  }


}
