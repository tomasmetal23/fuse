import { Component, OnInit, Inject, EventEmitter } from '@angular/core';
import { UserService } from 'app/users/user.service';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { Observable } from 'rxjs';
import { startWith, map } from 'rxjs/operators';
import { DirectionService } from '../direction.service';
import { MAT_DIALOG_DATA, MatDialogRef } from '@angular/material';
import { Direction } from '../direction.model';

export interface User{
  id?: number;
  name: string;
  last_name?: string;
  m_last_name?: string;
}

export enum Action{
  INSERT,
  UPDATE 
}

@Component({
  selector: 'app-edit-direction',
  templateUrl: './edit-direction.component.html',
  styleUrls: ['./edit-direction.component.scss']
})

export class EditDirectionComponent implements OnInit {

  public form: FormGroup;
  public nameFormControl: FormControl;
  public userFormControl: FormControl ;
  public filteredOptionsUserFormControl: Observable<any>;
  public options: User[];
  public saving = false;
  public direction: Direction = {
    name: '',
    responsible_user_id: null
  };
  public user: User = {
    name: '',
  };
  public action: Action = Action.INSERT;
  public title = 'Nueva dirección';
  public onAdd = new EventEmitter();
  
  constructor(
    private userServices: UserService, 
    private directionService: DirectionService,
    public dialogRef: MatDialogRef<EditDirectionComponent>,
    @Inject(MAT_DIALOG_DATA) private data: any,
    ) { 
        if (data !== undefined && data !== null){
          this.direction = data;
          this.action = Action.UPDATE;
          this.title = 'Editar dirección';
        }
    }

  ngOnInit(): void {
    this._initialize();
    const users = this.userServices.getUsers();
    users.subscribe( (data: any) => {
      const listUsers = data.map(user => {
        if (this.action === Action.UPDATE){
            if (this.direction.responsible_user_id === user.id){
              this.user = user;
              this.userFormControl.setValue(user);
            }
        }
        return  {
          id: user.id,
          name: user.name,
          last_name: user.last_name,
          m_last_name: user.m_last_name
        };
      });

      this.options = listUsers;
      this._userFormControllerInitFilterOptions();
    } );
  }

  /**
   * inicialiteze all instances 
   */
  private _initialize(): void {
    this.userFormControl = new FormControl('');
    this.nameFormControl = new FormControl(this.direction.name, [Validators.required, Validators.maxLength(50)]);
    this.form = new FormGroup({
      name: this.nameFormControl,
      user: this.userFormControl
    });
  }

  /**
   *++++++++++  functions for autocomplete component ++++++++++++++
   */

  private _userFormControllerInitFilterOptions(): void {
    this.filteredOptionsUserFormControl = this.userFormControl.valueChanges
      .pipe(
        startWith<string | User>(''),
        map(value => typeof value === 'string' ? value : value.name),
        map(name => name ? this._filter(name) : this.options.slice())
      );
  }
  userFormControlDisplayFn(user?: any): string | undefined {
    return user ? user.name : undefined;
  }

  private _filter(name: string): User[] {
    const filterValue = name.toLowerCase();

    return this.options.filter(option => option.name.toLowerCase().indexOf(filterValue) === 0);
  }
  /**++++ END Functions Autocomplete ++++++*/


  /**
   * insert or update a directions
   */
  public save(): void {
    if (this.form.valid) {
      if (this.action === Action.INSERT){
        this._insert();
      } else {
        this._update();
      }
    }
  }

  /**
   * insert a direction
   */
  private _insert(): void {
    const params: Direction = {
      name: this.form.controls['name'].value,
      responsible_user_id: this.form.controls['user'].value.id
    };
    
    this.directionService.store(params).subscribe((data: any) => {
      this.dialogRef.close({'action' : 'insert', 'status' : true});
    }, error => {
      this.saving = false;
      this.dialogRef.close({'action' : 'insert', 'status' : false, 'message' : error.error.message });
    });
  }

  private _update(): void {
    let userId: string = null;
    if ( this.form.controls['user'].value !== null ){
      userId = this.form.controls['user'].value.id;
    }
    const params: Direction = {
      name: this.form.controls['name'].value,
      responsible_user_id: userId,
    };
    this.directionService.update(this.direction.id, params).subscribe((data: any) => {
      this.saving = true;
      this.dialogRef.close({'action' : 'updated', 'status' : true});
    }, error => {
      this.dialogRef.close({'action' : 'updated', 'status' : false, 'message' : error.error.message });
    });
  }
}
