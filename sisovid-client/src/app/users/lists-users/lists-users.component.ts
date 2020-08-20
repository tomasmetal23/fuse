import { Component, OnInit, ViewChild } from '@angular/core';
import { MatTableDataSource, MatDialogRef, MatSnackBar, MatDialog, MatPaginator } from '@angular/material';
import { UserService } from '../user.service';
import { User } from '../user.model';
import { EditUserComponent } from '../edit-user/edit-user.component';
import { Utils } from 'app/constants/utils';
import { ConfirmComponent } from 'app/dialogs/confirm/confirm.component';
import { LoginService } from 'app/login/login.service';

@Component({
  selector: 'app-lists-users',
  templateUrl: './lists-users.component.html',
  styleUrls: ['./lists-users.component.scss']
})
export class ListsUsersComponent implements OnInit {

  public displayedColumns: string[] = ['name', 'last_name', 'username', 'email', 'role', 'direction', 'area', 'actions'];
  public dataSource: MatTableDataSource<User>;
  public dialogProjectForm: MatDialogRef<any>;
  @ViewChild(MatPaginator, { static: true }) paginator: MatPaginator;

  constructor(
    private userService: UserService,
    public snackBar: MatSnackBar,
    private dialog: MatDialog,
    private utils: Utils,
    private loginService: LoginService
  ) { }

  public ngOnInit(): void {
    this._refreshList();
    this.paginator = this.utils.translatePaginator(this.paginator);
  }

  private _refreshList(): void {
    const users = this.userService.getUsers();
    users.subscribe((data: any) => {
      const records: User[] = data.map(user => {
        return {
          id: user.id,
          name: user.name,
          username: user.username,
          email: user.email,
          last_name: user.last_name,
          m_last_name: user.m_last_name,
          direction: user.direction,
          area: user.area,
          userRol: user.user_rol,
          direction_id: user.direction_id,
          area_id: user.area_id,
          role_id: (user.user_rol !== null) ? user.user_rol.rol_id : null
        };
      });
      this.dataSource = new MatTableDataSource(records);
      this.dataSource.paginator = this.paginator;
      this.dataSource.filterPredicate = this.utils.filterTable();
    }, error => {
      if (error.status === 401) {
        console.log(error.status);
        // this.loginService.logout();
      }
    });
  }

  public openFormModal(user: User): void {
    const dialog = this.dialog.open(EditUserComponent, {
      panelClass: 'mat-dialog-system-md',
      data: user,
      disableClose: true
    });

    dialog.afterClosed()
      .subscribe(response => {
        if (response) {
          let message = '';
          if (response.action === 'updated') {
            if (response.status) {
              message = 'Se ha actualizado correctamente el usuario';
            } else {
              message = 'Ha ocurrido un problema al actualizar el usuario ';
            }
          } else {
            message = 'Se ha creado correctamente el usuario';
          }

          this.snackBar.open(message, 'OK', {
            duration: 3500
          });

          this._refreshList();
        }
      });
  }

  public delete(user: User): void {
    const name = `${user.name} ${user.last_name} ${user.m_last_name}`;
    const dialog = this.dialog.open(ConfirmComponent, {
      panelClass: 'dialog-confirm',
      data: {
        content: `<label class="text-center title-confirm">¿Estás seguro que quieres eliminar el Usuario <strong><br>"${name}"</strong>?<label>`,
        type: 'delete'
      }
    });

    dialog.afterClosed()
      .subscribe(response => {
        if (response) {
          this.userService.delete(user.id).subscribe(data => {
            this.snackBar.open('Se ha eliminado correctamente el Usuario', 'OK', {
              duration: 3500
            });
            this._refreshList();
          }, erro => {
            this.snackBar.open('Error al eliminar el Usuario', 'ERROR', {
              duration: 3000
            });
          });
        }
      });
  }
}
