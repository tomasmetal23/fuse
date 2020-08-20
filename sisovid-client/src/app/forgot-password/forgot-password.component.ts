import { Component, OnDestroy, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { Subject } from 'rxjs';
import { takeUntil } from 'rxjs/operators';
import { LoginService } from '../login/login.service';

import { MatSnackBar } from '@angular/material';

import { FuseConfigService } from '@fuse/services/config.service';
import { fuseAnimations } from '@fuse/animations';

@Component({
    selector: 'app-forgot',
    templateUrl: './forgot-password.component.html',
    styleUrls: ['./forgot-password.component.scss'],
    animations : fuseAnimations,
    providers: [ LoginService ]
})
export class ForgotPasswordComponent implements OnInit {
  forgotPasswordForm: FormGroup;
  forgotPasswordFormErrors: any;
  loading: boolean;
  year: Number = (new Date()).getFullYear();

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
        public snackBar: MatSnackBar
    )
    {
        this.loading = false;
        // Configure the layout
        this._fuseConfigService.config = {
            layout: {
                    navbar : {
                    hidden: true
                },
                    toolbar: {
                    hidden: true
                },
                    footer : {
                    hidden: true
                }
            }
        };

        // Set the defaults
        this.forgotPasswordFormErrors = {
            email: {}
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
        this.forgotPasswordForm = this._formBuilder.group({
            email: ['', [Validators.required, Validators.email]]
        });

        this.forgotPasswordForm.valueChanges
            .pipe(takeUntil(this._unsubscribeAll))
            .subscribe(() => {
                this.onForgotPasswordFormValuesChanged();
            });
   }

   recovery(): void {
       this.loading = true;
       const email = encodeURI(this.forgotPasswordForm.value.email);
        this._loginService.recovery(email).subscribe(result => {
            if(result.status == 200){
                this.snackBar.open('Se han enviado instrucciones a tu correo', 'Cerrar');
            }
            this.loading = false;
        }, error => {
            console.log(error);
            this.loading = false;
            this.snackBar.open('Verifica que tu correo sea correcto', 'Cerrar');
        });
    }

  /**
   * On destroy
   */
  ngOnDestroy(): void
  {
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
  onForgotPasswordFormValuesChanged(): void
  {
      for ( const field in this.forgotPasswordFormErrors )
      {
          if ( !this.forgotPasswordFormErrors.hasOwnProperty(field) )
          {
              continue;
          }

          // Clear previous errors
          this.forgotPasswordFormErrors[field] = {};

          // Get the control
          const control = this.forgotPasswordForm.get(field);

          if ( control && control.dirty && !control.valid )
          {
              this.forgotPasswordFormErrors[field] = control.errors;
          }
      }
  }
}
