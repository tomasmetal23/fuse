import { Component, OnDestroy, OnInit } from '@angular/core';
import { AbstractControl, FormBuilder, FormGroup, Validators } from '@angular/forms';
import { Subject } from 'rxjs';
import { takeUntil } from 'rxjs/operators';
import { ActivatedRoute, Router } from "@angular/router";
import * as jwtDecode from 'jwt-decode';
import { LoginService } from '../login/login.service';

import { FuseConfigService } from '@fuse/services/config.service';
import { fuseAnimations } from '@fuse/animations';

import { FuseNavigationService } from '@fuse/components/navigation/navigation.service';
import { navigation, getNavigation } from 'app/navigation/navigation';
import { FuseNavigation } from '@fuse/types';
import { Rol } from 'app/constants/rol';

@Component({
  selector: 'reset-password',
  templateUrl: './reset-password.component.html',
  styleUrls: ['./reset-password.component.scss'],
  animations: fuseAnimations,
  providers: [LoginService]
})
export class ResetPasswordComponent implements OnInit, OnDestroy {
  resetPasswordForm: FormGroup;
  resetPasswordFormErrors: any;
  loading: boolean;
  validToken: boolean;
  token: string;
  expired: Boolean = false;

  // Private
  private _unsubscribeAll: Subject<any>;

  /**
   * Constructor
   *
   * @param {FuseConfigService} _fuseConfigService
   * @param {FormBuilder} _formBuilder
   */
  constructor(
    private _fuseConfigService: FuseConfigService,
    private _formBuilder: FormBuilder,
    private _loginService: LoginService,
    private _route: ActivatedRoute,
    private _router: Router,
    private _fuseNavigationService: FuseNavigationService,
  ) {
    this.loading = false;
    this.validToken = false;

    // Configure the layout
    this._fuseConfigService.config = {
      layout: {
        navbar: {
          hidden: true
        },
        toolbar: {
          hidden: true
        },
        footer: {
          hidden: true
        }
      }
    };

    // Set the defaults
    this.resetPasswordFormErrors = {
      password: {},
      passwordConfirm: {}
    };

    // Set the private defaults
    this._unsubscribeAll = new Subject();
  }

  // -----------------------------------------------------------------------------------------------------
  // @ Lifecycle hooks
  // -----------------------------------------------------------------------------------------------------

  /**
   * On init
   */
  ngOnInit(): void {
    this.resetPasswordForm = this._formBuilder.group({
      password: ['', [Validators.required, Validators.minLength(8)]],
      passwordConfirm: ['', [Validators.required, confirmPassword, Validators.minLength(8)]]
    });

    this.resetPasswordForm.valueChanges
      .pipe(takeUntil(this._unsubscribeAll))
      .subscribe(() => {
        this.onResetPasswordFormValuesChanged();
      });

    this.token = this._route.snapshot.paramMap.get('id');
    this.validateToken();
  }

  validateToken(): void {
    this.loading = true;
    this._loginService.validateToken(this.token).subscribe(result => {
      if (result.status === 200) {
        this.validToken = true;
      }
      this.loading = false;
    }, error => {
      if (error.status === 404) {
        this._router.navigate(['/login']);
        this.loading = false;
      } else if (error.status === 410) {
        this.expired = true;
        this.loading = false;
      }
    });
  }

  reset(): void {
    this.loading = true;
    const password = this.resetPasswordForm.value.password;

    this._loginService.reset(password, this.token).subscribe((result: any) => {
      this._loginService.storeLocal(result.body.token);
      if (localStorage.getItem('token')) {
        this.reloadMenu();
      }
      this._router.navigate(['/expedientes']);
    }, error => {
      if (error.status === 400) {

      }
      this.loading = false;
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

  // -----------------------------------------------------------------------------------------------------
  // @ Public methods
  // -----------------------------------------------------------------------------------------------------

  /**
   * On form values changed
   */
  onResetPasswordFormValuesChanged(): void {
    for (const field in this.resetPasswordFormErrors) {
      if (!this.resetPasswordFormErrors.hasOwnProperty(field)) {
        continue;
      }

      // Clear previous errors
      this.resetPasswordFormErrors[field] = {};

      // Get the control
      const control = this.resetPasswordForm.get(field);

      if (control && control.dirty && !control.valid) {
        this.resetPasswordFormErrors[field] = control.errors;
      }
    }
  }

  private reloadMenu(): void {
    const moduleToken = !!jwtDecode(localStorage.getItem('token')) ? jwtDecode(localStorage.getItem('token')) : '';
    if (moduleToken.id !== 0) {
      const menu: FuseNavigation[] = getNavigation();
      this._fuseNavigationService.unregister('main');
      this._fuseNavigationService.register('main', menu);
      this._fuseNavigationService.setCurrentNavigation('main');
    }
  }
}

/**
 * Confirm password
 *
 * @param {AbstractControl} control
 * @returns {{passwordsNotMatch: boolean}}
 */
function confirmPassword(control: AbstractControl): any {
  if (!control.parent || !control) {
    return;
  }

  const password = control.parent.get('password');
  const passwordConfirm = control.parent.get('passwordConfirm');

  if (!password || !passwordConfirm) {
    return;
  }

  if (passwordConfirm.value === '') {
    return;
  }

  if (password.value !== passwordConfirm.value) {
    return {
      passwordsNotMatch: true
    };
  }
}
