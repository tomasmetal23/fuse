import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { HttpClientModule } from '@angular/common/http';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { MatMomentDateModule } from '@angular/material-moment-adapter';
import { MatButtonModule, MatIconModule, MatStepperModule, MatProgressSpinnerModule, MatFormFieldModule, MatInputModule } from '@angular/material';
import { TranslateModule } from '@ngx-translate/core';

import { FuseModule } from '@fuse/fuse.module';
import { FuseSharedModule } from '@fuse/shared.module';
import { LoginModule } from './login/login.module';

import { fuseConfig } from 'app/fuse-config';

import { AppComponent } from 'app/app.component';
import { LayoutModule } from 'app/layout/layout.module';

import { AuthGuardService as AuthGuard } from '../app/auth/auth-guard.service';
import { HTTP_INTERCEPTORS } from '@angular/common/http';
import { TokenInterceptor } from './auth/token.interceptor';
import { JwtHelperService } from '@auth0/angular-jwt';
import { AuthService } from './services/auth.service';
import { routing } from './app.routing.module';
import { Globals } from './globals';
import { ConfirmComponent } from './dialogs/confirm/confirm.component';
import { ExpedientModule } from './expedient/expedient.module';
import 'hammerjs';
import { CanDeactivateGuard } from './expedient/index-expedient/can-deactivate.guard';
import { LoginDialogComponent } from './dialogs/login-dialog/login-dialog.component';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';


@NgModule({
  declarations: [
    AppComponent,
    ConfirmComponent,
    LoginDialogComponent
  ],
  imports: [
    BrowserModule,
    BrowserAnimationsModule,
    HttpClientModule,
    routing,
    MatStepperModule,
    MatProgressSpinnerModule,
    TranslateModule.forRoot(),

    // Material moment date module
    MatMomentDateModule,

    // Material
    MatButtonModule,
    MatIconModule,

    // Fuse modules
    FuseModule.forRoot(fuseConfig),
    FuseSharedModule,

    // App modules
    LayoutModule,
    LoginModule,
    ExpedientModule,
    MatFormFieldModule,
    FormsModule,
    ReactiveFormsModule,
    MatInputModule

  ],
  providers: [
    AuthGuard,
    CanDeactivateGuard,
    JwtHelperService,
    Globals,
    AuthService,
    {
      provide: HTTP_INTERCEPTORS,
      useClass: TokenInterceptor,
      multi: true
    }
  ],
  bootstrap: [
    AppComponent
  ],
  entryComponents: [
    ConfirmComponent,
    LoginDialogComponent
  ]
})
export class AppModule {
}
