<?php

namespace Application\Modules\Configurations\DevConfigs\Tabs\Statuses;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status_Model extends Model
{
    use HasFactory;

    protected $table = 'statuses';
    protected $fillable = [
        'name', 'id', 'color',
    ];

    public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }
}
