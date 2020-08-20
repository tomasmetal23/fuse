import { Injectable } from '@angular/core';
import {
  HttpRequest,
  HttpHandler,
  HttpEvent,
  HttpInterceptor,
  HttpResponse
} from '@angular/common/http';
import { AuthService } from '../services/auth.service';
import { Observable } from 'rxjs';
import { tap } from 'rxjs/operators';
import { CommunicationService } from 'app/services/communication.service';
import { LoginService } from 'app/login/login.service';
@Injectable()
export class TokenInterceptor implements HttpInterceptor {
  constructor(public auth: AuthService, private communicationService: CommunicationService, private loginService: LoginService) { }
  intercept(request: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {

    if (request.url.indexOf('auth/login') < 0 && request.url.indexOf('users/new') < 0 && request.url.indexOf('users/password') < 0) {
      request = request.clone({
        setHeaders: {
          token: this.auth.token
        }
      });
    }

    return next.handle(request)
      .pipe(
        tap(event => {
          if (event instanceof HttpResponse) {}
        }, error => {
          console.log(error);
          if (request.url.indexOf('auth/login') < 0 && request.url.indexOf('password/reset') < 0) {
            if (error.status === 400) {
              const reload = request.method === 'GET' ? true : false; 
              this.communicationService.emitChange(reload);
            } else if (error.status === 401) {
              this.loginService.logout();
            }
          }
        })
      );
  }
}
