import { Component, OnInit, Inject } from '@angular/core';
import { FormGroup, FormControl, Validators } from '@angular/forms';
import { Role, TypeRole, PermissionsRole } from '../role.model';
import { RoleService } from '../role.service';
import { MatDialogRef, MAT_DIALOG_DATA } from '@angular/material';

export enum Action{
  INSERT,
  UPDATE 
}

@Component({
  selector: 'app-form-role',
  templateUrl: './form-role.component.html',
  styleUrls: ['./form-role.component.scss']
})
export class FormRoleComponent implements OnInit {

  public form: FormGroup;
  public nameFormControl: FormControl;
  public permissionRoleFC: FormControl;
  public typeRoleFC: FormControl;
  public roleDefault: Role = { name: '', type: '', permissions: '' };
  public action: Action = Action.INSERT;
  public title:  String = 'Nuevo rol';
  public typeRoleDirection: TypeRole = TypeRole.DIRECTION;
  public typeRoleArea: TypeRole = TypeRole.AREA;
  public permissionsRole: PermissionsRole [];

  constructor(
    private roleService: RoleService,
    public dialogRef: MatDialogRef<FormRoleComponent>,
    @Inject(MAT_DIALOG_DATA) private data: any,
  ) { 
    if (data !== undefined && data !== null){
      this.roleDefault = data;
      this.action = Action.UPDATE;
      this.title = 'Editar Rol';    
    }
  }

  public ngOnInit(): void {

    this._initialize();
  }

  /**
   * inicialiteze all instances 
   */
  private _initialize(): void {
    this.permissionsRole = new Array();
    this.permissionsRole[0] = PermissionsRole.VIEW;
    this.permissionsRole[1] = PermissionsRole.EDIT;
    this.nameFormControl = new FormControl(this.roleDefault.name, [Validators.required, Validators.maxLength(50)]);
    let typeRoleDefault: any = TypeRole;
    let permissionsRoleDefault: any = TypeRole;

    if (this.roleDefault.type !== undefined){
      typeRoleDefault = this.roleDefault.type;
    }

    if (this.roleDefault.permissions !== undefined){
      permissionsRoleDefault = this.roleDefault.permissions;
    }

    this.typeRoleFC = new FormControl('', Validators.required);
    this.permissionRoleFC = new FormControl(this.roleDefault.permissions, Validators.required);
    this.form = new FormGroup({
      name: this.nameFormControl,
      typeRoleFC: this.typeRoleFC,
      permissionRoleFC: this.permissionRoleFC
    });

    this.typeRoleFC.patchValue(typeRoleDefault);
  }

  /**
   * insert or update a directions
   */
  public save(): void {
    if (this.form.valid){
      if (this.action === Action.INSERT){
        this._insert();
      } else {
        this._update();
      }
    }    
  }

  private _insert(): void {
    const params: Role = {
      name: this.form.controls['name'].value,
      type: this.form.controls['typeRoleFC'].value,
      permissions: this.form.controls['permissionRoleFC'].value,
    };

    try{      
      this.roleService.store(params).subscribe((data: any) => {
        this.dialogRef.close({'action' : 'insert', 'status' : true});
      }, error => {
        this.dialogRef.close({'action' : 'insert', 'status' : false, 'message' : error.error.message });
      });
      
    } catch (error){}    
    
  }

  private _update(): void {
    const params: Role = {
      name: this.form.controls['name'].value,
      type: this.form.controls['typeRoleFC'].value,
      permissions: this.form.controls['permissionRoleFC'].value,
    };

    try{
      this.roleService.update(this.roleDefault.id, params).subscribe((data: any) => {
        this.dialogRef.close({'action' : 'update', 'status' : true});
      }, error  => {
        this.dialogRef.close({'action' : 'update', 'status' : false, 'message' : error.error.message });
      });

    } catch (error){}

  }
}
