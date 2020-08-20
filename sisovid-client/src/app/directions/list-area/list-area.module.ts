import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { Routes, RouterModule } from '@angular/router';
import { MatTableModule, MatIconModule, MatButtonModule, MatPaginatorModule } from '@angular/material';
import { CdkTableModule } from '@angular/cdk/table';
import { ListAreaComponent } from './list-area.component';
import { AdminGuard } from 'app/guards/admin.guard';

const routes: Routes = [
  {
    path: ':id/areas',
    component: ListAreaComponent,
    canActivate: [ AdminGuard ]
  }
];

@NgModule({
  declarations: [ListAreaComponent],
  imports: [
    CommonModule,
    RouterModule.forChild(routes),
    MatTableModule,
    CdkTableModule,
    MatIconModule,
    MatPaginatorModule,
    MatButtonModule
  ],
  providers: [
    AdminGuard
  ]
})
export class ListAreaModule { }
