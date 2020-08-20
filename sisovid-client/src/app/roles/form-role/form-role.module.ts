import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormRoleComponent } from './form-role.component';
import { MatIconModule, MatFormFieldModule, MatInputModule, MatDialogModule, MatButtonModule, MatSelectModule, MatOptionModule } from '@angular/material';
import { ReactiveFormsModule, FormsModule } from '@angular/forms';
import { Routes, RouterModule } from '@angular/router';
import { AdminGuard } from 'app/guards/admin.guard';

const routes: Routes = [
  {
    path: 'edit/:id',
    component: FormRoleComponent,
    canActivate: [AdminGuard]
  }
];

@NgModule({
  declarations: [FormRoleComponent],
  imports: [
    CommonModule,
    RouterModule.forChild(routes),
    MatIconModule,
    MatFormFieldModule,
    MatInputModule,
    MatDialogModule,
    MatButtonModule,
    ReactiveFormsModule,
    FormsModule,
    MatSelectModule,
    MatOptionModule
  ]
})
export class FormRoleModule { }
