import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule, Routes } from '@angular/router';
import { FuseSharedModule } from '@fuse/shared.module';
import { CdkTableModule } from '@angular/cdk/table';
import {
  MatIconModule,
  MatCheckboxModule,
  MatFormFieldModule,
  MatInputModule,
  MatButtonModule,
  MatPaginatorModule,
  MatRippleModule,
  MatSelectModule,
  MatSortModule,
  MatTableModule,
  MatProgressSpinnerModule,
  MatSnackBarModule,
  MatAutocompleteModule,
  MatChipsModule,
  MatTooltipModule,
  MatStepperModule,
  MatDatepickerModule,
  MatProgressBarModule,
  MatListModule
} from '@angular/material';
import { ListExpedientComponent } from './list-expedient.component';

const routes: Routes = [
  { path: '', redirectTo: 'expedientes', pathMatch: 'full'},
  {
    path: '',
    component: ListExpedientComponent,
  }
];

@NgModule({
  imports: [
    CommonModule,
    RouterModule.forChild(routes),
    MatIconModule,
    MatCheckboxModule,
    MatFormFieldModule,
    MatInputModule,
    MatButtonModule,
    MatPaginatorModule,
    MatRippleModule,
    MatSelectModule,
    MatSortModule,
    FuseSharedModule,
    CdkTableModule,
    MatTableModule,
    MatProgressSpinnerModule,
    MatSnackBarModule,
    MatAutocompleteModule,
    MatChipsModule,
    MatTooltipModule,
    MatStepperModule,
    MatDatepickerModule,
    MatProgressBarModule,
    MatListModule
  ],
  declarations: [
    ListExpedientComponent
  ],
  entryComponents: [
  ]
})
export class ListExpedientModule { }
