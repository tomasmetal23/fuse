import { Injectable } from '@angular/core';
import { MatPaginator } from '@angular/material';

@Injectable({
    providedIn: 'root'
})
export class Utils {
    public removeAccents(texto): string {
        return String(texto).normalize('NFD').replace(/[\u0300-\u036f]/g, '');
    }

    public translatePaginator(paginator: MatPaginator): MatPaginator {
        const spanishRangeLabel = (page: number, pageSize: number, length: number) => {
            if (length === 0 || pageSize === 0) { return `0 de ${length}`; }
      
            length = Math.max(length, 0);
      
            const startIndex = page * pageSize;
            
            const endIndex = startIndex < length ?
              Math.min(startIndex + pageSize, length) :
              startIndex + pageSize;
      
            return `${startIndex + 1} - ${endIndex} de ${length}`;
        };

        paginator._intl.itemsPerPageLabel = 'Registros por página';
        paginator._intl.nextPageLabel = 'Siguiente';
        paginator._intl.previousPageLabel = 'Anterior';
        paginator._intl.lastPageLabel = 'Ultima página';
        paginator._intl.firstPageLabel = 'Primer página';
        paginator._intl.getRangeLabel = spanishRangeLabel;

        return paginator;
    }

    public filterUsers(val: any, users: any[]): any[] {
        if (!val) {
            return users;
        }
        
        return users.filter(item => {
            let value = item.name;
            if (item.last_name) {
                value += item.last_name;
            }
            if (item.m_last_name && item.m_last_name !== null) {
                value += item.m_last_name;
            }

            return this.removeAccents(value).toLowerCase().includes(this.removeAccents(val).toLowerCase());
        });
    }
    
    public filterTable(): any {
        return (data: any, filter: string) => {
            const matchFilter = [];

            Object.keys(data).forEach(column => {
                if (data[column] instanceof Object) {

                    const first = data[column];
                    Object.keys(first).forEach(columnChild => {
                        if (first[columnChild] instanceof Object) {
                            
                            const second = first[columnChild];

                            Object.keys(second).forEach(columnSecond => {
                                if (!(second[columnSecond] instanceof Object)) {
                                    matchFilter.push(this.removeAccents(second[columnSecond]).toLowerCase()
                                                        .includes(
                                                            filter
                                                        ));        
                                }
                            });
                        } else {
                            matchFilter.push(this.removeAccents(first[columnChild]).toLowerCase()
                                                .includes(
                                                    filter
                                                ));
                        }
                    });
                } else {
                    matchFilter.push(this.removeAccents(data[column]).toLowerCase()
                                        .includes(
                                            filter
                                        ));
                }
            });

            return matchFilter.some((e) => e === true);
        };
    }

    public orderUserList(list: any[]): any[] {
        return list.sort((a, b) => {
            if (a.name > b.name){ 
                return 1; 
            } else if (a.last_name < b.last_name) {
                return -1;
            } else if ((!!a.m_last_name && !!b.m_last_name) && (a.m_last_name < b.m_last_name)) { 
                return -1;
            } else { 
                return 0;
            }
        });
    }

    public dateDiff(first: any, second: any): number {
        return Math.round((second - first) / (1000 * 60 * 60 * 24));
    }

    public parseDate(string: string): Date {        
        const split = string.split('/');

        return new Date(this.parseInt(split[2]), this.parseInt(split[1]) - 1, this.parseInt(split[0]));
    }

    public parseFloat(string: any): number {
        string = !!string ? string.toString() : '0';
        return parseFloat(string.toString()) || 0;
    }

    public parseInt(string: any): number {
        string = !!string ? string.toString() : '0';
        return parseInt(string.toString(), 10) || 0;
    }
}
