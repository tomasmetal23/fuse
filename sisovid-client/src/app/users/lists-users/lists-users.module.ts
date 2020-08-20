import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ListsUsersComponent } from './lists-users.component';
import { Routes, RouterModule } from '@angular/router';
import { MatTableModule, MatButtonModule, MatIconModule, MatPaginatorModule } from '@angular/material';
import { CdkTableModule } from '@angular/cdk/table';
import { AdminGuard } from 'app/guards/admin.guard';

const routes: Routes = [
  {
    path: '',
    component: ListsUsersComponent,
    canActivate: [AdminGuard]
  }
];


@NgModule({
  declarations: [ListsUsersComponent],
  imports: [
    CommonModule,
    RouterModule.forChild(routes),
    MatTableModule,
    MatButtonModule,
    CdkTableModule,
    MatIconModule,
    MatPaginatorModule
  ],
  providers: [
    AdminGuard
  ]
})
export class ListsUsersModule { }
