import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { AutoCompleteGroupComponent } from './auto-complete-group.component';

describe('AutoCompleteGroupComponent', () => {
  let component: AutoCompleteGroupComponent;
  let fixture: ComponentFixture<AutoCompleteGroupComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ AutoCompleteGroupComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(AutoCompleteGroupComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
