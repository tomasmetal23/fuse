import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ListsRolesModule } from './lists-roles/lists-roles.module';
import { FormRoleModule } from './form-role/form-role.module';

@NgModule({
  declarations: [],
  imports: [
    CommonModule,
    ListsRolesModule,
    FormRoleModule
  ]
})
export class RolesModule { }
