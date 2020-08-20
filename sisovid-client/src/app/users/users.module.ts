import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { ListsUsersModule } from './lists-users/lists-users.module';
import { EditUserModule } from './edit-user/edit-user.module';


@NgModule({
  declarations: [],
  imports: [
    CommonModule,
    EditUserModule,
    ListsUsersModule
  ]
})
export class UsersModule { } 
