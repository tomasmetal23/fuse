import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { IndexExpedientModule } from './index-expedient/index-expedient.module';
import { ListExpedientModule } from './list-expedient/list-expedient.module';

@NgModule({
  imports: [
    CommonModule,    
    IndexExpedientModule,
    ListExpedientModule
  ],
  declarations: []
})
export class ExpedientModule { }
