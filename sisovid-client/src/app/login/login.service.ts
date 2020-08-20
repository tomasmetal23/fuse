
import { throwError as observableThrowError, Observable } from 'rxjs';

import { catchError, map } from 'rxjs/operators';
import { Injectable } from '@angular/core';
import { HttpClient, HttpErrorResponse, HttpHeaders } from '@angular/common/http';
import { Constants } from '../constants/backend';
import { BackendHeaders } from '../lib/backend-headers';
import { HistoryRouterService } from '../services/history-router.service';



import * as jwtDecode from 'jwt-decode';
import { Router } from '@angular/router';

@Injectable({
  providedIn: 'root'
})
export class LoginService extends BackendHeaders {
  public token: string;

  constructor(
    private http: HttpClient,
    private router: Router,
    private historyRouter: HistoryRouterService
  ) {
    super();
  }

  public auth(user: string, password: string): Observable<boolean> {
    const url = `${Constants.API_URL}auth/login`;
    return this.http.post(url, {
      user: user,
      password: password
    }).pipe(
      map((response: any) => {

        const token = response && response.token;

        if (token) {
          this.token = token;

          const userData = jwtDecode(token);

          /*if (userData.newUser) {
              throw {error: 'request-init'};
          }*/

          this.storeLocal(token);
          return true;
        } else {
          return false;
        }
      }),
      catchError(this.handleError));
  }

  public recovery(email: string): Observable<any> {
    const url = `${Constants.API_URL}users/password/reset`;
    return this.http.post(url, { email: email }, { observe: 'response' });
  }

  public validateToken(token: string) {
    const url = `${Constants.API_URL}users/password/reset/${token}`;
    return this.http.get(url, { observe: 'response' });
  }

  public reset(password: string, token: string) {
    const url = `${Constants.API_URL}users/password/reset/${token}`;

    return this.http.put(url, { password }, { observe: 'response' });
  }

  private handleError(err: HttpErrorResponse): Observable<never> {
    // in a real world app, we may send the server to some remote logging infrastructure
    // instead of just logging it to the console
    let errorMessage = '';

    if (err.error instanceof Error) {
      // A client-side or network error occurred. Handle it accordingly.
      errorMessage = `An error occurred: ${err.error.message}`;
    }
    else if (err.error === 'request-init') {
      errorMessage = err.error;
    }
    else if (err instanceof HttpErrorResponse) {
      if (err.status === 401) {
        // redirect to the login route
        // or show a modal
        errorMessage = `Not auth`;
      }
    }
    else {
      // The backend returned an unsuccessful response code.
      // The response body may contain clues as to what went wrong,
      // errorMessage = `Server returned code: ${err.status}, error message is: ${err.message}`;
    }

    return observableThrowError(errorMessage);
  }

  public storeLocal(token: string): void {
    const userData = jwtDecode(token);
    localStorage.setItem('token', token);
  }

  logout(): void {
    this.historyRouter.pushLogout();
    localStorage.removeItem('token');
    localStorage.clear();
    this.router.navigate(['/login']);
  }

  _new(data): any {
    const userData = jwtDecode(this.token);
    const url = `${Constants.API_URL}users/new`;
    const httpOptions = {
      headers: new HttpHeaders({ 'Content-Type': 'application/json', 'token': this.token })
    };
    return this.http.put(url, data, httpOptions);
  }

}
