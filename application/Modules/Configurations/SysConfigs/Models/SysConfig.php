<?php

namespace Application\Modules\Configurations\SysConfigs\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SysConfig extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'number', 'description', 'configuration_status_id', 'configuration_category_id', 'configuration_type_id'
    ];

}
