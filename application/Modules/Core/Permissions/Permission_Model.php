<?php

namespace Application\Modules\Core\Permissions;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission_Model extends Model
{
    use HasFactory;

    protected $table = 'permissions';
    protected $fillable = [
        'name', 'title'
    ];

    public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }
}
