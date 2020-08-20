import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { EditDirectionComponent } from './edit-direction.component';
import { Routes, Router, RouterModule } from '@angular/router';
import { MatIcon, MatFormField, MatIconModule, MatFormFieldModule, MatInputModule, MatDialogModule, MatButtonModule, MatAutocompleteModule, MatFormFieldControl } from '@angular/material';
import { FormGroup, ReactiveFormsModule, FormsModule } from '@angular/forms';
import { AdminGuard } from 'app/guards/admin.guard';

const routes: Routes = [
  {
    path: 'nuevo',
    component: EditDirectionComponent,
    canActivate: [AdminGuard]
  },
  {
    path: 'editar/:id',
    component: EditDirectionComponent,
    canActivate: [AdminGuard]
  }
];

@NgModule({
  declarations: [EditDirectionComponent],
  imports: [
    CommonModule,
    RouterModule.forChild(routes),
    MatIconModule,
    MatFormFieldModule,
    MatInputModule,
    MatDialogModule,
    MatButtonModule,
    MatAutocompleteModule,
    ReactiveFormsModule,
    FormsModule
  ],
  providers: [
    AdminGuard
  ]
})
export class EditDirectionModule { }
