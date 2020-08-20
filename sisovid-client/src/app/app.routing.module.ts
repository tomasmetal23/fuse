import { Routes, RouterModule } from '@angular/router';

const appRoutes: Routes = [
    { path: '', redirectTo: 'expedientes', pathMatch: 'full' },
    { path: 'expedientes', loadChildren: './expedient/expedient.module#ExpedientModule' },
    { path: 'roles', loadChildren: './roles/roles.module#RolesModule' },
    { path: 'usuarios', loadChildren: './users/users.module#UsersModule' },
    { path: 'direcciones', loadChildren: './directions/directions.module#DirectionsModule' },
    { path: '**', redirectTo: '' }
];

export const routing = RouterModule.forRoot(appRoutes, {onSameUrlNavigation: 'reload'});
