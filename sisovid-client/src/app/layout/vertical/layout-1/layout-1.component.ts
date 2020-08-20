import { Component, OnDestroy, OnInit, ViewEncapsulation, ViewChild } from '@angular/core';
import { Subject, Subscription } from 'rxjs';
import { takeUntil } from 'rxjs/operators';

import { FuseConfigService } from '@fuse/services/config.service';
import { navigation, getNavigation } from 'app/navigation/navigation';
import { MatSidenav, MatDialog } from '@angular/material';
import { CommunicationService } from 'app/services/communication.service';
import { LoginDialogComponent } from 'app/dialogs/login-dialog/login-dialog.component';
import { Router, NavigationEnd } from '@angular/router';
import { AuthService } from 'app/services/auth.service';
import { FuseNavigation } from '@fuse/types';
import { FuseNavigationService } from '@fuse/components/navigation/navigation.service';

@Component({
	selector: 'vertical-layout-1',
	templateUrl: './layout-1.component.html',
	styleUrls: ['./layout-1.component.scss'],
	encapsulation: ViewEncapsulation.None
})
export class VerticalLayout1Component implements OnInit, OnDestroy {
	@ViewChild('sidenavprofile', { static: false }) sidenavprofile: MatSidenav;
	fuseConfig: any;
	navigation: any;
	dataProfile: any = 'Hola';
	value = 0;
	activeWindowLogin = false;
	reloadValue = null;

	// Private
	private _unsubscribeAll: Subject<any>;

  /**
   * Constructor
   *
   * @param {FuseConfigService} _fuseConfigService
   */
	constructor(
		private _fuseConfigService: FuseConfigService,
		private dialog: MatDialog,
		private communicationService: CommunicationService,
		private router: Router,
		private authService: AuthService,
		private _fuseNavigationService: FuseNavigationService
	) {
		// Set the defaults
		this.navigation = navigation;

		// Set the private defaults
		this._unsubscribeAll = new Subject();

		//
		communicationService.changeEmitted$.subscribe((reloadPage) => {
			this.reloadValue = reloadPage;
			if (!this.activeWindowLogin) {
				this.activeWindowLogin = true;
				this.showDialogLogin();
			}
		});
	}

	// -----------------------------------------------------------------------------------------------------
	// @ Lifecycle hooks
	// -----------------------------------------------------------------------------------------------------

  /**
   * On init
   */
	ngOnInit(): void {
		// Subscribe to config changes
		this._fuseConfigService.config
			.pipe(takeUntil(this._unsubscribeAll))
			.subscribe((config) => {
				this.fuseConfig = config;
			});
	}

  /**
   * On destroy
   */
	ngOnDestroy(): void {
		// Unsubscribe from all subscriptions
		this._unsubscribeAll.next();
		this._unsubscribeAll.complete();
	}

	public showDialogLogin(): void {
		const skipUrls = ['/alta', '/editar'];
		const dialog = this.dialog.open(LoginDialogComponent, {
			panelClass: 'wrapper-login-dialog',
			data: {
				content: ''
			}
		});

		dialog.afterClosed()
			.subscribe(() => {
				this.activeWindowLogin = false;
				// console.log(this.router.url);
        /*const index = skipUrls.findIndex(el => this.router.url.includes(el));
        console.log(index);
        if (index < 0) {
          this.reload(this.router.url);
        }*/
				if (this.reloadValue) {
					this.reload(this.router.url);
				}
				this.reloadMenu();
			});
	}

	async reload(url: string): Promise<boolean> {
		await this.router.navigateByUrl('.', { skipLocationChange: true });
		return this.router.navigateByUrl(url);
	}

	reloadMenu(): void {
		let token: any = null;
		if (!!localStorage.getItem('token')) {
			token = this.authService.jwt;
		}
		if (token.id !== 0) {
			const menu: FuseNavigation[] = getNavigation();
			this._fuseNavigationService.unregister('main');
			this._fuseNavigationService.register('main', menu);
			this._fuseNavigationService.setCurrentNavigation('main');
		}
	}

	close(reason: string): void {
		this.sidenavprofile.disableClose = true;
		setTimeout(() => this.sidenavprofile.disableClose = false);
	}
}
