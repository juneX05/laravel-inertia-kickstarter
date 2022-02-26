<?php

namespace Application\Modules\Configurations\SysConfigs\Tabs\Currencies;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency_Model extends Model
{
    use HasFactory;

    protected $table = 'currencies';

    protected $fillable = [
        'name', 'symbol', 'abbreviation', 'base', 'rate'
    ];

    public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }
}
