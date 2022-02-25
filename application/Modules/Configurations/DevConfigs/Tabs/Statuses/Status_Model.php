<?php

namespace Application\Modules\Configurations\DevConfigs\Tabs\Statuses;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status_Model extends Model
{
    use HasFactory;

    protected $table = 'statuses';
    protected $fillable = [
        'name', 'symbol', 'abbreviation', 'base', 'rate'
    ];

    public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }
}
