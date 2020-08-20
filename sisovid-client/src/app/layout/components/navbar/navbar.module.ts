import { NgModule } from '@angular/core';
import { MatButtonModule, MatIconModule } from '@angular/material';
import { RouterModule } from '@angular/router';

import { FuseNavigationModule } from '@fuse/components';
import { FuseSharedModule } from '@fuse/shared.module';

import { NavbarComponent } from 'app/layout/components/navbar/navbar.component';

@NgModule({
    declarations: [
        NavbarComponent
    ],
    imports     : [
        MatButtonModule,
        MatIconModule,

        FuseSharedModule,
        FuseNavigationModule,

        RouterModule
    ],
    exports     : [
        NavbarComponent
    ]
})
export class NavbarModule
{
}
