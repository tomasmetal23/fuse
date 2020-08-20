<?php
namespace App\Services;

use App\Models\Area;
use App\Models\Direction;
use App\Models\FileInformer;
use App\Models\FileParticipantVehicleSuspicious;

use App\Models\FileInternalControl1;
use App\Models\FileVictimData;
use App\Models\FileParticipantVehicle;
use App\Models\FileInternalControl2;
use App\Models\FileAccused;
use App\Models\FileAssurance;

use App\Models\File;
use App\Models\FileVictimDentureParticularity;
use App\Models\FileVictimFracture;
use App\Models\FileVictimParticularSign;
use App\Models\FileVictimSurgicalOperation;
use App\Models\FileVictimTattoo;
use Illuminate\Database\Eloquent\Builder;
use \Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class FilesService
{
    public const KEY_FILES_INTERNAL_CONTROL_1 = 'filesInternalControl1';
    public const KEY_FILES_VICTIMS_DATA = 'filesVictimsData';
    public const KEY_FILES_PARTICIPANT_VEHICLES = 'filesParticipantVehicles';
    public const KEY_FILES_INFORMERS = 'filesInformers';
    public const KEY_FILES_INTERNAL_CONTROL_2 = 'filesInternalControl2';
    public const KEY_FILES_ACCUSEDS = 'filesAccuseds';
    public const KEY_FILES_ASSURANCES  = 'filesAssurances';
    public const KEY_FILES = 'file';

    public function __construct(){
    }
    /**
     * obtiene las columnas que se insertaran desde el formulario
     * @return array
     */
    public function getColumnsFiles() {
        $filesInternalControl1Columns = Schema::getColumnListing(FileInternalControl1::getTableName());
        $filesVictimsDataColumns = Schema::getColumnListing(FileVictimData::getTableName());
        $filesParticipantVehiclesColumns = Schema::getColumnListing(FileParticipantVehicle::getTableName());
        $filesInformersColumns = Schema::getColumnListing(FileInformer::getTableName());
        $filesInternalControl2Columns = Schema::getColumnListing(FileInternalControl2::getTableName());
        $filesAccusedsColumns = Schema::getColumnListing(FileAccused::getTableName());
        $filesAssurancesColumns = Schema::getColumnListing(FileAssurance::getTableName());

        $columns = [
            self::KEY_FILES_INTERNAL_CONTROL_1 => $filesInternalControl1Columns,
            self::KEY_FILES_VICTIMS_DATA => $filesVictimsDataColumns,
            self::KEY_FILES_PARTICIPANT_VEHICLES => $filesParticipantVehiclesColumns,
            self::KEY_FILES_INFORMERS => $filesInformersColumns,
            self::KEY_FILES_INTERNAL_CONTROL_2 => $filesInternalControl2Columns,
            self::KEY_FILES_ACCUSEDS => $filesAccusedsColumns,
            self::KEY_FILES_ASSURANCES  => $filesAssurancesColumns,
        ];
        $igonoredColumns = [
            'id','active','created_at','updated_at','file_id'
        ];
        foreach ($columns as $key => $groupColumns){
            foreach($groupColumns as $keyColumn => $column){
                if(in_array($column,$igonoredColumns)){
                    unset($columns[$key][$keyColumn]);
                }
            }
        }
        return $columns;
    }

    /**
     * crea un objeto file fake para hacer pruebas
     * @return array
     */
    public function createFakeFileObject(){
        $columns = $this->getColumnsFiles();
        $integerColumns = [
            'victim_mf_weight','victim_mf_height','take_documents_or_clothes','leave_document_or_message',
            'fact_have_strange_attitude_before_disappearance','fact_vehiculo_victim','suspicious_vehicles',
            'family_labor_social_religious_conflicts','domestic_violence','threats','credits_departments_debits_cards',
            'real_estate_properties','power_charges','criminal_records','smoking','alcohol','drugs','organized_crime',
            'informer_years','victim_year_or_mounth_when_fact'

        ];
        $dateColumns = [
            'dna_date_providing_sample','victim_birthdate','fact_date','fact_last_day_saw','informer_birthdate',
            'date_of_low_file'
        ];
        $specifictColumns = [
            'victim_mounth_or_year' => 'year'
        ];
        $record = [];
        foreach ($columns as $key => $groupColumns){
            foreach($groupColumns as $keyColumn => $column){
                $value = 'lorem itsu';
                if(str_contains($column,'_id') !== false){
                    $value = 1;
                }
                if(in_array($column,$integerColumns)){
                    $value = 23;
                }
                if(in_array($column,$dateColumns)){
                    $value = date('Y-m-d');
                }
                if( isset($specifictColumns[$column]) ){
                    $value = $specifictColumns[$column];
                }
                $record[$key][$column] = $value;
            }
        }
        return $record;
    }

    public function insert($params){
        $columns = $this->getColumnsFiles();

        $dataFile = [];

        if(!isset($params[self::KEY_FILES]['area_id']) || is_null($params[self::KEY_FILES]['area_id'])) {
            throw new \Exception('Error no tienes área asignada por lo que no es posible realizar la captura');
        }

        if(isset($params[self::KEY_FILES]['file_number'])){
            $dataFile = [
                'file_number' => strtoupper( $params[self::KEY_FILES]['file_number']),
                'area_id' =>  $params[self::KEY_FILES]['area_id']
            ];
        }

        foreach($columns[self::KEY_FILES_INTERNAL_CONTROL_1] as $column){
            if(isset($params[self::KEY_FILES_INTERNAL_CONTROL_1][$column])){
                $dataFileInternalControl1[$column] = strtoupper(trim($params[self::KEY_FILES_INTERNAL_CONTROL_1][$column]));
            }
        }

        $this->_processParams($dataFileInternalControl1);

        DB::beginTransaction();
        try{
            $file = File::create($dataFile);
            $dataFileInternalControl1['file_id'] = $file->id;
            /*STEP 1*/
            FileInternalControl1::create($dataFileInternalControl1);

            DB::commit();
            return $file;
        } catch(\Exception $exception){
            DB::rollback();
            throw new \Exception("Error al insertar el expediente, codigo de error:{$exception->getMessage()}");
            // throw new \Exception("Ocurrió un error al guardar el expediente");
        }
    }

    private function _processParams(&$params){
        $integerColumns = [
            'judicializable', 'victim_mf_weight', 'victim_mf_height','status_file_id', 'localized_place_option', 'victim_generic_identity_id', 'accused_gender_id',
            'victim_year_or_month_when_fact_id', 'victim_gender_id', 'victim_nationality_id', 'victim_occupation_option', 'victim_federal_entity_reside_id',
            'victim_municipality_reside_id', 'fact_vehiculo_victim', 'suspicious_vehicles', 'informer_gender_id', 'informer_kinship_id', 'informer_resident_federal_entity_id',
            'informer_resident_municipality_id', 'capture_agency_number_id', 'crime_final_classification_id', 'localized_victim_option'
        ];
        $dateColumns = [
            'fact_last_date_saw', 'date_of_low_file', 'localized_victim_date', 'victim_birthdate', 'informer_birthdate'
        ];

        foreach($params as $column => &$value){
            if(!is_array($value)) {
                if(trim($value) === ''){
                    if(str_contains($column,'_id') !== false){
                        $value = NULL;
                    }
                    if(in_array($column, $integerColumns) || in_array($column, $dateColumns) ){
                        $value = NULL;
                    }
                }
            }
        }
    }

    /**
     * get expedients files
     * @param Direction|null $direction
     * @param Area|null $area
     * @return Collection
     *
     */
    public function getFiles(Direction $direction = null, Area $area = null, Request $request) {
        $files = File::with(['fileInternalControl1.fileType', 'area.direction'])
            ->where( function($q) use($request, $direction, $area) {
                if(!is_null($direction)){
                    $areas = Area::where('direction_id','=',$direction->id)->get();
                    $areasId = [];
                    foreach($areas as $item){
                        $areasId[] = $item->id;
                    }
                    $q->whereIn('area_id',$areasId);
                } else if(!is_null($area)){
                    $q->where('area_id' ,$area->id);
                }
                return $q;
            })
            ->where( function($q) use($request) {
                $q->where('id', 'like', '%' . $request->search . '%')
                    ->orWhere('file_number', 'like', '%' . $request->search . '%')
                    ->orWhere('created_at', 'like', '%' . $request->search . '%')
                    ->orWhereHas('area', function(Builder $query) use($request) {
                        $query->where('name', 'ilike', '%'. $request->search .'%');
                    })
                    ->orWhereHas('area.direction', function(Builder $query) use($request) {
                        $query->where('name', 'ilike', '%'. $request->search .'%');
                    })
                    ->orWhereHas('fileInternalControl1.fileType', function(Builder $query) use($request) {
                        $query->where('name', 'ilike', '%'. $request->search .'%');
                    });
                return $q;
            });

        return $files->orderBy('id', 'DESC')->paginate(10)->onEachSide(2);
    }

    /**
     * Elimina logicamente un expediente junto con sus relaciones
     * @param File $file
     * @throws \Exception
     */
    public function delete(File $file){
        $fileContext = $file->fileContext()->first();
        $fileGeneral = $file->fileGeneral()->first();
        $fileFact = $file->fileFact()->first();
        $fileInformer = $file->fileInformer()->first();
        $fileVictim = $file->fileVictim()->first();
        $fileFactSuspisious = $fileFact->factSuspiciuos()->first();

        DB::beginTransaction();
        $dateUpdate = date('Y-m-d H:i:s');
        try{
            $fileFactSuspisious->active = 0;
            $fileFactSuspisious->updated_at = $dateUpdate;

            $fileFact->active = 0;
            $fileFact->updated_at = $dateUpdate;

            $fileVictim->active = 0;
            $fileVictim->updated_at = $dateUpdate;

            $fileInformer->active = 0;
            $fileInformer->updated_at = $dateUpdate;

            $fileContext->active = 0;
            $fileContext->updated_at = $dateUpdate;

            $fileGeneral->active = 0;
            $fileGeneral->updated_at = $dateUpdate;

            $file->active = 0;
            $file->updated_at = $dateUpdate;

            $fileFactSuspisious->save();
            $fileFact->save();
            $fileGeneral->save();
            $fileContext->save();
            $fileInformer->save();
            $fileVictim->save();
            $file->save();

            DB::commit();

        } catch(\Exception $exception){
            DB::rollback();
            throw new \Exception("Error al eliminar el expediente, codigo de error:{$exception->getMessage()}");
        }
    }

    /**
     * @param $params
     * @throws \Exception
     */
    public function update($params, $fileId){
        $columns = $this->getColumnsFiles();
        $dataFile = [];
        $dataFileInternalControl1 = [];
        $dataFileVictimData = [];
        $dataFileVictimDentureParticularities = [];
        $dataFileVictimSurgicalOperations = [];
        $dataFileVictimFractures = [];
        $dataFileVictimParticularSigns = [];
        $dataFileVictimTattoos = [];
        $dataFileParticipantVehicles = [];
        $dataFileInformer = [];
        $dataFileInternalControl2 = [];
        $dataFileAccuseds = [];
        $dataFileAssurance = [];

        if(!isset($params[self::KEY_FILES]['area_id']) || is_null($params[self::KEY_FILES]['area_id'])) {
            throw new \Exception('Error no tienes área asignada por lo que no es posible actualizar la captura');
        }

        $file = File::find($fileId);
        if(!$file){
            throw new \Exception('Error al actualizar el expediente, codigo de error: el id del expediente es inválido');
        }

        if(isset($params[self::KEY_FILES]['file_number'])){
            $dataFile = [
                'file_number' => strtoupper( $params[self::KEY_FILES]['file_number']),
                'area_id' =>  $params[self::KEY_FILES]['area_id'] ? $params[self::KEY_FILES]['area_id'] : NULL
            ];
        }

        foreach($columns[self::KEY_FILES_INTERNAL_CONTROL_1] as $column){
            if(isset($params[self::KEY_FILES_INTERNAL_CONTROL_1][$column])){
                $dataFileInternalControl1[$column] = strtoupper(trim($params[self::KEY_FILES_INTERNAL_CONTROL_1][$column]));
            }
        }

        foreach($columns[self::KEY_FILES_VICTIMS_DATA] as $column){
            if(isset($params[self::KEY_FILES_VICTIMS_DATA][$column])){
                if(!is_array($params[self::KEY_FILES_VICTIMS_DATA][$column])) {
                    $dataFileVictimData[$column] = strtoupper(trim($params[self::KEY_FILES_VICTIMS_DATA][$column]));
                }
            }
        }

        if(isset($params[self::KEY_FILES_VICTIMS_DATA]['victim_denture_particularities'])){
            if(count($params[self::KEY_FILES_VICTIMS_DATA]['victim_denture_particularities']) > 0) {
                $dataFileVictimDentureParticularities = $params[self::KEY_FILES_VICTIMS_DATA]['victim_denture_particularities'];
            }
        }

        if(isset($params[self::KEY_FILES_VICTIMS_DATA]['victim_surgical_operations'])){
            if(count($params[self::KEY_FILES_VICTIMS_DATA]['victim_surgical_operations']) > 0) {
                $dataFileVictimSurgicalOperations = $params[self::KEY_FILES_VICTIMS_DATA]['victim_surgical_operations'];
            }
        }

        if(isset($params[self::KEY_FILES_VICTIMS_DATA]['victim_fractures'])){
            if(count($params[self::KEY_FILES_VICTIMS_DATA]['victim_fractures']) > 0) {
                $dataFileVictimFractures = $params[self::KEY_FILES_VICTIMS_DATA]['victim_fractures'];
            }
        }

        if(isset($params[self::KEY_FILES_VICTIMS_DATA]['victim_particular_signs'])){
            if(count($params[self::KEY_FILES_VICTIMS_DATA]['victim_particular_signs']) > 0) {
                $dataFileVictimParticularSigns = $params[self::KEY_FILES_VICTIMS_DATA]['victim_particular_signs'];
            }
        }

        if(isset($params[self::KEY_FILES_VICTIMS_DATA]['victim_tattoos'])) {
            if (count($params[self::KEY_FILES_VICTIMS_DATA]['victim_tattoos']) > 0) {
                $dataFileVictimTattoos = $params[self::KEY_FILES_VICTIMS_DATA]['victim_tattoos'];
            }
        }

        foreach($columns[self::KEY_FILES_PARTICIPANT_VEHICLES] as $column){
            if(isset($params[self::KEY_FILES_PARTICIPANT_VEHICLES][$column])){
                if(!is_array($params[self::KEY_FILES_PARTICIPANT_VEHICLES][$column])) {
                    $dataFileParticipantVehicles[$column] = strtoupper(trim($params[self::KEY_FILES_PARTICIPANT_VEHICLES][$column]));
                }
            }
        }

        $dataFileSuspiciousVehiclesList = [];
        if(isset($params[self::KEY_FILES_PARTICIPANT_VEHICLES]['suspicious_vehicles_list'])){
            if(count($params[self::KEY_FILES_PARTICIPANT_VEHICLES]['suspicious_vehicles_list']) > 0) {
                foreach($params[self::KEY_FILES_PARTICIPANT_VEHICLES]['suspicious_vehicles_list'] as $param){
                    $dataFileSuspiciousVehiclesList[] = array(
                        'fact_suspicious_vehiculo_plate' => $param['plate'],
                        'fact_suspicious_vehiculo_brand' => $param['brand'],
                        'fact_suspicious_vehiculo_sub_brand' => $param['sub_brand'],
                        'fact_suspicious_vehiculo_model' => $param['model'],
                        'fact_suspicious_vehiculo_color' => $param['color']
                    );
                }
            }
        }

        foreach($columns[self::KEY_FILES_INFORMERS] as $column){
            if(isset($params[self::KEY_FILES_INFORMERS][$column])){
                if(!is_array($params[self::KEY_FILES_INFORMERS][$column])) {
                    $dataFileInformer[$column] = strtoupper(trim($params[self::KEY_FILES_INFORMERS][$column]));
                }
            }
        }

        if($params[self::KEY_FILES_ACCUSEDS]['accuseds']){
            if(isset($params[self::KEY_FILES_ACCUSEDS]['accuseds_list'])){
                if(count($params[self::KEY_FILES_ACCUSEDS]['accuseds_list']) > 0) {
                    foreach($params[self::KEY_FILES_ACCUSEDS]['accuseds_list'] as $param){
                        $dataFileAccuseds[] = array(
                            'accused_name' => $param['name'],
                            'accused_lastname' => $param['lastname'],
                            'accused_mothers_lastname' => $param['mothers_lastname'],
                            'accused_alias' => $param['alias'],
                            'accused_date_of_birth' => $param['date_of_birth'],
                            'accused_age_when_fact_id' => $param['age_when_fact_id'],
                            'accused_gender_id' => $param['gender_id']
                        );
                    }
                }
            }
        }

        foreach($columns[self::KEY_FILES_INTERNAL_CONTROL_2] as $column){
            if(isset($params[self::KEY_FILES_INTERNAL_CONTROL_2][$column])){
                $dataFileInternalControl2[$column] = strtoupper(trim($params[self::KEY_FILES_INTERNAL_CONTROL_2][$column]));
            }
        }

        foreach($columns[self::KEY_FILES_ACCUSEDS] as $column){
            if(isset($params[self::KEY_FILES_ACCUSEDS][$column])){
                if(!is_array($params[self::KEY_FILES_ACCUSEDS][$column])) {
                    $dataFileAccuseds[$column] = strtoupper(trim($params[self::KEY_FILES_ACCUSEDS][$column]));
                }
            }
        }

        foreach($columns[self::KEY_FILES_ASSURANCES] as $column){
            if(isset($params[self::KEY_FILES_ASSURANCES][$column])){
                $dataFileAssurance[$column] = strtoupper(trim($params[self::KEY_FILES_ASSURANCES][$column]));
            }
        }

        $this->_processParams($dataFileInternalControl1);
        $this->_processParams($dataFileVictimData);
        $this->_processParams($dataFileVictimDentureParticularities);
        $this->_processParams($dataFileVictimSurgicalOperations);
        $this->_processParams($dataFileVictimFractures);
        $this->_processParams($dataFileVictimParticularSigns);
        $this->_processParams($dataFileVictimTattoos);
        $this->_processParams($dataFileParticipantVehicles);
        $this->_processParams($dataFileInformer);
        $this->_processParams($dataFileInternalControl2);
        $this->_processParams($dataFileAccuseds);
        $this->_processParams($dataFileAssurance);

        DB::beginTransaction();
        $dateUpdate = date('Y-m-d H:i:s');
        try{
            /*STEP 1*/
            FileInternalControl1::where('file_id', $fileId)->update($dataFileInternalControl1);
            /*STEP 2*/
            $fileVictim = FileVictimData::where('file_id', $fileId)->first();
            if ($fileVictim) {
                $fileVictim->update($dataFileVictimData);
            } else {
                $dataFileVictimData['file_id'] = $file->id;
                $fileVictim = FileVictimData::create($dataFileVictimData);
            }
            FileVictimDentureParticularity::where('file_victim_id', $fileVictim->id)->update(['active' => 0]);
            foreach($dataFileVictimDentureParticularities as $dataItem){
                $dataItem['file_victim_id'] = $fileVictim->id;
                FileVictimDentureParticularity::create($dataItem);
            }
            FileVictimSurgicalOperation::where('file_victim_id', $fileVictim->id)->update(['active' => 0]);
            foreach($dataFileVictimSurgicalOperations as $dataItem){
                $dataItem['file_victim_id'] = $fileVictim->id;
                FileVictimSurgicalOperation::create($dataItem);
            }
            FileVictimFracture::where('file_victim_id', $fileVictim->id)->update(['active' => 0]);
            foreach($dataFileVictimFractures as $dataItem){
                $dataItem['file_victim_id'] = $fileVictim->id;
                FileVictimFracture::create($dataItem);
            }
            FileVictimParticularSign::where('file_victim_id', $fileVictim->id)->update(['active' => 0]);
            foreach($dataFileVictimParticularSigns as $dataItem){
                $dataItem['file_victim_id'] = $fileVictim->id;
                FileVictimParticularSign::create($dataItem);
            }
            FileVictimTattoo::where('file_victim_id', $fileVictim->id)->update(['active' => 0]);
            foreach($dataFileVictimTattoos as $dataItem){
                $dataItem['file_victim_id'] = $fileVictim->id;
                FileVictimTattoo::create($dataItem);
            }
            /*STEP 3*/
            $fileParticipantVehicle = FileParticipantVehicle::where('file_id', $fileId)->first();
            if ($fileParticipantVehicle) {
                $fileParticipantVehicle->update($dataFileParticipantVehicles);
            } else {
                $dataFileParticipantVehicles['file_id'] = $file->id;
                $fileParticipantVehicle = FileParticipantVehicle::create($dataFileParticipantVehicles);
            }
            FileParticipantVehicleSuspicious::where('vehicle_id', $fileParticipantVehicle->id)->update(['active' => 0]);
            foreach($dataFileSuspiciousVehiclesList as $dataItem){
                $dataItem['vehicle_id'] = $fileParticipantVehicle->id;
                FileParticipantVehicleSuspicious::create($dataItem);
            }
            /*STEP 4*/
            $fileInformer = FileInformer::where('file_id', $fileId)->first();
            if ($fileInformer) {
                $fileInformer->update($dataFileInformer);
            } else {
                $dataFileInformer['file_id'] = $file->id;
                FileInformer::create($dataFileInformer);
            }
            /*STEP 5*/
            $fileInternalControl2 = FileInternalControl2::where('file_id', $fileId)->first();
            if ($fileInternalControl2) {
                $fileInternalControl2->update($dataFileInternalControl2);
            } else {
                $dataFileInternalControl2['file_id'] = $file->id;
                FileInternalControl2::create($dataFileInternalControl2);
            }
            /*STEP 6*/
            FileAccused::where('file_id', $fileId)->update(['active' => 0]);
            foreach($dataFileAccuseds as $item){
                $dataItem = [
                    'file_id' => $fileId,
                    'accused_name' => $item['accused_name'],
                    'accused_lastname' => $item['accused_lastname'],
                    'accused_mothers_lastname' => $item['accused_mothers_lastname'],
                    'accused_alias' => $item['accused_alias'],
                    'accused_date_of_birth' => $item['accused_date_of_birth'],
                    'accused_age_when_fact_id' => $item['accused_age_when_fact_id'],
                    'accused_gender_id' => $item['accused_gender_id']

                ];
                FileAccused::create($dataItem);
            }
            /*STEP 7*/
            $fileAssurance = FileAssurance::where('file_id', $fileId)->first();
            if ($fileAssurance) {
                $fileAssurance->update($dataFileAssurance);
            } else {
                $dataFileAssurance['file_id'] = $file->id;
                FileAssurance::create($dataFileAssurance);
            }
            /*GENERAL*/
            File::where('id','=',$fileId)->update($dataFile);

            DB::commit();
            return $fileId;
        } catch(\Exception $exception){
            DB::rollback();
            throw new \Exception("Error al actualizar el expediente, codigo de error:{$exception->getMessage()}");
            // throw new \Exception("Ocurrió un error al guardar el expediente");
        }
    }
}