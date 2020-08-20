import { Component, OnInit, ViewChild } from '@angular/core';
import { MatTableDataSource, MatDialogRef, MatSnackBar, MatDialog, MatPaginator } from '@angular/material';
import { Area } from '../area.model';
import { AreaService } from '../area.service';
import { ActivatedRoute } from '@angular/router';
import { DirectionService } from '../direction.service';
import { EditAreaComponent } from '../edit-area/edit-area.component';
import { ConfirmComponent } from 'app/dialogs/confirm/confirm.component';
import { LoginService } from 'app/login/login.service';

@Component({
  selector: 'app-list-area',
  templateUrl: './list-area.component.html',
  styleUrls: ['./list-area.component.scss']
})
export class ListAreaComponent implements OnInit {

  public displayedColumns: string[] = ['name', 'remove'];
  public dataSource: MatTableDataSource<Area>;
  public dialogProjectForm: MatDialogRef<any>;
  public directionName = '';
  public directionId: number = null;
  @ViewChild(MatPaginator, { static: true }) paginator: MatPaginator;

  constructor(
    private areaService: AreaService,
    private directionService: DirectionService,
    public snackBar: MatSnackBar,
    private dialog: MatDialog,
    private activatedRoute: ActivatedRoute,
    private loginService: LoginService ) { }

  ngOnInit(): void {
    const id: string = this.activatedRoute.snapshot.paramMap.get('id');
    this.directionService.get(parseInt(id, 10)).subscribe(data => {
      this.directionName = data.name;
      this.directionId = data.id;
      this.refreshAreaList();
    }, error => {
      if (error.status === 401) {
        console.log(error.status);
        // this.loginService.logout();
      }
    });
  }

  refreshAreaList(): void {

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

    this.areaService.getList(this.directionId).subscribe(data => {
      const listAreas: Area[] = data.map(area => {
        return {
          id: area.id,
          name: area.name,
          direction_id: area.direction_id
        };
      });
      this.dataSource = new MatTableDataSource(listAreas);
      this.dataSource.paginator = this.paginator;
    });
  }

  openFormModal(area: any): void {
    const dialog = this.dialog.open(EditAreaComponent, {
      panelClass: 'mat-dialog-system-md',
      data: area,
      disableClose: true
    });

    dialog.afterClosed()
    .subscribe(response => {
      if (response) {
        let message = '';
        if (response.action === 'updated'){
          if ( response.status){
            message  = 'Se ha actualizado correctamente el área';
          } else {
            message  = 'Ha ocurrido un problema al actualizar el área ';
          }
           
        } else {
          if ( response.status ){
            message  = 'Se ha creado correctamente el área';
          } else {
            message  = response.message;
          }
           
        }

        this.snackBar.open(message, 'OK', {
          duration: 3500
        });

        this.refreshAreaList();
      }
    });
  }
  
  public delete(area: Area): void {
    const dialog = this.dialog.open(ConfirmComponent, {
      panelClass: 'dialog-confirm',
      data: {
        content: `<label class="text-center title-confirm">¿Estás seguro que quieres eliminar el Área <strong><br>"${area.name}"</strong>?<label>`,
        type: 'delete'
      }
    });

    dialog.afterClosed()
      .subscribe(response => {
        if (response) {
          this.areaService.delete(area.id).subscribe(data => {            
            this.snackBar.open('Se ha eliminado correctamente el Área', 'OK', {
              duration: 3500
            });
            this.refreshAreaList();
          }, erro => {
            this.snackBar.open('Error al eliminar el Área', 'ERROR', {
              duration: 3000
            });
          });
        }
      });
  }

}
