import { Injectable } from '@angular/core';
import * as jwtDecode from 'jwt-decode';

@Injectable({
  providedIn: 'root'
})
export class AuthService {

  constructor() { }

  get token(): string {
    return !localStorage.getItem('token') ? null : localStorage.getItem('token');
  }

  get jwt(): any {
    const token = {
      name: '',
      lastname: '',
      rol: '',
      id: 0
    };

    return !this.token ? token : jwtDecode(this.token);
  }

  get name(): string {
    return this.jwt.name;
  }

  get fullName(): string {
    return this.jwt.name + ' ' + this.jwt.lastname;
  }

  get initials(): string {
    return this.jwt.name[0] + this.jwt.lastname[0];
  }

  get rol(): any {
    return this.jwt.rol;
  }

  public isAdmin(): boolean{
    console.log(this.rol);
    /*
    if (this.rol === 'admin') {
      return true;
    }
    */

    return false;
  }


  get id(): number {
    return this.jwt.id;
  }
}
