import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule, Routes } from '@angular/router';
import { MatIconModule, MatFormFieldModule, MatInputModule, MatDialogModule, MatButtonModule } from '@angular/material';
import { ReactiveFormsModule, FormsModule } from '@angular/forms';
import { EditAreaComponent } from './edit-area.component';
import { AdminGuard } from 'app/guards/admin.guard';

const routes: Routes = [
  {
    path: ':id/areas/agregar',
    component: EditAreaComponent,
    canActivate: [ AdminGuard ]
  },
  {
    path: ':id/areas/editar/:idArea',
    component: EditAreaComponent,
    canActivate: [ AdminGuard ]
  }
];

@NgModule({
  declarations: [EditAreaComponent],
  imports: [
    CommonModule,
    RouterModule.forChild(routes),
    MatIconModule,
    MatFormFieldModule,
    MatInputModule,
    MatDialogModule,
    MatButtonModule,
    ReactiveFormsModule,
    FormsModule
  ],
  providers: [
    AdminGuard
  ]
})
export class EditAreaModule { }
