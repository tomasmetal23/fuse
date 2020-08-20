import { Component, OnInit, ViewEncapsulation, ViewChild } from '@angular/core';
import { MatTableDataSource, MatPaginator } from '@angular/material';
import { ExpedientService } from '../expedient.service';
import { Utils } from '../../constants/utils';
import { AuthService } from 'app/services/auth.service';
import { FormControl } from '@angular/forms';
import { startWith, debounceTime, distinctUntilChanged, switchMap, map } from 'rxjs/operators';
import { Observable, merge } from 'rxjs';

@Component({
	selector: 'list-expedient',
	templateUrl: './list-expedient.component.html',
	styleUrls: ['./list-expedient.component.scss'],
	encapsulation: ViewEncapsulation.None
})
export class ListExpedientComponent implements OnInit {
	displayedColumns: string[] = ['id', 'file_number', 'file_type_id', 'date_capture_complaint', 'direction', 'area', 'edit'];
	public dataSource: MatTableDataSource<any>;
	@ViewChild(MatPaginator, { static: true }) paginator: MatPaginator;
	public hasEditPermissions: Boolean = false;
	public editPermissionIcon: String = 'visibility';
	searchCtrl = new FormControl();
	resultsLength = 0;
	isLoadingResults = true;

	constructor(
		private expedientService: ExpedientService,
		private utils: Utils,
		private authService: AuthService,
	) { }

	ngOnInit(): void {
		const token = this.authService.jwt;
		let hasRoleObject = false;
		let hasExistRole = true;
		let roleObject = null;

		if (token.rol) {
			hasRoleObject = true;
			roleObject = this.authService.rol;
		}

		if (roleObject === null || roleObject === undefined) {
			hasExistRole = false;
		}

		if (hasRoleObject && hasExistRole) {
			if (roleObject.code === 'admin') {
				this.hasEditPermissions = true;
				this.editPermissionIcon = 'edit';
			} else {
				if (roleObject.permissions === 'EDIT') {
					this.hasEditPermissions = true;
					this.editPermissionIcon = 'edit';
				}
			}
		}

		this.searchCtrl.patchValue('');
	}

	ngAfterViewInit(): void {
		this.processRequest();
		this.paginator = this.utils.translatePaginator(this.paginator);
	}

	processRequest(): void {
		merge(this.paginator.page, this.searchCtrl.valueChanges)
			.pipe(
				startWith({}),
				debounceTime(300),
				distinctUntilChanged(),
				switchMap(() => {
					this.isLoadingResults = true;
					return this.index(this.paginator.pageIndex);
				}),
				map(data => {
					this.isLoadingResults = false;
					this.resultsLength = data.total;
					return data.data;
				})
			).subscribe(data => {
				this.dataSource = new MatTableDataSource(data);
			});
	}

	index(page: number): Observable<any> {
		return this.expedientService.getList(this.searchCtrl.value, page);
	}

	applyFilter(filterValue: string): void {
		this.dataSource.filter = this.utils.removeAccents(filterValue.trim().toLowerCase());
	}
}
