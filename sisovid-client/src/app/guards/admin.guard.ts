import { Injectable } from '@angular/core';
import { CanActivate, Router } from '@angular/router';
import { Rol } from 'app/constants/rol';
import { AuthService } from 'app/services/auth.service';

@Injectable()
export class AdminGuard implements CanActivate {

  constructor(
    private router: Router,
    private autService: AuthService
  ) { }

  canActivate(): any {
    if (this.autService.jwt !== null && this.autService.jwt.id !== 0) {
      try {
        const userRole: any = this.autService.rol;
        if (userRole.code === Rol.Admin) {
          return true;
        } else {
          this.router.navigate(['/expedientes']);
        }
      } catch (error) {
        this.router.navigate(['/login']);
      }
    } else {
      this.router.navigate(['/login']);
    }
  }
}
