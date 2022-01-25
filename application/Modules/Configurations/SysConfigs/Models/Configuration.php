<?php

namespace Application\Modules\Configurations\SysConfigs\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Application\Modules\System\ConfigurationAmenities\Models\ConfigurationAmenity;
use Application\Modules\System\ConfigurationCategories\Models\ConfigurationCategory;
use Application\Modules\System\ConfigurationImages\Models\ConfigurationImage;
use Application\Modules\Configurations\SysConfigstatuses\Models\ConfigurationStatus;
use Application\Modules\System\ConfigurationTypes\Models\ConfigurationType;

class Configuration extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'number', 'description', 'configuration_status_id', 'configuration_category_id', 'configuration_type_id'
    ];

    public function configuration_status()
    {
        return $this->belongsTo(ConfigurationStatus::class);
    }

    public function configuration_amenities()
    {
        return $this->hasMany(ConfigurationAmenity::class);
    }

    public function configuration_category()
    {
        return $this->belongsTo(ConfigurationCategory::class);
    }

    public function configuration_type()
    {
        return $this->belongsTo(ConfigurationType::class);
    }

    public function configuration_images()
    {
        return $this->hasMany(ConfigurationImage::class);
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
    }
}
