import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { AutoCompleteGroupComponent } from './auto-complete-group.component';
import { MatFormFieldModule, MatSelectModule, MatInputModule, MatAutocompleteModule } from '@angular/material';
import { FuseSharedModule } from '@fuse/shared.module';

@NgModule({
  declarations: [AutoCompleteGroupComponent],
  imports: [
    CommonModule,
    MatFormFieldModule,
    MatSelectModule,
    MatInputModule,
    FuseSharedModule,
    MatAutocompleteModule
  ],
  exports: [
    AutoCompleteGroupComponent
  ]
})
export class AutoCompleteGroupModule { }
