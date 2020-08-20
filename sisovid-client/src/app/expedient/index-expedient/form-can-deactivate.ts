import { ComponentCanDeactivate } from './component-can-deactivate';

export abstract class FormCanDeactivate extends ComponentCanDeactivate {

  abstract deactivateMethod(): any;

  canDeactivate(): boolean {
    return this.deactivateMethod();
  }
}
