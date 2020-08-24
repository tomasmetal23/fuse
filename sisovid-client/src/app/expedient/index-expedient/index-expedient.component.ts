import { Component, OnInit, ViewEncapsulation, ViewChild, ElementRef } from '@angular/core';
import { FormGroup, FormBuilder, Validators, FormControl, FormArray } from '@angular/forms';
import { ExpedientService } from '../expedient.service';
import { MatStepper, MatSnackBar, MatDialog, DateAdapter, MAT_DATE_FORMATS, MAT_DATE_LOCALE } from '@angular/material';
import { MAT_MOMENT_DATE_FORMATS, MomentDateAdapter } from '@angular/material-moment-adapter';
import { forkJoin, Observable } from 'rxjs';
import { Router, ActivatedRoute } from '@angular/router';
import { ConfirmComponent } from 'app/dialogs/confirm/confirm.component';
import { AreaService } from 'app/directions/area.service';
import { environment } from 'environments/environment';
import { AuthService } from 'app/services/auth.service';
import { ConnectionService } from 'ng-connection-service';
import { FormCanDeactivate } from './form-can-deactivate';
import { startWith, map } from 'rxjs/operators';

@Component({
	selector: 'index-expedient',
	templateUrl: './index-expedient.component.html',
	styleUrls: ['./index-expedient.component.scss'],
	encapsulation: ViewEncapsulation.None,
	providers: [
		{ provide: MAT_DATE_LOCALE, useValue: 'es-MX' },
		{ provide: DateAdapter, useClass: MomentDateAdapter, deps: [MAT_DATE_LOCALE] },
		{ provide: MAT_DATE_FORMATS, useValue: MAT_MOMENT_DATE_FORMATS }
	]
})
export class IndexExpedientComponent extends FormCanDeactivate implements OnInit {
	// Horizontal Stepper
	public formStep1: FormGroup;
	public formStep2: FormGroup;
	public formStep3: FormGroup;
	public formStep4: FormGroup;
	public formStep5: FormGroup;
	public formStep6: FormGroup;
	public formStep7: FormGroup;
	public formErrors: any;
	public saving = false;
	public valuesGeneric: any;
	public catalogs: any;
	public value_field_other = 'OTRO';
	public date_server: any = '';
	public created_date = '';
	public changed = false;
	public yesNoObject = [1, 0];
	public activeEdit = false;
	public editing = false;
	public maxLengthMain = 200;
	public maxLengthAge = 3;
	public maxLengthWeight = 6;
	public maxLengthExpedient = 8;
	public maxDate = this.getTodayDateValidation();
	public lastTabSelected = 0;
	public tabSelected = 0;
	public disabledTab = false;
	public filesUpload: any = [];
	public progress: any;
	public files: any[] = [];
	public filesEdit: any = [];
	public filesRemove: any = [];
	public fileId = null;
	public dataEdit: any;
	public areas: any[];
	public todayDate = this.getTodayDate();
	public roleUser = null;
	public hasEditPermissions: Boolean = false;
	public urlAPI: String = environment.api + 'storage?path=files/media/';
	public mask = [/\d/, /\d/, '-', /\d/, /\d/, /\d/, /\d/, '-', /\d/, /\d/, /\d/, /\d/];
	public maskTime = [/\d/, /\d/, ':', /\d/, /\d/];
	public maskYear = [/\d/, /\d/, /\d/, /\d/];
	public year = (new Date()).getFullYear();
	@ViewChild('file', { static: false }) file: any;
	@ViewChild('catalogsContainer', { static: false }) catContainer: ElementRef;
	isConnected = true;
	deactivateSaving = '';

	filteredNationalities: Observable<any[]>;
	filteredEntities: Observable<any[]>;
	filteredMunicipalities: Observable<any[]>;
	filteredNationalitiesSighting: Observable<any[]>;
	filteredEntitiesSighting: Observable<any[]>;
	filteredMunicipalitiesSighting: Observable<any[]>;

	filteredNationalitiesLocalized: Observable<any[]>;
	filteredEntitiesLocalized: Observable<any[]>;
	filteredMunicipalitiesLocalized: Observable<any[]>;

	constructor(
		private formBuilder: FormBuilder,
		private expedientService: ExpedientService,
		private snackBar: MatSnackBar,
		private router: Router,
		private route: ActivatedRoute,
		public dialog: MatDialog,
		public areaService: AreaService,
		private authService: AuthService,
		private connectionService: ConnectionService
	) {
		super();
		this.valuesGeneric = [{ 'id': 1, 'name': 'SI' }, { 'id': 0, 'name': 'NO' }, { 'id': -1, 'name': 'N/A' }];

		this.connectionService.monitor().subscribe(isConnected => {
			this.isConnected = isConnected;
			if (this.isConnected) {
				this.snackBar.dismiss();
			} else {
				this.snackBar.open('No cuenta con conexión a internet, si realizó cambios, favor de no cerrar la página', '', {
					duration: 0,
					verticalPosition: 'bottom',
					horizontalPosition: 'center'
				});
			}
		});
	}

	ngOnInit(): void {
		this.roleUser = this.authService.rol;
		if (this.roleUser.code === 'admin') {
			this.hasEditPermissions = true;
		} else {
			if (this.roleUser.permissions === 'EDIT') {
				this.hasEditPermissions = true;
			} else {
				this.hasEditPermissions = false;
			}
		}

		if (!this.hasEditPermissions && this.route.snapshot.paramMap.get('fileId') === null) {
			this.router.navigate(['expedientes']);
		}

		/* 
      CONTROL INTERNO 1
    */
		this.formStep1 = this.formBuilder.group({
			// Identificadores
			file_number: ['', [Validators.required, Validators.maxLength(this.maxLengthMain)]],
			police_report_date: ['', []],
			year_file_number: [this.year, [Validators.pattern(/^\d{4}$/)]],
			fe_district_id: ['', [Validators.required]],
			file_type_id: ['', [Validators.required]],
			reception_via_id: [''],
			crime_initial_classification_id: ['', [Validators.required]],
			complementary_complaint: [''],
			judicializable: [''],
			area_id: ['']
		});

		/* 
      PERSONA DESAPARECIDA
    */
		this.formStep2 = this.formBuilder.group({
			// Generales de la persona desaparecida
			victim_name: ['', [Validators.maxLength(this.maxLengthMain)]],
			victim_lastname: ['', [Validators.maxLength(this.maxLengthMain)]],
			victim_mothers_lastname: ['', [Validators.maxLength(this.maxLengthMain)]],
			victim_alias: [''],
			victim_birthdate: ['', []],
			victim_year_or_month_when_fact_id: ['', []],
			victim_gender_id: ['', []],
			victim_generic_identity_id: [''],
			victim_nationality_id: ['', []],
			victim_nationality_object: ['', []],
			victim_nationality_observations: [''],
			victim_migratory_status_id: [''],
			victim_educational_degree_id: [''],
			victim_ethnicity: [''],
			victim_curp: [''],
			victim_rfc: [''],
			victim_ine_ife: [''],
			victim_occupation_option: ['', []],
			victim_occupation_condition_id: [''],
			victim_occupation_activity: [''],
			victim_address_work: [''],

			// Domicilio particular
			victim_federal_entity_reside_id: ['', []],
			victim_federal_entity_reside_object: ['', []],
			victim_federal_entity_reside_observations: [''],
			victim_municipality_reside_id: ['', []],
			victim_municipality_reside_object: ['', []],
			victim_municipality_reside_observations: [''],
			victim_locality_reside: ['', []],
			victim_colony_reside: ['', []],
			victim_street_reside: ['', []],
			victim_exterior_number_reside: ['', []],
			victim_interior_number_reside: ['', []],

			/* 
        MEDIA FILIACION Y PARTICULARIDADES
      */
			// Vestimenta usada el ultimo día del avistamiento
			victim_exterior_upper_clothe: [''],
			victim_exterior_lower_clothe: [''],
			victim_interior_upper_clothe: [''],
			victim_interior_lower_clothe: [''],
			victim_shoes: [''],
			victim_accesories: [''],

			// Descripción morofologica
			victim_complexion_id: [''],
			victim_complexion_observations: [''],
			victim_mf_weight: [''],
			victim_mf_height: [''],
			victim_mf_shape_face_id: [''],
			victim_mf_shape_face_observations: [''],
			victim_eyes_color_id: [''],
			victim_eyes_color_observations: [''],
			victim_eyes_type_id: [''],
			victim_eyes_type_observations: [''],
			victim_skin_id: [''],
			victim_skin_observations: [''],
			victim_hair_shape_id: [''],
			victim_hair_shape_observations: [''],
			victim_hair_size_id: [''],
			victim_hair_size_observations: [''],
			victim_hair_color: [''],
			victim_ears_shape_id: [''],
			victim_ears_shape_observations: [''],
			victim_chin_shape_id: [''],
			victim_chin_shape_observations: [''],
			victim_nose_size_id: [''],
			victim_nose_size_observations: [''],
			victim_nose_type_id: [''],
			victim_nose_type_observations: [''],
			victim_front_shape_id: [''],
			victim_front_shape_observations: [''],
			victim_eyebrows_shape_id: [''],
			victim_eyebrows_shape_observations: [''],
			victim_eyebrows_features: [''],
			victim_mouth_size_id: [''],
			victim_mouth_size_observations: [''],
			victim_lips_thickness_id: [''],
			victim_lips_thickness_observations: [''],
			victim_beard_feature_id: [''],
			victim_beard_feature_observations: [''],
			victim_moustache_shape_id: [''],
			victim_moustache_shape_observations: [''],

			// Dinámicos
			victim_denture_particularities: this.formBuilder.array([
				this.formBuilder.group({
					description: ['']
				})
			]),
			victim_surgical_operations: this.formBuilder.array([
				this.formBuilder.group({
					description: ['']
				})
			]),
			victim_fractures: this.formBuilder.array([
				this.formBuilder.group({
					description: ['']
				})
			]),
			victim_particular_signs: this.formBuilder.array([
				this.formBuilder.group({
					description: ['']
				})
			]),
			victim_tattoos: this.formBuilder.array([
				this.formBuilder.group({
					description: ['']
				})
			]),

			// Ultimo avistamiento (Tiempo)
			fact_last_date_saw: [''],
			// fact_last_hour_saw: ['', [Validators.pattern(/^\d{2}:\d{2}$/)]],
			fact_last_hour_saw: ['', [Validators.pattern(/^([01]\d|2[0-3]):?([0-5]\d)$/)]],

			// Ultimo avistamiento (Lugar)
			place_of_last_sighting: [''],
			last_sighting_country_id: [''],
			last_sighting_country_object: [''],
			last_sighting_country_observations: [''],
			last_sighting_federal_entity_id: [''],
			last_sighting_federal_entity_object: [''],
			last_sighting_federal_entity_observations: [''],
			last_sighting_municipality_id: [''],
			last_sighting_municipality_object: [''],
			last_sighting_municipality_observations: [''],
			last_sighting_locality: [''],
			last_sighting_colony: [''],
			last_sighting_street: [''],
			last_sighting_street_across: [''],

			// Último avistamiento narración (Modo)
			rapporteurship_of_the_fact: [''],
			victim_hobbies: [''],
			victim_clinic_history: [''],
			victim_dental_history: [''],

			// ADN
			victim_people_donate_dna: [''],
			victim_dna_bank: [''],
			victim_dna_existency: [''],

			// Foto

			// Medios electrónicos
			victim_phone: [''],
			victim_social_networks: [''],
		});

		/* 
      VEHÍCULOS PARTICIPANTES
    */
		this.formStep3 = this.formBuilder.group({
			// Vehículo víctima
			fact_vehiculo_victim: ['', []],
			fact_vehiculo_plate: [''],
			fact_vehiculo_brand: [''],
			fact_vehiculo_sub_brand: [''],
			fact_vehiculo_model: [''],
			fact_vehiculo_color: [''],

			// Vehículo sospechoso
			suspicious_vehicles: ['', []],

			// Dinámico
			suspicious_vehicles_list: this.formBuilder.array([
				this.formBuilder.group({
					plate: [''],
					brand: [''],
					sub_brand: [''],
					model: [''],
					color: [''],
				})
			]),
		});


		/* 
      PERSONA DENUNCIANTE
    */
		this.formStep4 = this.formBuilder.group({
			// Denunciante
			informer_name: ['', []],
			informer_lastname: ['', []],
			informer_mothers_lastname: ['', []],
			informer_gender_id: ['', []],
			informer_birthdate: ['', []],
			informer_years: [''],
			informer_kinship_id: ['', []],
			informer_curp: [''],
			informer_rfc: [''],
			informer_ine_ife: [''],

			// Domicilio de la persona denunciante
			informer_resident_federal_entity_id: ['', []],
			informer_resident_federal_entity_observations: [''],
			informer_resident_municipality_id: ['', []],
			informer_resident_municipality_observations: [''],
			informer_resident_locality: ['', []],
			informer_resident_colony: ['', []],
			informer_resident_street: ['', []],
			informer_resident_exterior_number: ['', []],
			informer_resident_interior_number: ['', []],

			// Medios de contacto
			informer_phone: ['', [Validators.pattern(/^\d{2}-\d{4}-\d{4}$/)]],
			informer_email: ['', [Validators.email]]
		});


		/* 
      CONTROL INTERNO 2
    */
		this.formStep5 = this.formBuilder.group({
			// Control
			capture_agency_number_id: ['', []],
			ic2_accumulated: [''],
			crime_final_classification_id: ['', []],

			// Localizaciones, bajas y activas
			status_file_id: [''],
			justification_of_low_status: [''],
			date_of_low_file: [''],

			localized_victim_option: ['', []],
			localized_condition_id: [''],
			localized_condition_details_id: [''],
			localized_victim_date: [''],

			localized_place_option: [''],
			localized_country_id: [''],
			localized_country_object: [''],
			localized_country_observations: [''],
			localized_federal_entity_id: [''],
			localized_federal_entity_object: [''],
			localized_federal_entity_observations: [''],
			localized_municipality_id: [''],
			localized_municipality_object: [''],
			localized_municipality_observations: [''],
			localized_locality_or_colony: [''],

			file_observations: ['']
		});


		/* 
      IMPUTADOS
    */
		this.formStep6 = this.formBuilder.group({
			// Vehículo sospechoso
			accuseds: ['', [Validators.required]],
			// Dinámico
			accuseds_list: this.formBuilder.array([
				this.formBuilder.group({
					name: [''],
					lastname: [''],
					mothers_lastname: [''],
					alias: [''],
					date_of_birth: [''],
					age_when_fact_id: [''],
					gender_id: ['']
				})
			]),
		});


		/* 
      ASEGURAMIENTOS
    */
		this.formStep7 = this.formBuilder.group({
			assurance_properties: [''],
			assurance_goods: ['']
		});

		this.expedientService.getCatalogs().subscribe((data: any) => {
			this.catalogs = data;

			// Llenar catálogos de paises 
			this.fillAutocompleteOptions();
			/* COMPLETAR DATOS PARA EDICIÓN */
			this.fileId = this.route.snapshot.paramMap.get('fileId');
			if (this.fileId) {
				this.fileId = parseInt(this.fileId, 10);
				this.init(2);
				this.editing = true;
			}
		}, error => {
			console.log(error);
		});

		// this.loadAreas();
	}

	fillAutocompleteOptions(): void {
		this.filteredNationalities = this.victim_nationality_object.valueChanges
			.pipe(
				startWith(''),
				map((value: any) => typeof value === 'string' ? value : value.name),
				map(name => name ? this._filter(name, this.catalogs.nationalities) : this.catalogs.nationalities.slice())
			);

		this.filteredEntities = this.victim_federal_entity_reside_object.valueChanges
			.pipe(
				startWith(''),
				map((value: any) => typeof value === 'string' ? value : value.name),
				map(name => name ? this._filter(name, this.catalogs.federal_entities) : this.catalogs.federal_entities.slice())
			);

		this.filteredMunicipalities = this.victim_municipality_reside_object.valueChanges
			.pipe(
				startWith(''),
				map((value: any) => typeof value === 'string' ? value : value.name),
				map(name => name ? this._filter(name, this.catalogs.municipalities) : this.catalogs.municipalities.slice())
			);

		this.filteredNationalitiesSighting = this.last_sighting_country_object.valueChanges
			.pipe(
				startWith(''),
				map((value: any) => typeof value === 'string' ? value : value.name),
				map(name => name ? this._filter(name, this.catalogs.countries) : this.catalogs.countries.slice())
			);

		this.filteredEntitiesSighting = this.last_sighting_federal_entity_object.valueChanges
			.pipe(
				startWith(''),
				map((value: any) => typeof value === 'string' ? value : value.name),
				map(name => name ? this._filter(name, this.catalogs.federal_entities) : this.catalogs.federal_entities.slice())
			);

		this.filteredMunicipalitiesSighting = this.last_sighting_municipality_object.valueChanges
			.pipe(
				startWith(''),
				map((value: any) => typeof value === 'string' ? value : value.name),
				map(name => name ? this._filter(name, this.catalogs.municipalities) : this.catalogs.municipalities.slice())
			);

		this.filteredNationalitiesLocalized = this.localized_country_object.valueChanges
			.pipe(
				startWith(''),
				map((value: any) => typeof value === 'string' ? value : value.name),
				map(name => name ? this._filter(name, this.catalogs.countries) : this.catalogs.countries.slice())
			);

		this.filteredEntitiesLocalized = this.localized_federal_entity_object.valueChanges
			.pipe(
				startWith(''),
				map((value: any) => typeof value === 'string' ? value : value.name),
				map(name => name ? this._filter(name, this.catalogs.federal_entities) : this.catalogs.federal_entities.slice())
			);

		this.filteredMunicipalitiesLocalized = this.localized_municipality_object.valueChanges
			.pipe(
				startWith(''),
				map((value: any) => typeof value === 'string' ? value : value.name),
				map(name => name ? this._filter(name, this.catalogs.municipalities) : this.catalogs.municipalities.slice())
			);
	}

	init(type?: any): void {
		this.expedientService.get(this.fileId).subscribe(dataObject => {
			this.dataEdit = dataObject[0];
			if (this.dataEdit && this.dataEdit.file_internal_control1) {
				const expedientNumber = this.dataEdit.file_number.split('/');
				this.dataEdit.file_internal_control1.file_number = expedientNumber[0];
				this.dataEdit.file_number = expedientNumber[0];
				this.dataEdit.file_internal_control1.year_file_number = expedientNumber[1] ? expedientNumber[1] : this.year;
			}

			this.date_server = this.dataEdit.actual_time.split(' ')[0];
			this.filesEdit = this.dataEdit.file_media;
			this.created_date = this.formatDate(this.dataEdit.created_at);
			this.completeDataEdit();
			if (localStorage.redirect && localStorage.redirect === 'true') {
				this.activeEdit = true;
				this.activeAllFields();
				localStorage.removeItem('redirect');
			} else {
				if (type) {
					this.activateEditMethod(type);
				}
			}
		}, error => {
			this.router.navigate(['expedientes']);
			this.editing = false;
		});
	}

	deactivateMethod(): boolean {
		if (this.deactivateSaving === '1' || !this.activeEdit) {
			return true;
		}
		if (!this.editing) {
			const formValues = this.formStep1.value;
			let change = false;
			for (const key in formValues) {
				if (key && formValues[key] !== '') {
					change = true;
				}
			}
			return !change;
		} else {
			this.changed = false;
			const objects = ['file_internal_control1', 'file_victim_data', 'file_participant_vehicle', 'file_informer', 'file_internal_control2', 'file_accused', 'file_assurance'];
			[0, 1, 2, 3, 4, 5, 6].forEach((element, index) => {
				const form = this.getForm(element);
				this.checkField(form, objects[index]);
			});
			if (this.formStep1.controls['file_number'].value !== this.dataEdit['file_number']) {
				this.changed = true;
			}
			return !this.changed;
		}
	}

	private loadAreas(): void {
		const directionId: number = parseInt(localStorage.getItem('direction'), 10);
		this.areaService.getList(directionId).subscribe(data => this.areas = data);
	}

	completeDataEdit(): void {
		let objects: any = null;
		if (localStorage.redirect && localStorage.redirect === 'true') {
			this.tabSelected = 1;
			objects = ['file_internal_control1'];
		} else {
			objects = ['file_internal_control1', 'file_victim_data', 'file_participant_vehicle', 'file_informer', 'file_internal_control2', 'file_accused', 'file_assurance'];
		}
		objects.forEach((element, index) => {
			const form = this.getForm(index);
			this.fillFields(form, objects[index]);
		});

		this.formStep1.patchValue({
			file_number: this.dataEdit['file_number']
		});
	}

	verifyFieldsChanged(): void {
		this.changed = false;
		const objects = ['file_internal_control1', 'file_victim_data', 'file_participant_vehicle', 'file_informer', 'file_internal_control2', 'file_accused', 'file_assurance'];
		[0, 1, 2, 3, 4, 5, 6].forEach((element, index) => {
			const form = this.getForm(element);
			this.checkField(form, objects[index]);
		});
		if (this.formStep1.controls['file_number'].value !== this.dataEdit['file_number']) {
			this.changed = true;
		}

		if (this.changed) {
			this.openConfirmCancelDialog();
		} else {
			this.activeEdit = !this.activeEdit;
			this.activeAllFields();
		}
	}

	checkField(form: any, object: string): void {
		const fieldsDynamic = [
			'victim_denture_particularities',
			'victim_surgical_operations',
			'victim_fractures',
			'victim_particular_signs',
			'victim_tattoos',
			'suspicious_vehicles_list',
			'accuseds_list'
		];
		const ignoreAutcomplete = ['victim_nationality_object', 'victim_federal_entity_reside_object', 'victim_municipality_reside_object',
			'last_sighting_country_object', 'last_sighting_federal_entity_object', 'last_sighting_municipality_object',
			'localized_country_object', 'localized_federal_entity_object', 'localized_municipality_object'];
		for (const item in form.controls) {
			if (fieldsDynamic.includes(item)) {
				this.checkDynamicField(form, object, item);
			} else {
				if (this.dataEdit[object] && this.dataEdit[object].hasOwnProperty(item)) {
					if (form.controls[item].value !== this.dataEdit[object][item] && this.compareNullEmpty(form.controls[item].value, this.dataEdit[object][item])) {
						this.changed = true;
						return;
					}
				} else {
					if (form.controls[item].value && form.controls[item].value !== '' && !ignoreAutcomplete.includes(item)) {
						this.changed = true;
						return;
					}
				}
			}
		}
	}

	compareNullEmpty(formValue, object): boolean {
		if ( (formValue === null || formValue === '') && (object === null || object === '') ) {
			return false;
		}
		return true;
	}

	checkDynamicField(form: any, object: string, item: string): void {
		if (item !== 'suspicious_vehicles_list' && item !== 'accuseds_list') {
			let index;

			switch (item) {
				case 'victim_denture_particularities': index = 'file_victim_denture_particularity'; break;
				case 'victim_surgical_operations': index = 'file_victim_surgical_operation'; break;
				case 'victim_fractures': index = 'file_victim_fracture'; break;
				case 'victim_particular_signs': index = 'file_victim_particular_sign'; break;
				case 'victim_tattoos': index = 'file_victim_tattoo'; break;
			}

			if (this.dataEdit[object] && this.dataEdit[object].hasOwnProperty(index)) {
				if (form.get(item).value.length !== this.dataEdit[object][index].length) {
					this.changed = true;
				} else {
					form.get(item).value.forEach((valueObj, i) => {
						if (valueObj.description !== this.dataEdit[object][index][i].description) {
							this.changed = true;
						}
					});
				}
			}
		} else {
			if (this.dataEdit[object] && this.dataEdit[object].hasOwnProperty(item)) {
				switch (item) {
					case 'suspicious_vehicles_list':
						if (form.get(item).value.length !== this.dataEdit[object]['vehicle_suspicious'].length) {
							this.changed = true;
						} else {
							form.get(item).value.forEach((valueObj, i) => {
								if (
									valueObj.description !== this.dataEdit[object]['vehicle_suspicious'][i].description ||
									valueObj.plate !== this.dataEdit[object]['vehicle_suspicious'][i].fact_suspicious_vehiculo_plate ||
									valueObj.brand !== this.dataEdit[object]['vehicle_suspicious'][i].fact_suspicious_vehiculo_brand ||
									valueObj.sub_brand !== this.dataEdit[object]['vehicle_suspicious'][i].fact_suspicious_vehiculo_sub_brand ||
									valueObj.model !== this.dataEdit[object]['vehicle_suspicious'][i].fact_suspicious_vehiculo_model ||
									valueObj.color !== this.dataEdit[object]['vehicle_suspicious'][i].fact_suspicious_vehiculo_color
								) {
									this.changed = true;
								}
							});
						}
						break;

					case 'accuseds_list':
						if (form.get(item).value.length !== this.dataEdit[object].length) {
							this.changed = true;
						} else {
							form.get(item).value.forEach((valueObj, i) => {
								if (
									valueObj.name !== this.dataEdit[object][i].accused_name ||
									valueObj.lastname !== this.dataEdit[object][i].accused_lastname ||
									valueObj.mothers_lastname !== this.dataEdit[object][i].accused_mothers_lastname ||
									valueObj.alias !== this.dataEdit[object][i].accused_alias ||
									valueObj.date_of_birth !== this.dataEdit[object][i].accused_date_of_birth ||
									valueObj.age_when_fact_id !== this.dataEdit[object][i].accused_age_when_fact_id ||
									valueObj.gender_id !== this.dataEdit[object][i].accused_gender_id
								) {
									this.changed = true;
								}
							});
						}
						break;

					default:
						break;
				}
			}
		}
	}

	openConfirmCancelDialog(): void {
		const dialog = this.dialog.open(ConfirmComponent, {
			panelClass: 'dialog-confirm',
			data: {
				content: `<label class="text-center title-confirm">¿Estás seguro que quieres cancelar la edición?, se perderán todos los cambios realizados<label>`,
				type: 'edit'
			}
		});

		dialog.afterClosed()
			.subscribe(response => {
				if (response) {
					this.activeEdit = !this.activeEdit;
					this.activeAllFields();
					this.completeDataEdit();
				}
			});
	}

	/* COMPLETAR DATOS PARA EDICIÓN */

	fillFields(form: any, object: string): void {
		const fieldsDates = ['date_of_low_file', 'dna_date_providing_sample'];
		const fieldsDynamic = [
			'victim_denture_particularities',
			'victim_surgical_operations',
			'victim_fractures',
			'victim_particular_signs',
			'victim_tattoos',
			'suspicious_vehicles_list',
			'accuseds_list'
		];
		const ignoreAutcomplete = ['victim_nationality_object', 'victim_federal_entity_reside_object', 'victim_municipality_reside_object',
			'last_sighting_country_object', 'last_sighting_federal_entity_object', 'last_sighting_municipality_object',
			'localized_country_object', 'localized_federal_entity_object', 'localized_municipality_object'];
		const fieldsAutcomplete = ['victim_nationality_id', 'victim_federal_entity_reside_id', 'victim_municipality_reside_id',
			'last_sighting_country_id', 'last_sighting_federal_entity_id', 'last_sighting_municipality_id',
			'localized_country_id', 'localized_federal_entity_id', 'localized_municipality_id'];
		const catalogs = [
			{ key: 'victim_nationality_object', catalog: this.catalogs.nationalities },
			{ key: 'victim_federal_entity_reside_object', catalog: this.catalogs.federal_entities },
			{ key: 'victim_municipality_reside_object', catalog: this.catalogs.municipalities },
			{ key: 'last_sighting_country_object', catalog: this.catalogs.countries },
			{ key: 'last_sighting_federal_entity_object', catalog: this.catalogs.federal_entities },
			{ key: 'last_sighting_municipality_object', catalog: this.catalogs.municipalities },
			{ key: 'localized_country_object', catalog: this.catalogs.countries },
			{ key: 'localized_federal_entity_object', catalog: this.catalogs.federal_entities },
			{ key: 'localized_municipality_object', catalog: this.catalogs.municipalities }
		];
		for (const item in form.controls) {
			if (item) {
				if (fieldsDates.includes(item)) {
					if (this.dataEdit[object] && this.dataEdit[object].hasOwnProperty(item)) {
						const event = { value: this.dataEdit[object][item] };
						this.setDateForm(event, item, form);
					}
				} else if (fieldsAutcomplete.includes(item) || ignoreAutcomplete.includes(item)) {
					const index = fieldsAutcomplete.indexOf(item);
					if (index >= 0) {
						if (this.dataEdit[object] && this.dataEdit[object].hasOwnProperty(item)) {
							const objectAutocomplete = catalogs[index].catalog.filter(x => x.id === this.dataEdit[object][item]);
							if (objectAutocomplete && objectAutocomplete.length > 0 && !ignoreAutcomplete.includes(item)) {
								form.controls[catalogs[index].key].patchValue(objectAutocomplete[0]);
								form.controls[item].patchValue(this.dataEdit[object][item]);
							}
						}
					}
				} else {
					if (fieldsDynamic.includes(item)) {
						this.fillDynamicFields(form, object, item);
					} else {
						if (this.dataEdit[object] && this.dataEdit[object].hasOwnProperty(item)) {
							form.controls[item].patchValue(this.dataEdit[object][item]);
						} else {
							form.controls[item].patchValue('');
						}
					}
				}
			}
		}
	}

	fillDynamicFields(form: any, object: string, item: string): void {
		if (this.dataEdit[object]) {
			const formArray = new FormArray([]);

			switch (item) {
				case 'victim_denture_particularities':
					this.dataEdit[object]['file_victim_denture_particularity'].forEach(denture => {
						formArray.push(
							new FormGroup({
								description: new FormControl(denture.description)
							})
						);
					});
					break;

				case 'victim_surgical_operations':
					this.dataEdit[object]['file_victim_surgical_operation'].forEach(surgical_operation => {
						formArray.push(
							new FormGroup({
								description: new FormControl(surgical_operation.description)
							})
						);
					});
					break;

				case 'victim_fractures':
					this.dataEdit[object]['file_victim_fracture'].forEach(fracture => {
						formArray.push(
							new FormGroup({
								description: new FormControl(fracture.description)
							})
						);
					});
					break;

				case 'victim_particular_signs':
					this.dataEdit[object]['file_victim_particular_sign'].forEach(particular_sign => {
						formArray.push(
							new FormGroup({
								description: new FormControl(particular_sign.description)
							})
						);
					});
					break;

				case 'victim_tattoos':
					this.dataEdit[object]['file_victim_tattoo'].forEach(tattoo => {
						formArray.push(
							new FormGroup({
								description: new FormControl(tattoo.description)
							})
						);
					});
					break;

				case 'suspicious_vehicles_list':
					this.dataEdit[object]['vehicle_suspicious'].forEach(vehicle_suspicious => {
						formArray.push(
							new FormGroup({
								plate: new FormControl(vehicle_suspicious.fact_suspicious_vehiculo_plate),
								brand: new FormControl(vehicle_suspicious.fact_suspicious_vehiculo_brand),
								sub_brand: new FormControl(vehicle_suspicious.fact_suspicious_vehiculo_sub_brand),
								model: new FormControl(vehicle_suspicious.fact_suspicious_vehiculo_model),
								color: new FormControl(vehicle_suspicious.fact_suspicious_vehiculo_color),
							})
						);
					});
					break;

				case 'accuseds_list':
					this.dataEdit[object].forEach(accused => {
						formArray.push(
							new FormGroup({
								name: new FormControl(accused.accused_name),
								lastname: new FormControl(accused.accused_lastname),
								mothers_lastname: new FormControl(accused.accused_mothers_lastname),
								alias: new FormControl(accused.accused_alias),
								date_of_birth: new FormControl(accused.accused_date_of_birth),
								age_when_fact_id: new FormControl(accused.accused_age_when_fact_id),
								gender_id: new FormControl(accused.accused_gender_id)
							})
						);
					});

					this.formStep6.get('accuseds').patchValue(this.dataEdit[object].length === 0 ? 0 : 1);
					break;

				default:
					break;
			}

			form.setControl(item, formArray);
		}
	}

	getDateValue(form: any, field: string, index: number = null, subfield: string = null): any {
		if (index != null && subfield != null) {
			return form.controls[field].controls[index].controls[subfield].value;
		} else {
			return form.controls[field].value;
		}
	}

	setDateForm(event: any, name: string, form: any): void {
		form.controls[name].setValue(event.value);
		if (name === 'victim_birthdate') {
			this.calculateDiff(form, name, this.date_server);
		}
	}

	activeAllFields(): void {
		[0, 1, 2, 3, 4, 5, 6].forEach((element) => {
			const form = this.getForm(element);
			for (const item in form.controls) {
				if (this.activeEdit) {
					form.controls[item].enable();
				} else {
					form.controls[item].disable();
				}
			}
			const event = { target: { value: this.formStep2.value.victim_alias } };
			this.onBlurAliasVictim(event);
		});
	}

	/* COMPLETAR DATOS PARA EDICIÓN */

	/* STEP 1*/

	setDateForm1(event: any, name: string): void {
		this.formStep1.controls[name].setValue(event.value.format('YYYY-MM-DD'));
	}

	/* STEP 2 */

	onBlurAliasVictim(event: any): void {
	}

	onBlurCalculateAge(event: any): void {
		if (this.formStep2.get('victim_birthdate').value === '') {
			this.formStep2.patchValue({
				informer_years: event.target.value
			});
		}
	}

	setDateForm2(event: any, name: string): void {
		this.formStep2.controls[name].setValue(event.value.format('YYYY-MM-DD'));
	}

	calculateDiff(form: any, name: string, date_server: string): void {
		let date: any = '';
		if (date_server === '') {
			date = +new Date(form.get(name).value);
		} else {
			date = +new Date(date_server);
		}

		const difdt: any = new Date(+new Date() - date);

		const anios: any = +difdt.toISOString().slice(0, 4) - 1970;
		const months: any = difdt.getMonth() + 1;
		const text_anios = anios === 1 ? `${anios} año ` : (anios === 0) ? '' : `${anios} años `;
		const text_months = months === 1 ? `${months} mes` : (months === 0) ? '' : `${months} meses`;

		// ALTA
		if (!this.editing) {
			if (anios > 0 || months > 0) {
				form.patchValue({
					victim_year_or_mounth_current: `${text_anios} ${text_months}`,
					victim_year_or_mounth_when_fact: anios > 0 ? anios : months,
					victim_mounth_or_year: anios > 0 ? 'year' : 'month'
				});
			} else {
				form.patchValue({
					victim_year_or_mounth_current: '',
					victim_year_or_mounth_when_fact: null,
					victim_mounth_or_year: ''
				});
			}
		} else {
			// EDICIÓN
			if (form.get('victim_year_or_mounth_current').value === '') {
				if (anios > 0 || months > 0) {
					form.patchValue({ victim_year_or_mounth_current: `${text_anios} ${text_months}` });
				} else {
					form.patchValue({ victim_year_or_mounth_current: '' });
				}
			} else {
				if (anios > 0 || months > 0) {
					form.patchValue({
						victim_year_or_mounth_when_fact: anios > 0 ? anios : months,
						victim_mounth_or_year: anios > 0 ? 'year' : 'month'
					});
				} else {
					form.patchValue({
						victim_year_or_mounth_when_fact: null,
						victim_mounth_or_year: ''
					});
				}
			}
		}
	}


	calculateDiffInformer(form: any, name: string, date_server: string): void {
		let date: any = '';
		if (date_server === '') {
			date = +new Date(form.get(name).value);
		} else {
			date = +new Date(date_server);
		}

		const difdt: any = new Date(+new Date() - date);

		const anios: any = +difdt.toISOString().slice(0, 4) - 1970;
		const months: any = difdt.getMonth() + 1;
		const text_anios = anios === 1 ? `${anios} año ` : (anios === 0) ? '' : `${anios} años `;
		const text_months = months === 1 ? `${months} mes` : (months === 0) ? '' : `${months} meses`;

		// ALTA
		if (!this.editing) {
			if (anios > 0 || months > 0) {
				form.patchValue({
					informer_years: `${text_anios} ${text_months}`
				});
			} else {
				form.patchValue({
					informer_years: null,
				});
			}
		} else {
			// EDICIÓN
			if (form.get('informer_years').value === '') {
				if (anios > 0 || months > 0) {
					form.patchValue({ informer_years: `${text_anios} ${text_months}` });
				} else {
					form.patchValue({ informer_years: '' });
				}
			} else {
				if (anios > 0 || months > 0) {
					form.patchValue({
						victim_year_or_mounth_when_fact: anios > 0 ? anios : months,
						victim_mounth_or_year: anios > 0 ? 'year' : 'month',
						informer_years: `${text_anios} ${text_months}`
					});
				} else {
					form.patchValue({
						victim_year_or_mounth_when_fact: null,
						victim_mounth_or_year: '',
						informer_years: ''
					});
				}
			}
		}
	}

	changeCleanChild(event: any, name: string): void {
		if (event.value === 'other') {
			const validators = [Validators.required, Validators.maxLength(this.maxLengthMain)];
			this.formStep2.controls[name].setValidators(validators);
			this.formStep2.controls[name].updateValueAndValidity();
		} else {
			this.formStep2.controls[name].clearValidators();
			this.formStep2.controls[name].updateValueAndValidity();
		}
	}

	onFilesAdded(): void {
		const files: { [key: string]: File } = this.file.nativeElement.files;
		for (const key in files) {
			if (!isNaN(parseInt(key, 10))) {
				this.files.push(files[key]);
			}
		}
	}

	addFiles(): void {
		this.file.nativeElement.click();
	}

	showStatusFiles(): boolean {
		return this.formStep5.controls.status_file_id.value === 2 || this.formStep5.controls.status_file_id.value === 3;
	}

	showStatusExpedient(): any {
		// CIERRE
		return this.formStep5.controls.status_file_id.value === 2;
	}

	showLocateMissingList(): boolean{
		return this.formStep5.controls.status_file_id.value === 2 || this.formStep5.controls.status_file_id.value === 3;
	}

	getCatalogConditions(catalog: any): any {
		return catalog.filter(item => item.type_status_file === this.formStep5.controls.status_file_id.value);
	}

	showStatusExpedientLocalized(): any {
		// LOCALIZADA
		return this.formStep5.controls.status_file_id.value === 3;
	}

	showLocateMissing(): any {
		return this.formStep5.controls.localized_victim_option.value === 3;
	}

	showCurrentCouple(): any {
		return this.formStep2.controls.current_couple_option.value === 1;
	}

	showCurrentEmployee(): any {
		return this.formStep2.controls.victim_occupation_option.value === 1;
	}

	/* 3 */

	showExistsSuspicious(): any {
		return this.formStep3.controls.suspicious_exists.value === 1;
	}

	showVehicle(): any {
		return this.formStep3.controls.fact_vehiculo_victim.value === 1;
	}

	showVehicleSuspicious(): any {
		return this.formStep3.controls.suspicious_vehicles.value === 1;
	}

	showOtherFields(form: any, field: any): any {
		return form.controls[field].value === 1;
	}

	getMedia(): any {
		return this.filesEdit;
	}

	removeMedia(id: any, index: any): any {
		if (id) {
			// Files to remove
			const fileToRemove = this.filesEdit.filter(obj => {
				return obj.id === id;
			});

			if (fileToRemove.length > 0) {
				this.filesRemove.push(fileToRemove[0]);
			}

			// Current Files
			this.filesEdit = this.filesEdit.filter(obj => {
				return obj.id !== id;
			});
		} else {
			// Current Files
			this.files = this.files.filter((obj, i) => {
				return i !== index;
			});
		}
	}

	/* STEP 3*/

	setDateForm3(event: any, name: string): void {
		this.formStep3.controls[name].setValue(event.value.format('YYYY-MM-DD'));
	}

	/* STEP 4 */

	setDateForm4(event: any, name: string): void {
		this.formStep4.controls[name].setValue(event.value.format('YYYY-MM-DD'));
		this.calculateDiffInformer(this.formStep4, name, '');
	}

	/* STEP 5*/

	setDateForm5(event: any, name: string): void {
		this.formStep5.controls[name].setValue(event.value.format('YYYY-MM-DD'));
	}

	/* STEP 6 */
	showAccuseds(): boolean {
		return this.formStep6.controls.accuseds.value === 1;
	}

	setDateForm6(event: any, name: string, index: number, subfield: string): void {
		this.formStep6.controls[name]['controls'][index].controls[subfield].setValue(event.value.format('YYYY-MM-DD'));
	}


	/* ALL STEPS*/

	validateShowOtherField(form: FormGroup, field: string, field_other: string, object: any): boolean {
		const findIndex = object.findIndex((x: any) => x.id === form.get(field).value);
		if (findIndex >= 0) {
			if (object[findIndex].name === this.value_field_other) {
				form.controls[field_other].setValidators([Validators.required, Validators.maxLength(this.maxLengthMain)]);
				form.controls[field_other].updateValueAndValidity();
				return true;
			}
		}
		form.controls[field_other].clearValidators();
		form.controls[field_other].updateValueAndValidity();
		return false;
	}

	validateShowYesField(form: FormGroup, field: string, field_other: string): boolean {
		if (form.get(field).value === 1) {
			form.controls[field_other].setValidators([Validators.required, Validators.maxLength(this.maxLengthMain)]);
			form.controls[field_other].updateValueAndValidity();
			return true;
		}
		form.controls[field_other].clearValidators();
		form.controls[field_other].updateValueAndValidity();
		return false;
	}

	validateShowOtherAutocomplete(form: FormGroup, field: string, field_other: string, object: any): boolean {
		const findIndex = object.findIndex((x: any) => x.id === form.get(field).value);
		if (findIndex >= 0) {
			if (object[findIndex].name === this.value_field_other) {
				form.controls[field_other].setValidators([Validators.required, Validators.maxLength(this.maxLengthMain)]);
				form.controls[field_other].updateValueAndValidity();
				return true;
			}
		}
		form.controls[field_other].clearValidators();
		form.controls[field_other].updateValueAndValidity();
		return false;
	}

	getTodayDateValidation(): string {
		let today: any = new Date();
		let dd: any = today.getDate();
		let mm: any = today.getMonth() + 1;

		const yyyy = today.getFullYear();
		if (dd < 10) {
			dd = '0' + dd;
		}
		if (mm < 10) {
			mm = '0' + mm;
		}
		today = yyyy + '-' + mm + '-' + dd;
		return today;
	}

	getTodayDate(): string {
		let today: any = new Date();
		let dd: any = today.getDate();
		let mm: any = today.getMonth() + 1;

		const yyyy = today.getFullYear();
		if (dd < 10) {
			dd = '0' + dd;
		}
		if (mm < 10) {
			mm = '0' + mm;
		}
		today = dd + '/' + mm + '/' + yyyy;
		return today;
	}

	validForm(): boolean {
		return this.formStep1.valid && this.formStep2.valid && this.formStep3.valid && this.formStep4.valid && this.formStep5.valid && this.formStep6.valid && this.formStep7.valid;
	}

	getForm(tabIndex: number): FormGroup {
		if (tabIndex === 0) {
			return this.formStep1;
		} else if (tabIndex === 1) {
			return this.formStep2;
		} else if (tabIndex === 2) {
			return this.formStep3;
		} else if (tabIndex === 3) {
			return this.formStep4;
		} else if (tabIndex === 4) {
			return this.formStep5;
		} else if (tabIndex === 5) {
			return this.formStep6;
		} else if (tabIndex === 6) {
			return this.formStep7;
		}
		return this.formStep1;
	}

	checkFormValidity(form: any): void {
		for (const item in form.controls) {
			if (item) {
				form.controls[item].markAsTouched();
			}
		}
	}

	save(typeSaved): void {
		const form = this.getForm(this.tabSelected);
		this.checkFormValidity(form);
		if (!form.valid) {
			return;
		}

		const objectSave = {
			'file': {
				'file_number': `${this.formStep1.get('file_number').value}/${this.formStep1.get('year_file_number').value}`,
				'area_id': this.formStep1.get('area_id').value
			},
			'filesInternalControl1': this.formStep1.value,
			'filesVictimsData': this.formStep2.value,
			'filesParticipantVehicles': this.formStep3.value,
			'filesInformers': this.formStep4.value,
			'filesInternalControl2': this.formStep5.value,
			'filesAccuseds': this.formStep6.value,
			'filesAssurances': this.formStep7.value,
		};

		console.log(objectSave);

		this.saving = true;
		if (!this.editing) {
			this.expedientService.store(objectSave).subscribe((data: any) => {
				// Save step 1
				this.saving = false;
				this.deactivateSaving = '1';
				localStorage.setItem('redirect', 'true');
				this.router.navigate(['expedientes/editar/', data.id]);
			}, error => {
				this.saving = false;
				const message = error.error.message;
				this.deactivateSaving = '';
				this.snackBar.open(message, 'Ok', {
					duration: 2000
				});
			});
		} else {
			this.expedientService.update(objectSave, this.fileId).subscribe((data: any) => {
				this.saveImage(this.fileId, typeSaved);
				this.deleteImage();
			}, error => {
				this.saving = false;
				this.deactivateSaving = '';
				let errorMessage = error.message;
				switch (error.status) {
					case 406: errorMessage = 'No tienes permisos suficientes para actualizar'; break;
					case 404: errorMessage = 'El expediente no existe';
				}
				this.snackBar.open(errorMessage, 'Ok', {
					duration: 2000
				});
			});
		}
	}

	saveImage(id, typeSaved: number): void {
		const message = !this.editing ? 'Se ha creado correctamente el expediente' : 'Se ha actualizado correctamente el expediente ';
		if (this.files.length > 0) {
			this.progress = this.expedientService.saveImage(id, this.files);
			const allProgressObservable = [];
			for (const key in this.progress) {
				if (this.progress.hasOwnProperty(key)) {
					allProgressObservable.push(this.progress[key].progress);
				}
			}
			forkJoin(allProgressObservable).subscribe(end => {
				this.saving = false;
				if (typeSaved === 0) {
					this.deactivateSaving = '1';
					this.router.navigate(['expedientes']);
				} else if (typeSaved === 1) {
					this.init(typeSaved);
				} else if (typeSaved === 2) {
					this.init(typeSaved);
				}
				this.snackBar.open(message, 'Ok', {
					duration: 2000
				});
			});
		} else {
			this.saving = false;
			if (typeSaved === 0) {
				this.deactivateSaving = '1';
				this.router.navigate(['expedientes']);
			} else if (typeSaved === 1) {
				this.init(typeSaved);
			} else if (typeSaved === 2) {
				this.init(typeSaved);
			}
			this.snackBar.open(message, 'Ok', {
				duration: 2000
			});
		}
	}

	deleteImage(): void {
		if (this.filesRemove.length > 0) {
			this.filesRemove.forEach(element => {
				this.expedientService.delete(element.id).subscribe(data => { });
			});
		}
	}

	/* VALIDAR TABS*/

	changeTab(event): void {
		this.tabSelected = event;
	}

	checkDisabledTab(tabIndex: number): boolean {
		const form = this.getForm(tabIndex);
		if (!this.editing) {
			return true;
		}

		if (form.valid || this.editing) {
			return false;
		}

		return true;
	}

	previousTab(): void {
		this.tabSelected = this.tabSelected - 1;
	}

	public nextTab(): void {
		if (!this.editing) {
			const form = this.getForm(this.tabSelected);
			const id = this.route.snapshot.paramMap.get('fileId');
			this.checkFormValidity(form);

			if (form.valid) {
				this.save(0);
			}
		} else {
			this.tabSelected = this.tabSelected + 1;
		}
	}

	back(step: MatStepper): void {
		step.previous();
	}

	activateEditMethod(novalidate?: any): void {
		if (novalidate) {
			if (novalidate === 1) {
				return;
			} else if (novalidate === 2) {
				this.activeEdit = false;
				this.activeAllFields();
				return;
			}
		}
		if (this.activeEdit) {
			this.verifyFieldsChanged();
		} else {
			this.activeEdit = !this.activeEdit;
			this.activeAllFields();
		}
	}

	getImageEdit(): string {
		return !this.activeEdit ? 'assets/images/edit.png' : 'assets/images/cancel_edit.png';
	}

	showDelete(): boolean {
		if (!this.editing) {
			return true;
		} else if (this.editing && !this.activeEdit) {
			return false;
		} else {
			return true;
		}
	}

	formatDate(date: string): string {
		let d: any = date.split(' ')[0];
		d = d.split('-');
		return d[2] + '/' + d[1] + '/' + d[0];
	}

	public numberOnly(event: any): Boolean {
		const charCode = (event.which) ? event.which : event.keyCode;
		if (charCode > 31 && (charCode < 48 || charCode > 57)) {
			return false;
		}
		return true;
	}

	getVictimFullName(): string {

		const fullName = this.formStep2.controls.victim_name.value + ' ' + this.formStep2.controls.victim_lastname.value + ' ' + this.formStep2.controls.victim_mothers_lastname.value;

		return (fullName === '  ') ? '' : fullName;
	}

	getInformerFullName(): string {
		const fullName = `${this.formStep4.controls.informer_name.value} ${this.formStep4.controls.informer_lastname.value} ${this.formStep4.controls.informer_mothers_lastname.value}`;

		return (fullName === '  ') ? '' : fullName;
	}

	getAccusedFullName(index: number): string {
		const name = this.formStep6.controls.accuseds_list['controls'][index].controls.name.value;
		const lastname = this.formStep6.controls.accuseds_list['controls'][index].controls.lastname.value;
		const mothers_lastname = this.formStep6.controls.accuseds_list['controls'][index].controls.mothers_lastname.value;

		const fullName = name + ' ' + lastname + ' ' + mothers_lastname;

		return (fullName === '  ') ? '' : fullName;
	}

	getVictimFullAddress(): string {
		let entityName = '';
		let municipalityName = '';
		const localityName: string = this.formStep2.controls.victim_locality_reside.value;
		const colonyName: string = this.formStep2.controls.victim_colony_reside.value;
		const streetName: string = this.formStep2.controls.victim_street_reside.value;
		const exteriorNumber: string = this.formStep2.controls.victim_exterior_number_reside.value;
		const interiorNumber: string = this.formStep2.controls.victim_interior_number_reside.value;

		const entityObj = this.catalogs.federal_entities.find(entity => {
			return entity.id === this.formStep2.controls.victim_federal_entity_reside_id.value;
		});

		if (typeof entityObj === 'object') {
			entityName = (entityObj.name === this.value_field_other) ? this.formStep2.controls.victim_federal_entity_reside_observations.value : entityObj.name;
		}

		const municipalityObj = this.catalogs.municipalities.find(municipality => {
			return municipality.id === this.formStep2.controls.victim_municipality_reside_id.value;
		});

		if (typeof municipalityObj === 'object') {
			municipalityName = (municipalityObj.name === this.value_field_other) ? this.formStep2.controls.victim_municipality_reside_observations.value : municipalityObj.name;
		}

		return entityName + '. ' + municipalityName + '. ' + localityName + '. ' + colonyName + '. ' + streetName + '. ' + exteriorNumber + '. ' + interiorNumber + '.';
	}

	getVictimLastSightningFullAddress(): string {
		let countryName = '';
		let entityName = '';
		let municipalityName = '';
		const localityName: string = this.formStep2.controls.last_sighting_locality.value;
		const colonyName: string = this.formStep2.controls.last_sighting_colony.value;
		const streetName: string = this.formStep2.controls.last_sighting_street.value;

		const countryObj = this.catalogs.countries.find(country => {
			return country.id === this.formStep2.controls.last_sighting_country_id.value;
		});

		if (typeof countryObj === 'object') {
			countryName = (countryObj.name === this.value_field_other) ? this.formStep2.controls.last_sighting_country_observations.value : countryObj.name;
		}

		const entityObj = this.catalogs.federal_entities.find(entity => {
			return entity.id === this.formStep2.controls.last_sighting_federal_entity_id.value;
		});

		if (typeof entityObj === 'object') {
			entityName = (entityObj.name === this.value_field_other) ? this.formStep2.controls.last_sighting_federal_entity_observations.value : entityObj.name;
		}

		const municipalityObj = this.catalogs.municipalities.find(municipality => {
			return municipality.id === this.formStep2.controls.last_sighting_municipality_id.value;
		});

		if (typeof municipalityObj === 'object') {
			municipalityName = (municipalityObj.name === this.value_field_other) ? this.formStep2.controls.last_sighting_municipality_observations.value : municipalityObj.name;
		}

		return countryName + '. ' + entityName + '. ' + municipalityName + '. ' + localityName + '. ' + colonyName + '. ' + streetName + '.';
	}

	getInformerFullAddress(): string {
		let entityName = '';
		let municipalityName = '';
		const localityName: string = this.formStep4.controls.informer_resident_locality.value;
		const colonyName: string = this.formStep4.controls.informer_resident_colony.value;
		const streetName: string = this.formStep4.controls.informer_resident_street.value;
		const exteriorNumber: string = this.formStep4.controls.informer_resident_exterior_number.value;
		const interiorNumber: string = this.formStep4.controls.informer_resident_interior_number.value;

		const entityObj = this.catalogs.federal_entities.find(entity => {
			return entity.id === this.formStep4.controls.informer_resident_federal_entity_id.value;
		});

		if (typeof entityObj === 'object') {
			entityName = (entityObj.name === this.value_field_other) ? this.formStep4.controls.informer_resident_federal_entity_observations.value : entityObj.name;
		}

		const municipalityObj = this.catalogs.municipalities.find(municipality => {
			return municipality.id === this.formStep4.controls.informer_resident_municipality_id.value;
		});

		if (typeof municipalityObj === 'object') {
			municipalityName = (municipalityObj.name === this.value_field_other) ? this.formStep4.controls.informer_resident_municipality_observations.value : municipalityObj.name;
		}

		return entityName + '. ' + municipalityName + '. ' + localityName + '. ' + colonyName + '. ' + streetName + '. ' + exteriorNumber + '. ' + interiorNumber + '.';
	}

	onAddFormGroup(formGroup: any, form: any, fgFields: string, type: string): void {
		formGroup = <FormArray>form.get(fgFields);
		let newFormControl = {};

		switch (type) {
			case 'denture':
			case 'surgical_operation':
			case 'fracture':
			case 'particular_sign':
			case 'tattoo':
				newFormControl = {
					description: ['']
				};
				break;

			case 'suspicious_vehicle':
				newFormControl = {
					plate: [''],
					brand: [''],
					sub_brand: [''],
					model: [''],
					color: [''],
				};
				break;

			case 'accused':
				newFormControl = {
					name: [''],
					lastname: [''],
					mothers_lastname: [''],
					alias: [''],
					date_of_birth: [''],
					age_when_fact_id: [''],
					gender_id: ['']
				};
				break;

			default:
				break;
		}

		formGroup.push(this.formBuilder.group(newFormControl));
	}

	onDeleteFormGroup(index: number, form: any, fgFields: string): void {
		(<FormArray>form.get(fgFields)).removeAt(index);
	}

	onChangeRadio(event, form, fields): void {
		fields.forEach(field => {
			if (event.value === 0) {
				form.controls[field].patchValue('');
			}
		});
	}

	onChangeRadioDinamic(event, form, formChild, fields): void {
		form.get(formChild).controls.forEach(formControl => {
			fields.forEach(field => {
				if (event.value === 0) {
					formControl.controls[field].patchValue('');
				}
			});
		});
	}

	changeStatusFiles(event): void {
		this.formStep5.patchValue({
			date_of_low_file: '',
			localized_condition_id: '',
			localized_victim_date: '',
			justification_of_low_status: '',
			localized_country_id: '',
			localized_country_object: '',
			localized_country_observations: '',
			localized_federal_entity_id: '',
			localized_federal_entity_object: '',
			localized_federal_entity_observations: '',
			localized_municipality_id: '',
			localized_municipality_object: '',
			localized_municipality_observations: '',
			localized_locality_or_colony: ''
		});
	}

	selectedAutocomplete(event, form, field, fieldObservations): void {
		if (event.option.value) {
			form.get(field).patchValue(event.option.value.id);
			if (event.option.value.name !== 'OTRO') {
				form.get(fieldObservations).patchValue('');
			}
		}
	}

	private _filter(name: any, catalog): any {
		const filterValue = name.toLowerCase();
		return catalog.filter(option => option.name.toLowerCase().indexOf(filterValue) === 0);
	}

	displayFn(option?: any): string | undefined {
		return option ? option.name : undefined;
	}

	onBlurAutocomplete(event, form, field, fieldObject): void {
		if (event.target.value === '') {
			form.get(field).patchValue('');
			form.get(fieldObject).patchValue('');
		}
	}

	onBlurYear(event): void {
		if (parseInt(event.target.value, 10) < 1900 || parseInt(event.target.value, 10) > this.year) {
			this.formStep1.patchValue({
				year_file_number: this.year
			});
		}
	}

	get victim_tattoos(): any {
		return this.formStep2.get('victim_tattoos');
	}
	get victim_particular_signs(): any {
		return this.formStep2.get('victim_particular_signs');
	}
	get victim_fractures(): any {
		return this.formStep2.get('victim_fractures');
	}
	get victim_surgical_operations(): any {
		return this.formStep2.get('victim_surgical_operations');
	}
	get victim_denture_particularities(): any {
		return this.formStep2.get('victim_denture_particularities');
	}
	get victim_occupation_option(): any {
		return this.formStep2.get('victim_occupation_option');
	}
	get victim_nationality_id(): any {
		return this.formStep2.get('victim_nationality_id');
	}
	get victim_nationality_object(): any {
		return this.formStep2.get('victim_nationality_object');
	}
	get victim_federal_entity_reside_object(): any {
		return this.formStep2.get('victim_federal_entity_reside_object');
	}
	get victim_municipality_reside_object(): any {
		return this.formStep2.get('victim_municipality_reside_object');
	}
	get last_sighting_country_object(): any {
		return this.formStep2.get('last_sighting_country_object');
	}
	get last_sighting_federal_entity_object(): any {
		return this.formStep2.get('last_sighting_federal_entity_object');
	}
	get last_sighting_municipality_object(): any {
		return this.formStep2.get('last_sighting_municipality_object');
	}
	get suspicious_vehicles_list(): any {
		return this.formStep3.get('suspicious_vehicles_list');
	}
	get fact_vehiculo_victim(): any {
		return this.formStep3.get('fact_vehiculo_victim');
	}
	get suspicious_vehicles(): any {
		return this.formStep3.get('suspicious_vehicles');
	}
	get localized_victim_option(): any {
		return this.formStep5.get('localized_victim_option');
	}
	get localized_country_object(): any {
		return this.formStep5.get('localized_country_object');
	}
	get localized_federal_entity_object(): any {
		return this.formStep5.get('localized_federal_entity_object');
	}
	get localized_municipality_object(): any {
		return this.formStep5.get('localized_municipality_object');
	}
	get accuseds(): any {
		return this.formStep6.get('accuseds');
	}
	get accuseds_list(): any {
		return this.formStep6.get('accuseds_list');
	}
}
