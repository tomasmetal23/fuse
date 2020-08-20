import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators, FormControl, FormGroupDirective, NgForm } from '@angular/forms';
import { ErrorStateMatcher } from '@angular/material/core';
import * as jwtDecode from 'jwt-decode';
import { FuseConfigService } from '@fuse/services/config.service';
import { fuseAnimations } from '@fuse/animations';

import { LoginService } from './login.service';
import { Router } from '@angular/router';
import { MatSnackBar } from '@angular/material';

import { FuseNavigationService } from '@fuse/components/navigation/navigation.service';
import { getNavigation } from 'app/navigation/navigation';
import { FuseNavigation } from '@fuse/types';
import { HistoryRouterService } from '../services/history-router.service';
import { AuthService } from 'app/services/auth.service';

export class ThisErrorStateMatcher implements ErrorStateMatcher {
  isErrorState(control: FormControl | null, form: FormGroupDirective | NgForm | null): boolean {
    const invalidCtrl = !!(control && control.invalid && control.parent.dirty);
    const invalidParent = !!(control && control.parent && control.parent.invalid && control.parent.dirty);
    return (invalidCtrl || invalidParent);
  }
}

@Component({
  selector: 'login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss'],
  animations: fuseAnimations,
  providers: [LoginService]
})
export class LoginComponent implements OnInit {
  loginForm: FormGroup;
  loginFormErrors: any;
  loading: any;
  error: any;
  year: Number = (new Date()).getFullYear();
  updateInitialData = false;
  user = {
    name: '',
    lastname: ''
  };
  form: FormGroup;
  previewImg = null;
  loadedImg = false;
  matcher = new ThisErrorStateMatcher();
  prevUrl: String = '';
  showErrorPhoto: Boolean = false;
  showPass = false;

  constructor(
    private fuseConfig: FuseConfigService,
    private formBuilder: FormBuilder,
    private loginService: LoginService,
    private router: Router,
    public snackBar: MatSnackBar,
    private _fuseNavigationService: FuseNavigationService,
    private historyRouter: HistoryRouterService,
    private authService: AuthService
  ) {
    this.fuseConfig.setConfig({
      layout: {
        navbar: 'none',
        toolbar: 'none',
        footer: 'none'
      }
    });

    this.loginFormErrors = {
      user: {},
      password: {}
    };
  }

  ngOnInit(): void {
    this.cleanRole();
    this.loginForm = this.formBuilder.group({
      user: ['', Validators.required],
      password: ['', Validators.required]
    });

    this.form = this.formBuilder.group({
      file: ['', Validators.required],
      password: ['', [Validators.required, Validators.minLength(8)]],
      confirmPassword: []
    }, { validator: this.checkPasswords });

    this.loginForm.valueChanges.subscribe(() => {
      this.onLoginFormValuesChanged();
    });

    this.prevUrl = (this.historyRouter.getPreviousUrl() === '' || this.historyRouter.hasLogout()) ? '/expedientes' : this.historyRouter.getPreviousUrl();
  }

  cleanRole(): void{
    const token = this.authService.jwt;
    if ( token !== null && token !== undefined ){
      if (!token.rol) {
        localStorage.clear();
      } else {
        this.router.navigate(['expedientes']);
      }
    }
  }

  onLoginFormValuesChanged(): void {
    for (const field in this.loginFormErrors) {
      if (!this.loginFormErrors.hasOwnProperty(field)) {
        continue;
      }

      // Clear previous errors
      this.loginFormErrors[field] = {};

      // Get the control
      const control = this.loginForm.get(field);

      if (control && control.dirty && !control.valid) {
        this.loginFormErrors[field] = control.errors;
      }
    }
  }

  login(): void {
    this.loading = true;
    const user = this.loginForm.value.user;
    const password = this.loginForm.value.password;
    const token = this.loginService.auth(user, password).subscribe(result => {
      if (result === true) {
        this.reloadMenu();
        // this._fuseNavigationService.register('main', navigation);
        this.router.navigate([this.prevUrl]);
        this.loginFormErrors.authFail = false;
      } else {
        this.snackBar.open('Login incorrecto', 'OK');
        this.error = 'Username or password is incorrect';
        this.loading = false;
        this.loginFormErrors.authFail = true;
      }
    }, error => {
      this.loading = false;
      if (error === 'request-init') {
        this.updateInitialData = true;
      }
      else {
        this.snackBar.open('Login incorrecto', 'OK', {
          duration: 3000,
          verticalPosition: 'top',
          horizontalPosition: 'right'
        });
        this.error = 'Username or password is incorrect';
        this.loginFormErrors.authFail = true;

      }
    });
  }

  isAdmin(): Boolean {
    return localStorage.getItem('rol') === 'admin' ? true : false;
  }

  get userName(): String {
    const userData = jwtDecode(this.loginService.token);
    return userData.name;
  }

  onFileChange(event): void {

    const reader = new FileReader();
    this.previewImg = null;

    if (event.target.files && event.target.files.length > 0) {
      const file = event.target.files[0];
      reader.readAsDataURL(file);
      reader.onload = (e: any) => {
        this.form.get('file').setValue({
          filename: file.name,
          filetype: file.type,
          value: Object(reader.result).split(',')[1]
        });
        this.previewImg = e.target.result;
        this.loadedImg = true;
        this.showErrorPhoto = false;
      };
    } else {
      this.loadedImg = false;
      this.previewImg = null;
      this.form.get('file').setValue('');
      this.showErrorPhoto = true;
    }

  }

  get avatar(): String {
    return this.previewImg === null ? 'none' : 'url("' + this.previewImg + '")';
  }

  checkPasswords(group: FormGroup): any { // here we have the 'passwords' group
    const pass = group.controls.password.value;
    const confirmPass = group.controls.confirmPassword.value;
    return pass === confirmPass ? null : { notSame: true };
  }

  update(): void {
    console.log(this.form.invalid);
    if (this.form.invalid) {
      this.showErrorPhoto = this.form.value.file === '' ? true : false;
      return;
    }

    this.loading = true;

    this.loginService._new(this.form.value).subscribe(data => {
      this.loginService.storeLocal(data.token);
      this.reloadMenu();
      this.router.navigate([this.prevUrl]);
    });

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
}
