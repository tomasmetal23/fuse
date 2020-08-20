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
  MatListModule,
  MatTabsModule,
  MatButtonToggleModule,
  MatRadioModule
} from '@angular/material';
import { IndexExpedientComponent } from './index-expedient.component';
import { NgxMaskModule } from 'ngx-mask';
import { NgxCurrencyModule } from 'ngx-currency';
import { TextMaskModule } from 'angular2-text-mask';
import { CanDeactivateGuard } from './can-deactivate.guard';

const routes: Routes = [
  {
    path: 'expedientes/alta',
    component: IndexExpedientComponent,
    canDeactivate: [CanDeactivateGuard]
  },
  {
    path: 'expedientes/editar/:fileId',
    component: IndexExpedientComponent,
    canDeactivate: [CanDeactivateGuard]
  }
];


export const customCurrencyMaskConfig = {
  align: 'right',
  allowNegative: true,
  allowZero: true,
  decimal: '.',
  precision: 2,
  prefix: '',
  suffix: '',
  thousands: ',',
  nullable: false
};

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
    MatListModule,
    NgxMaskModule.forRoot(),
    NgxCurrencyModule.forRoot(customCurrencyMaskConfig),
    MatTabsModule,
    MatButtonToggleModule,
    MatRadioModule,
    TextMaskModule
  ],
  declarations: [
    IndexExpedientComponent
  ],
  entryComponents: [
  ]
})
export class IndexExpedientModule { }
