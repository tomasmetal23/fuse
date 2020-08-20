import { Injectable } from '@angular/core';
import { Router, NavigationEnd, NavigationStart } from '@angular/router';
import { filter } from 'rxjs/operators';

@Injectable({
  providedIn: 'root'
})
export class HistoryRouterService {

  private history: any[] = [];

  constructor(
    private router: Router
  ) { }

  public loadRouting(): void {
    this.router.events
      .pipe(filter(event => event instanceof NavigationStart))
      .subscribe(({url}: NavigationStart) => {
        this.history = [...this.history, url];
      });
  }

  public getPreviousUrl(): string {
    return this.history[this.history.length - 2] || '';
  }

  public getAllUrls(): any[] {
    return this.history;
  }

  public pushLogout(): void {
    this.history = [...this.history, 'logout'];
  }

  public hasLogout(): boolean {
    return this.history.includes('logout');
  }
}
