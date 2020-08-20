import { Component, OnInit, Inject, ViewChild, ElementRef } from '@angular/core';
import { MatDialogRef, MAT_DIALOG_DATA, MatAutocomplete } from '@angular/material';
import { FormGroup, FormControl, Validators, FormGroupDirective } from '@angular/forms';
import { Observable } from 'rxjs';
import { UserService } from '../user.service';
import { DirectionService } from 'app/directions/direction.service';
import { AreaService } from 'app/directions/area.service';
import { RoleService } from 'app/roles/role.service';
import { startWith, map as mapOperators } from 'rxjs/operators';
import { MustMatch } from '../must-match.validator';

export interface User {
  id?: number;
  username: string;
  name: string;
  last_name: string;
  m_last_name: string;
  email: string;
  password: string;
  direction_id: number;
  area_id: number;
  role_id: number;
  direction?: any;
  area?: any;
  userRol?: any;
}

export enum Action {
  INSERT,
  UPDATE
}

@Component({
  selector: 'app-edit-user',
  templateUrl: './edit-user.component.html',
  styleUrls: ['./edit-user.component.scss']
})
export class EditUserComponent implements OnInit {

  public form: FormGroup;
  public saving: boolean = false;
  public user: User = {
    username: '',
    name: '',
    last_name: '',
    m_last_name: '',
    email: '',
    password: null,
    direction_id: null,
    area_id: null,
    role_id: null,
    direction: null,
    area: null,
    userRol: null
  };
  public hide: Boolean = true;
  public re_hide: Boolean = true;
  public directions: any[];
  public areas: any[];
  public roles: any[];
  public filterDirections: Observable<any>;
  public filterAreas: Observable<any>;
  public filterRoles: Observable<any>;
  public action: Action = Action.INSERT;
  public title: String = 'Nuevo Usuario';
  public formControlDirection: FormControl = new FormControl('', Validators.required);
  public formControlArea: FormControl = new FormControl('', Validators.required);
  public formControlRole: FormControl = new FormControl('', Validators.required);
  @ViewChild('direction', { static: false}) public matAutocompleteDirection: MatAutocomplete;
  @ViewChild('area', { static: false}) public matAutocompleteArea: MatAutocomplete;
  @ViewChild('role', { static: false}) public matAutocompleteRle: MatAutocomplete;
  @ViewChild('directionInput', { static: false}) dirInput: ElementRef;

  constructor(
    private userService: UserService,
    private directionService: DirectionService,
    private areaService: AreaService,
    private roleService: RoleService,
    public dialogRef: MatDialogRef<EditUserComponent>,
    @Inject(MAT_DIALOG_DATA) private data: any
  ) { 
    if (data !== null) {
      this.user = data;
      this.action = Action.UPDATE;
      this.title = 'Editar Usuario';
    }
  }

  public ngOnInit(): void {
    this._initialize();
    this._initializeAutocompletes();
  }

  private _initialize(): void {
    this.form = new FormGroup({
      username: new FormControl(this.user.username, [Validators.required, Validators.maxLength(50), Validators.pattern(/^[a-z._]*[a-z._]$/)]),
      name:  new FormControl(this.user.name, [Validators.required, Validators.maxLength(100)]),
      last_name:  new FormControl(this.user.last_name, [Validators.required, Validators.maxLength(100)]),
      m_last_name:  new FormControl(this.user.m_last_name, [Validators.required, Validators.maxLength(100)]),
      email:  new FormControl(this.user.email, [Validators.required, Validators.email, Validators.maxLength(100)]),
      direction_id: new FormControl(this.user.direction_id, [Validators.required]),
      area_id: new FormControl(this.user.area_id, [Validators.required]),
      role_id: new FormControl(this.user.role_id, [Validators.required])
    });

    if (this.action === Action.INSERT) {
      this.form.addControl('password', new FormControl(this.user.password, [Validators.required, Validators.minLength(8), Validators.maxLength(16)]));
      this.form.addControl('confirm_password', new FormControl(null, [Validators.required]));
    } else {
      this.form.addControl('password', new FormControl(this.user.password, [Validators.minLength(4), Validators.maxLength(10)]));
      this.form.addControl('confirm_password', new FormControl(null));
    }
    this.form.setValidators(MustMatch('password', 'confirm_password'));
  }

  private async _initializeAutocompletes() {
    this.directions = await this.directionService.getList().toPromise();
    this.form.get('direction_id').patchValue(this.directions[0].id);
    await this._loadAreas();
    this.roles = await this.roleService.get().toPromise();

    this.filterDirections = this.formControlDirection.valueChanges
      .pipe(
        startWith<string>(''),
        mapOperators(val => this._filter(val, this.directions))
      );
    this.filterAreas = this.formControlArea.valueChanges
      .pipe(
        startWith<string>(''),
        mapOperators(val => this._filter(val, this.getAreas()))
      );
    this.filterRoles = this.formControlRole.valueChanges
      .pipe(
        startWith<string>(''),
        mapOperators(val => this._filter(val, this.roles))
      );
    
    if (this.user.direction_id !== null && this.user.role_id !== null) {      
      this.formControlDirection.patchValue(this.user.direction.name);
      this.formControlArea.patchValue(this.user.area.name);
      this.formControlRole.patchValue(this.user.userRol.rol.name);
    }
  }

  private async _loadAreas() {
    this.areas = [];
    if (this.action === Action.INSERT) {
      this.form.get('area_id').patchValue(null);
      this.formControlArea.patchValue('');
    }
    const id = this.form.get('direction_id').value;
    this.areas = await this.areaService.getList(id).toPromise();
  }

  private _optionRole(data: any): void {
    if (data.type !== null) {
      const type: String = data.type === 'DIRECTION' ? 'Direccción' : 'Área';
      this.formControlRole.patchValue(data.name + ' - ' + type);
    }    
  }

  public getAreas(): any[] {
    if (typeof this.areas !== 'undefined') {
      return this.areas;
    } else {
      return [];
    }
  }

  private _filter(val: any, options: any[]): any[] {
    if (!val) {
      return options;
    }

    if (Object.entries(val).length > 0 && val.constructor === Object) {
      val = val.name;
    }

    return options.filter(unit => {
      return unit.name.toLowerCase().includes(val.toLowerCase());
    });
  }

  public save(): void {
    if (this.form.valid) {
      const params: User = {
        username: this.form.get('username').value,
        name: this.form.get('name').value,
        last_name: this.form.get('last_name').value,
        m_last_name: this.form.get('m_last_name').value,
        email: this.form.get('email').value,
        password: this.form.get('password').value,
        direction_id: this.form.get('direction_id').value,
        area_id: this.form.get('area_id').value,
        role_id: this.form.get('role_id').value
      };

      if (this.action === Action.INSERT){
        this._insert(params);
      } else {
        this._update(params);
      }
    }
  }

  private _insert(params: any): void {    
    this.userService.store(params).subscribe((data: any) => {
      this.dialogRef.close({'action' : 'insert', 'status' : true});
    }, error => {
      this.saving = false;
      this.dialogRef.close({'action' : 'insert', 'status' : false});
    });
  }

  private _update(params: any): void {
    this.userService.update(params, this.user.id).subscribe((data: any) => {
      this.dialogRef.close({'action' : 'updated', 'status' : true});
    }, error => {
      this.saving = false;
      this.dialogRef.close({'action' : 'updated', 'status' : false});
    });
  }

  public optionSelected(event: any, form: string, formC: string, func?): void {
    this.form.get(form).patchValue(event.option.value.id);
    this[formC].patchValue(event.option.value.name);
    if (func) {
      this.form.get('area_id').patchValue(null);
      this.formControlArea.patchValue('');
      this[func](event.option.value);
    }
  }

  public onBlurOptions(event: any, form: string, formC: string): void {    
    if (this.form.get(form).value === '') {
      this[formC].patchValue('');
    }

    if (event.target.value.length === 0) {
      this[formC].patchValue('');
      this.form.get(form).patchValue(null);
    }
  }

  public clickArea(): void {
    this.dirInput.nativeElement.focus();
  }
}
