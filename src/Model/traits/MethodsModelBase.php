<?php

    namespace DevTics\LaravelHelpers\Model\traits;

    trait MethodsModelBase {
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
            $obj = static::where("id", $id);
            $res = $obj->get();
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
            return static::where('id', $id)->with($relation)->get()->get(0)->getRelation($relation);
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
    
