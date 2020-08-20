import { NgModule } from '@angular/core';
import { RouterModule } from '@angular/router';
import { 
    MatButtonModule, 
    MatCheckboxModule,
    MatFormFieldModule, 
    MatInputModule,
    MatSnackBarModule,
    MatProgressSpinnerModule,
    MatIconModule
} from '@angular/material';

import { FuseSharedModule } from '@fuse/shared.module';

import { LoginComponent } from 'app/login/login.component';
import { ForgotPasswordComponent } from '../forgot-password/forgot-password.component';
import { ResetPasswordComponent } from '../reset-password/reset-password.component';

const routes = [
    {
        path     : 'login',
        component: LoginComponent
    },
    {
        path     : 'recuperar',
        component: ForgotPasswordComponent
    },
    {
        path     : 'reiniciar-password/:id',
        component: ResetPasswordComponent
    }
];

@NgModule({
    declarations: [
        LoginComponent,
        ForgotPasswordComponent,
        ResetPasswordComponent
    ],
    imports     : [
        RouterModule.forChild(routes),

        MatButtonModule,
        MatCheckboxModule,
        MatFormFieldModule,
        MatInputModule,
        MatSnackBarModule,
        MatProgressSpinnerModule,
        MatIconModule,
        FuseSharedModule
    ]
})
export class LoginModule
{
}
