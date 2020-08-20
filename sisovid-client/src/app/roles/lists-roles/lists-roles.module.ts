import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ListsRolesComponent } from './lists-roles.component';
import { Routes, RouterModule } from '@angular/router';
import { MatTableModule, MatButtonModule, MatIconModule } from '@angular/material';
import { CdkTableModule } from '@angular/cdk/table';
import { AdminGuard } from 'app/guards/admin.guard';

const routes: Routes = [
  {
    path: '',
    component: ListsRolesComponent,
    canActivate: [AdminGuard]
  }
];

@NgModule({
  declarations: [ListsRolesComponent],
  imports: [
    CommonModule,
    RouterModule.forChild(routes),
    MatTableModule,
    MatButtonModule,
    CdkTableModule,
    MatIconModule
  ],
  providers: [
    AdminGuard
  ]
})
export class ListsRolesModule { }
