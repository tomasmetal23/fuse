import { Injectable } from '@angular/core';
import { CanDeactivate } from '@angular/router';
import { ComponentCanDeactivate } from './component-can-deactivate';

@Injectable()
export class CanDeactivateGuard implements CanDeactivate<ComponentCanDeactivate> {
  canDeactivate(component: ComponentCanDeactivate): boolean {

    if (!component.canDeactivate()) {
      if (confirm('Si realizaste cambios es posible que se pierdan, ¿Realmente deseas salir?')) {
        return true;
      } else {
        return false;
      }
    }
    return true;
  }
}
