import { Component, OnInit, Input, Output, EventEmitter } from '@angular/core';
import { Observable } from 'rxjs';
import { FormControl, Validators } from '@angular/forms';
import { startWith, map } from 'rxjs/operators';

@Component({
  selector: 'app-auto-complete-group',
  templateUrl: './auto-complete-group.component.html',
  styleUrls: ['./auto-complete-group.component.scss']
})
export class AutoCompleteGroupComponent implements OnInit {

  @Input() public placeHolder: String = '';
  @Input() public dataGroup: any[] = [];
  @Input() public groupName: string;
  @Input() public columnSelect: string;
  @Input() public widthFlex: any = 100;
  @Input() public idSelected: Number = 0;
  @Input() public isRequired: Boolean = false;


  @Output() public eventOut = new EventEmitter<number>();

  public filteredData: Observable<string[]>;
  public dataInput: FormControl = new FormControl();
  private interval: any;

  constructor() { }

  ngOnInit(): void {
    this.filteredData = this.dataInput.valueChanges
                            .pipe(
                              startWith(''),
                              map(val => this.filterGroup(val))
                            );

    this.interval = setInterval(() => {
      if (!!this.dataGroup.length) {
        this.filteredData = this.dataInput.valueChanges
                            .pipe(
                              startWith(''),
                              map(val => this.filterGroup(val))
                            );

        if (this.idSelected !== 0) {
          this.dataGroup.map(group => {
            const selected = group.data.find(item => item.id === this.idSelected);
            if (!!selected) {
              this.dataInput.patchValue(this.nameUser(selected));
            }
          });
        }

        this.cancelInterval();
      }
    }, 500);

    if (this.isRequired) {
      this.dataInput.setValidators(Validators.required);
    }

  }

  public optionSelected(event): void {
    const selected = this.dataGroup
                          .find(item => item.type === event.option.group.label)
                          .data.find(option => this.nameUser(option).toLowerCase() === event.option.value.toLowerCase());
    if (!!selected) {
      this.eventOut.emit(selected.id);
    }
  }

  private filterGroup(val: any): any[] {
    if (!val) {
      return this.dataGroup;
    }

    return this.dataGroup
                .map(group => ({ type: group.type, data: this.filter(group.data, val) }))
                .filter(group => group.data.length > 0);
  }

  private filter(data: any[], val: string): any[] {
    const filterValue = val.toLowerCase();
    return data.filter(item => this.nameUser(item).toLowerCase().includes(filterValue));
  }

  public onBlur(event): void {
    if (event.target.value.length === 0) {
      this.eventOut.emit(0);
    }
  }

  private cancelInterval(): void {
    clearInterval(this.interval);
  }

  public nameUser(item: any): string {
    let name = item[this.columnSelect];
    if (!!item.last_name) {
      name += ' ' + item.last_name;
    } 

    if (!!item.m_last_name) {
      name += ' ' + item.m_last_name;
    }

    return name;
  }

}
