import { Component, OnInit } from '@angular/core';
import { Role } from '../role.model';
import { MatTableDataSource, MatSnackBar, MatDialog, MatDialogRef } from '@angular/material';
import { RoleService } from '../role.service';
import { FormRoleComponent } from '../form-role/form-role.component';
import { ConfirmComponent } from 'app/dialogs/confirm/confirm.component';

@Component({
  selector: 'app-lists-roles',
  templateUrl: './lists-roles.component.html',
  styleUrls: ['./lists-roles.component.scss']
})
export class ListsRolesComponent implements OnInit {

  public displayedColumns: string[] = ['name', 'type', 'permissions', 'actions'];
  public dataSource: MatTableDataSource<Role>;
  public dialogProjectForm: MatDialogRef<any>;

  constructor(
    private roleService: RoleService,
    public snackBar: MatSnackBar,
    private dialog: MatDialog
  ) { }

  ngOnInit(): void {
    this._refreshRolesList();
  }

  private _refreshRolesList(): void {
    const roles = this.roleService.get();
    roles.subscribe((data: any) => {
      const rolesRecords: Role[] = data.map(role => {
        return {
          id: role.id,
          name: role.name,
          code: role.code,
          type: role.type,
          permissions: role.permissions,
          quantity_users: role.quantity_users
        };
      });

      this.dataSource = new MatTableDataSource(rolesRecords);
    }, error => {
      console.log(error);
    });
  }

  /**
   * valida si existe determinada variable
   */
  isset(value: any): boolean {
    if (value !== undefined && value !== null) {
      return true;
    } else {
      return false;
    }
  }

  /**
  * deleted a direction
  * @param role Direction the direction to delete
  */
  delete(role: Role): void {
    let content = `<label class="text-center title-confirm">¿Estás seguro que quieres eliminar el Rol <strong><br>"${role.name}"</strong>?<label>`;
    let type = 'delete';
    if (role.quantity_users > 0) {
      const label_user = role.quantity_users > 1 ? 'usuarios' : 'usuario';
      content = `<label class="text-center title-confirm">El Rol <strong>"${role.name}"</strong> cuenta con<br>'<strong>${role.quantity_users} ${label_user}</strong>' 
      por lo que no es posible eliminarlo<label>`;
      type = 'message';
    }
    const dialog = this.dialog.open(ConfirmComponent, {
      panelClass: 'dialog-confirm',
      data: {
        content,
        type
      }
    });

    dialog.afterClosed()
      .subscribe(response => {
        if (response) {
          this.roleService.delete(role.id).subscribe(data => {
            this.snackBar.open('Se ha eliminado correctamente el Rol', 'OK', {
              duration: 3500
            });
            this._refreshRolesList();
          }, erro => {
            this.snackBar.open('Error al eliminar el Rol', 'ERROR', {
              duration: 3000
            });
          });
        }
      });
  }

  /**
   * open de modal for the form of the edit or new role
   * @param role Role the role to edit or null for new role
   */
  openFormModal(role: Role): void {
    const dialog = this.dialog.open(FormRoleComponent, {
      panelClass: 'mat-dialog-system-md',
      data: role,
      disableClose: true
    });

    dialog.afterClosed().subscribe(response => {
      if (response) {
        let message = '';
        if (response.action === 'update') {
          if (response.status) {
            message = 'Se ha actualizado correctamente el rol';
          } else {
            message = response.message;
          }
        } else {
          if (response.status) {
            message = 'Se ha creado correctamente el rol';
          } else {
            message = response.message;
          }
        }

        this.snackBar.open(message, 'OK', {
          duration: 3500
        });

        this._refreshRolesList();
      }
    });
  }
}
