import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ListDirectionsComponent } from './list-directions/list-directions.component';
import { Routes, RouterModule } from '@angular/router';
import { MatTableModule, MatColumnDef, MatIconModule, MatListIconCssMatStyler, MatButtonModule, MatPaginatorModule } from '@angular/material';
import { CdkTableModule } from '@angular/cdk/table';
import { EditDirectionModule } from './edit-direction/edit-direction.module';
import { ListAreaModule } from './list-area/list-area.module';
import { EditAreaModule } from './edit-area/edit-area.module';
import { AdminGuard } from 'app/guards/admin.guard';

const routes: Routes = [
  {
    path: '',
    component: ListDirectionsComponent,
    canActivate: [AdminGuard]
  }
];

@NgModule({
  declarations: [ListDirectionsComponent],
  imports: [
    CommonModule,
    RouterModule.forChild(routes),
    MatTableModule,
    CdkTableModule,
    MatIconModule,
    EditDirectionModule,
    MatButtonModule,
    ListAreaModule,
    EditAreaModule,
    MatPaginatorModule,
    EditAreaModule
  ],
  providers: [
    AdminGuard
  ]
})
export class DirectionsModule { }
