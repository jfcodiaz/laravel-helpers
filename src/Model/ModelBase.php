<?php
namespace DevTics\LaravelHelpers\Model;

use Illuminate\Database\Eloquent\Model;
class ModelBase extends Model {
    
    use \DevTics\LaravelHelpers\Model\traits\MethodsModelBase;
    protected $guarded = ['id'];    
    public $timestamps = false;
    
}
