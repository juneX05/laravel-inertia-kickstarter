<?php

namespace Application\Modules\Core\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPermission_Model extends Model
{
    use HasFactory;

    protected $table = 'user_permissions';
    protected $fillable = [
        'permission_name', 'status', 'user_id'
    ];
}
