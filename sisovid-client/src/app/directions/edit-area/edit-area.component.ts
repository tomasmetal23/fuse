import { Component, OnInit, Inject } from '@angular/core';
import { FormGroup, FormControl, Validators } from '@angular/forms';
import { MAT_DIALOG_DATA, MatDialogRef } from '@angular/material';
import { ActivatedRoute } from '@angular/router';
import { EventEmitter } from 'events';
import { AreaService } from '../area.service';
import { Area } from '../area.model';

export enum Action{
  INSERT,
  UPDATE 
}

@Component({
  selector: 'app-edit-area',
  templateUrl: './edit-area.component.html',
  styleUrls: ['./edit-area.component.scss']
})
export class EditAreaComponent implements OnInit {

  public form: FormGroup;
  public nameFormControl: FormControl;
  public directionFormControl: FormControl;
  public saving: Boolean = false;
  public area: Area = {
    name: '',
    direction_id: null
  };
  public action: Action = Action.INSERT;
  public title: string = 'Nueva Área';
  public onAdd = new EventEmitter();

  constructor(
    private areaService: AreaService,
    public dialogRef: MatDialogRef<EditAreaComponent>,
    @Inject(MAT_DIALOG_DATA) public info: any,
    private activatedRoute: ActivatedRoute
  ) {
    
    if (info.data !== null) {
      this.area = info.data;
      this.action = Action.UPDATE;
      this.title = 'Editar Área';
    }
   }

  ngOnInit() {
    const id: string = this.activatedRoute.snapshot.paramMap.get('id');
    this._initialize(parseInt(id));
  }

  private _initialize(id: number): void {
    this.area.direction_id = id;
    this.nameFormControl = new FormControl(this.area.name, [Validators.required, Validators.maxLength(50)]);
    this.directionFormControl = new FormControl(this.info.name, [Validators.required]);
    this.form = new FormGroup({
      name: this.nameFormControl,
      direction: this.directionFormControl
    });
  }

  save() {
    const params: Area = {
      name: this.form.controls['name'].value.length === 0 ? null : this.form.controls['name'].value,
      direction_id: this.info.directionId
    };

    if (this.form.valid) {
      if (this.action === Action.INSERT) {      
        this._insert(params);
      } else {
        this._update(params);
      }
    }
  }

  private _insert(params: any): void {
    this.areaService.store(params).subscribe(data => {
      this.dialogRef.close({'action': 'insert', 'status': true });
    }, error => {
      this.saving = false;
      this.dialogRef.close({'action': 'insert', 'status': false, 'message' : error.error.message });
    });
  }

  private _update(params: any): void {
    this.areaService.update(this.area.id, params).subscribe(data => {
      this.dialogRef.close({'action': 'updated', 'status': true });
    }, error => {
      this.saving = false;
      this.dialogRef.close({'action': 'updated', 'status': false, 'message' : error.error.message });
    });
  }

}
