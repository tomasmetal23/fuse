import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule, Routes } from '@angular/router';
import { MatIconModule, MatFormFieldModule, MatInputModule, MatDialogModule, MatButtonModule, MatAutocompleteModule } from '@angular/material';
import { ReactiveFormsModule, FormsModule } from '@angular/forms';
import { EditUserComponent } from './edit-user.component';
import { AdminGuard } from 'app/guards/admin.guard';

const routes: Routes = [{
  path: 'agregar',
  component: EditUserComponent,
  canActivate: [AdminGuard]
}];

@NgModule({
  declarations: [EditUserComponent],
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
export class EditUserModule { }
