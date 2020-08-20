import { FuseNavigation } from '@fuse/types';
import { Rol } from '../constants/rol';
import * as jwtDecode from 'jwt-decode';

let token: any = null;

const navigationRol: FuseNavigation[] = getNavigation();
export const navigation: FuseNavigation[] = navigationRol;

export function getNavigation(): FuseNavigation[] {
  if (!!localStorage.getItem('token')) {
    token = jwtDecode(localStorage.getItem('token'));
  }

  let rolUser = null;
  try {
    rolUser = token.rol;
  } catch (error) { }

  const permissions: any = rolUser !== null ? rolUser.permissions : '';
  const rol: String = rolUser !== null ? rolUser.code : '';
  let result: any[];

  if (rol === Rol.Admin) {
    result = [
      {
        id: 'applications',
        title: '',
        type: 'group',
        icon: 'apps',
        children: [
          {
            id: 'add_expedient',
            title: 'Nuevo Expediente',
            type: 'item',
            icon: 'add_circle_outline',
            url: 'expedientes/alta'
          },
          {
            id: 'expedient',
            title: 'Expedientes',
            type: 'item',
            icon: 'supervisor_account',
            url: 'expedientes'
          },
          {
            id: 'condig',
            title: 'Configuraciones',
            type: 'collapsable',
            icon: 'settings',
            children: [
              {
                id: 'usuarios',
                title: 'Usuarios',
                type: 'item',
                icon: 'supervisor_account',
                url: '/usuarios'
              },
              {
                id: 'roles',
                title: 'Roles',
                type: 'item',
                icon: 'security',
                url: '/roles'
              },
              {
                id: 'direcciones',
                title: 'Direcciones',
                type: 'item',
                icon: 'assistant',
                url: '/direcciones'
              }
            ]
          }
        ]
      }
    ];
  } else if (rol === Rol.Operation) {
    const childrens: any[] = [];
    if (permissions === 'EDIT') {
      childrens.push({
        id: 'add_expedient',
        title: 'Nuevo Expediente',
        type: 'item',
        icon: 'add_circle_outline',
        url: 'expedientes/alta'
      });
    }
    childrens.push({
      id: 'expedient',
      title: 'Expedientes',
      type: 'item',
      icon: 'supervisor_account',
      url: 'expedientes'
    });

    result = [
      {
        id: 'applications',
        title: '',
        type: 'group',
        icon: 'apps',
        children: childrens
      }
    ];
  }
  return result;
}
