export enum TypeRole {
  DIRECTION = 'DIRECTION',
  AREA = 'AREA'
}
export enum PermissionsRole {
  VIEW = 'VIEW',
  EDIT = 'EDIT'
}
export class Role {
  id?: number;
  name: string;
  code?: string;
  type?: string;
  permissions?: string;
  updated_at?: string;
  created_at?: string;
  quantity_users?: Number;
}
