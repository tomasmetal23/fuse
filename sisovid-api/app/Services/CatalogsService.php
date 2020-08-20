<?php


namespace App\Services;


use Illuminate\Support\Facades\DB;

class CatalogsService
{
    private $catalogs = null;

    public function __construct()
    {
        $this->_fillCatalogs();
    }

    private function _fillCatalogs(){
        $this->catalogs = [
            'crimes',
            'federal_entities',
            'corporations',
            'status_files',
            'dna_kinships',
            'dna_samples_types',
            'dna_dependencies',
            'file_types',
            'regions',
            'municipalities',
            'capture_agency_numbers',
            'appointments',
            'localized_conditions',
            'localized_conditions_details',
            'adn_samples',
            'migratory_status',
            'genders',
            'generic_identities',
            'vulnerability_conditions',
            'economic_dependents_number',
            'family_nucleus_numbers',
            'civil_status',
            'educational_degree',
            'occupation_condition',
            'religions',
            'complexions',
            'shapes_face',
            'eyes_colors',
            'eyes_types',
            'skins',
            'hair_shapes',
            'hair_sizes',
            'ears_shapes',
            'chin_shapes',
            'nose_sizes',
            'nose_types',
            'front_shapes',
            'eyebrows_shapes',
            'mouth_sizes',
            'lips_thickness',
            'beard_features',
            'moustache_shapes',
            'telephone_company',
            'personal_accreditations',
            'fact_types',
            'vehiculos_types',
            'kinships',
            'catalogs_accompanied_disappeared',
            'infomer_interpreters',
            'fe_districts',
            'reception_vias',
            'nationalities',
            'countries',
            'ages'
        ];
    }

    public function getInitCatalogs(){
        $mainRecords = [];
        foreach ($this->catalogs as $catalog){
            $data = DB::table($catalog)->where('active','=',1)->get();
            $mainRecords[$catalog] = $data;
        }
        return $mainRecords;
    }

}