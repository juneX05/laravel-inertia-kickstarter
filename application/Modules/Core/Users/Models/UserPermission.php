<?php

namespace Application\Modules\Core\Users\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPermission extends Model
{
    use HasFactory;

    protected $fillable = [
        'permission_name', 'status', 'user_id'
    ];
}
