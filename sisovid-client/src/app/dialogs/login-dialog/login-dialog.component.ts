import { Component, OnInit, Inject } from '@angular/core';
import { MatDialogRef, MAT_DIALOG_DATA, MatSnackBar } from '@angular/material';
import { FormGroup, FormBuilder, Validators } from '@angular/forms';
import { ThisErrorStateMatcher } from 'app/login/login.component';
import { LoginService } from 'app/login/login.service';

@Component({
  selector: 'app-login-dialog',
  templateUrl: './login-dialog.component.html',
  styleUrls: ['./login-dialog.component.scss']
})
export class LoginDialogComponent implements OnInit {
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
  matcher = new ThisErrorStateMatcher();
  showPass = false;

  constructor(
    public dialogRef: MatDialogRef<LoginDialogComponent>,
    private formBuilder: FormBuilder,
    private loginService: LoginService,
    public snackBar: MatSnackBar,
    @Inject(MAT_DIALOG_DATA) public data: { title: string, content: string }
  ) {
    this.loginFormErrors = {
      user: {},
      password: {}
    };
    dialogRef.disableClose = true;
  }

  ngOnInit(): void {
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
  }

  onLoginFormValuesChanged(): void {
    for (const field in this.loginFormErrors) {
      if (!this.loginFormErrors.hasOwnProperty(field)) {
        continue;
      }
      this.loginFormErrors[field] = {};
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
    this.loginService.auth(user, password).subscribe(result => {
      this.loading = false;
      if (result === true) {
        this.loginFormErrors.authFail = false;
        this.close();
      } else {
        this.snackBar.open('Login incorrecto', 'OK');
        this.error = 'Username or password is incorrect';
        this.loginFormErrors.authFail = true;
      }
    }, error => {
      this.loading = false;
      this.snackBar.open('Login incorrecto', 'OK', {
        duration: 3000,
        verticalPosition: 'bottom',
        horizontalPosition: 'center'
      });
      this.error = 'Username or password is incorrect';
      this.loginFormErrors.authFail = true;
    });
  }

  checkPasswords(group: FormGroup): any {
    const pass = group.controls.password.value;
    const confirmPass = group.controls.confirmPassword.value;
    return pass === confirmPass ? null : { notSame: true };
  }

  close(): void {
    this.dialogRef.close();
  }
}
