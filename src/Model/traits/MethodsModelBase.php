<?php

    namespace DevTics\LaravelHelpers\Model\traits;
    use Carbon\Carbon;
    
    trait MethodsModelBase {
        public function successMsjStore() {
            return "Success Store";
        }
        public function strDateToUTCDateTime($dateString) {
            if(is_string($dateString)) {
                $date = new \DateTime($dateString);
                $date->setTimezone(new \DateTimeZone("UTC"));
                return $date;
            }
            return $dateString;
        }
        public function datetimeFormat($attr){
            return Carbon::createFromFormat($this->dateFormat, $this->attributes[$attr])->toW3cString();
        }
        public static function getAllForDataTables() {
            return static::getAll();
        }
        public static function getAll($columns=['*']) {
            return static::get($columns);
        }

        public static function filtarRelaciones($arr) {
            if (is_array($arr)) {
                return array_intersect(static::$listaRelaciones, $arr);
            }
            $relaciones = filter_var($arr, FILTER_VALIDATE_BOOLEAN);
            if ($relaciones) {
                return static::$listaRelaciones;
            }
            return [];
        }

        public static function paginacion($n = false, $campos = ['*']) {
            $_n = $n ? $n : \Config::get('app.entidadesPorPagina');
            
            return static::paginate($_n, $campos ? $campos : ['*']);
        }

        public static function getById($id) {
            $query = static::where("id", $id);
            $whit = \Illuminate\Support\Facades\Input::get("with");
            if($whit){
                $relations = explode(",", $whit);
                foreach ($relations as $fnWith){
                    $query->with($fnWith);
                }
            }
            $res = $query->get();
            if ($res->count()) {
                return $res->get(0);
            }
            return null;
        }
        
        public static function getByIds($ids, $returnQuery = false) {
            $arrIds = (array)$ids;
            $query = static::whereIn('id', $arrIds);
            if($returnQuery) {
                return $returnQuery;
            }
            return $query->get();
        }
        
        public static function relation($id, $relation) {            
            $whit = \Illuminate\Support\Facades\Input::get("with");
            $query = static::where('id', $id)->with($relation);
            if($whit){
                $relations = explode(",", $whit);
                foreach ($relations as $fnWith){
                    $query->with($fnWith);
                }
            }
            return $query->get()->get(0)->getRelation($relation);
        }

        public static function getRandom($limit = false) {
            if ($limit) {
                $res = static::orderBy(\DB::raw('RAND()'))->limit($limit)->get();
                return $res;
            }
            $res = static::orderBy(\DB::raw('RAND()'))->limit(1)->get();
            if (count($res)) {
                return $res[0];
            }
            return false;
        }
        
    }
    
