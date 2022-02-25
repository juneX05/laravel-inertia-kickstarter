<?php

namespace Application\Modules\Configurations\SysConfigs;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SysConfig_Model extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'number', 'description', 'configuration_status_id', 'configuration_category_id', 'configuration_type_id'
    ];

}
