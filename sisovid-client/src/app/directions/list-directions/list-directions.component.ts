import { Component, OnInit, ViewChild } from '@angular/core';
import { MatTableDataSource, MatPaginator, MatDialog, MatDialogRef, MatSnackBar } from '@angular/material';
import { DirectionService } from '../direction.service';
import { EditDirectionComponent } from '../edit-direction/edit-direction.component';
import { Direction } from '../direction.model';
import { ConfirmComponent } from 'app/dialogs/confirm/confirm.component';
import { LoginService } from 'app/login/login.service';

@Component({
  selector: 'app-list-directions',
  templateUrl: './list-directions.component.html',
  styleUrls: ['./list-directions.component.scss']
})

export class ListDirectionsComponent implements OnInit {

  public displayedColumns: string[] = ['name', 'responsible', 'ver-areas', 'actions'];
  public dataSource: MatTableDataSource<Direction>;
  public dialogProjectForm: MatDialogRef<any>;
  @ViewChild(MatPaginator, { static: true }) paginator: MatPaginator;

  constructor(
    private directionService: DirectionService,
    public snackBar: MatSnackBar,
    private dialog: MatDialog,
    private loginService: LoginService) { }

  ngOnInit(): void {
    this.index();
  }

  /**
   * index action
   */
  index(): void {
    this.refreshDirectionsList();
  }

  /**
   * open de modal for the form of the edit or new direction
   * @param direction Direction the direction to edit or null for new direction
   */
  openFormModal(direction: Direction): void {
    const dialog = this.dialog.open(EditDirectionComponent, {
      panelClass: 'mat-dialog-system-md',
      data: direction,
      disableClose: true
    });

    dialog.afterClosed()
      .subscribe(response => {
        if (response) {
          let message = '';
          if (response.action === 'updated') {
            if (response.status) {
              message = 'Se ha actualizado correctamente la dirección';
            } else {
              message = response.message;
            }
          } else {
            if (response.status) {
              message = 'Se ha creado correctamente la dirección';
            } else {
              message = response.message;
            }
          }

          this.snackBar.open(message, 'OK', {
            duration: 3500
          });

          this.refreshDirectionsList();
        }
      });

  }

  /**
   * deleted a direction
   * @param direction Direction the direction to delete
   */
  delete(direction: Direction): void {
    const dialog = this.dialog.open(ConfirmComponent, {
      panelClass: 'dialog-confirm',
      data: {
        content: `<label class="text-center title-confirm">¿Estás seguro que quieres eliminar la Dirección <strong><br>"${direction.name}"</strong>?<label>`,
        type: 'delete'
      }
    });

    dialog.afterClosed()
      .subscribe(response => {
        if (response) {
          this.directionService.delete(direction.id).subscribe(data => {
            this.snackBar.open('Se ha eliminado correctamente la Dirección', 'OK', {
              duration: 3500
            });
            this.refreshDirectionsList();
          }, erro => {
            this.snackBar.open('Error al eliminar la Dirección', 'ERROR', {
              duration: 3000
            });
          });
        }
      });
  }

  /**
   * refresh the records of the list directories
   */
  refreshDirectionsList(): void {
    const spanishRangeLabel = (page: number, pageSize: number, length: number) => {
      if (length === 0 || pageSize === 0) { return `0 de ${length}`; }
      length = Math.max(length, 0);
      const startIndex = page * pageSize;
      const endIndex = startIndex < length ?
        Math.min(startIndex + pageSize, length) :
        startIndex + pageSize;
      return `${startIndex + 1} - ${endIndex} de ${length}`;
    };

    this.paginator._intl.itemsPerPageLabel = 'Registros por página';
    this.paginator._intl.nextPageLabel = 'Siguiente';
    this.paginator._intl.previousPageLabel = 'Anterior';
    this.paginator._intl.lastPageLabel = 'Ultima página';
    this.paginator._intl.firstPageLabel = 'Primer página';
    this.paginator._intl.getRangeLabel = spanishRangeLabel;

    const directions = this.directionService.getList();
    directions.subscribe((data: any) => {
      const listDirections: Direction[] = data.map(direction => {
        return {
          id: direction.id,
          name: direction.name,
          responsible_user_id: direction.responsible_user_id,
          user: direction.user
        };
      });
      this.dataSource = new MatTableDataSource(listDirections);
      this.dataSource.paginator = this.paginator;
    }, error => {
      if (error.status === 401) {
        console.log(error.status);
        // this.loginService.logout();
      }
    });
  }

  isset(value: any): boolean {
    if (value !== undefined && value !== null) {
      return true;
    } else {
      return false;
    }
  }

}
