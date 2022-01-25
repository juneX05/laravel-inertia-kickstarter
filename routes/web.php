<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use \Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/generate', function () {
    $name = Str::ucfirst('Payment  Type   Status');
    $name = Str::remove(' ', $name);
    echo 'slug:' . Str::kebab($name) . "<br/>";
    echo 'name:' . Str::singular($name) . "<br/>";
    echo 'name_plural:' . Str::plural($name) . "<br/>";
    echo 'name_plural:' . Str::plural($name) . "<br/>";
    dd();

    $data = [];
    $data['moduleType'] = 'System';
    $data['moduleName'] = 'Payments';
    $data['moduleNamePlural'] = 'Payments';
    $data['moduleNameSingular'] = 'Payment';
    $data['moduleNamePluralLower'] = 'payments';
    $data['moduleNameSingularLower'] = 'payment';
    $data['moduleNameSlug'] = 'payments';
    $data['moduleIcon'] = 'mdi-tag';
    $data['relations'] = [
        ['type' => 'belongs_to', 'module' => 'PaymentTypes'],
        ['type' => 'belongs_to', 'module' => 'PaymentStatuses'],
    ];

    $data['columns'] = [
        [
            'display_name' => 'Channel',
            'in_form' => true,
            'name' => 'channel',
            'type' => 'string',
            'size' => 40,
            'not_null' => true,
            'default' => null,
            'unique' => false,
        ],
        [
            'display_name' => 'Payment Type',
            'in_form' => true,
            'name' => 'payment_type_id',
            'type' => 'integer',
            'size' => null,
            'not_null' => true,
            'default' => null,
            'unique' => false,
        ],
        [
            'display_name' => 'Receipt Number',
            'in_form' => true,
            'name' => 'receipt_number',
            'type' => 'string',
            'size' => 150,
            'not_null' => true,
            'default' => null,
            'unique' => true,
        ],
        [
            'display_name' => 'Date Paid',
            'in_form' => true,
            'name' => 'date_paid',
            'type' => 'date',
            'size' => null,
            'not_null' => true,
            'default' => null,
            'unique' => false,
        ],
        [
            'display_name' => 'Time Paid',
            'in_form' => true,
            'name' => 'time_paid',
            'type' => 'time',
            'size' => null,
            'not_null' => true,
            'default' => null,
            'unique' => false,
        ],
        [
            'display_name' => 'Amount Paid',
            'in_form' => true,
            'name' => 'amount_paid',
            'type' => 'float',
            'size' => null,
            'not_null' => true,
            'default' => null,
            'unique' => false,
        ],
        [
            'display_name' => 'Payment Status',
            'in_form' => false,
            'name' => 'payment_status_id',
            'type' => 'integer',
            'size' => null,
            'not_null' => true,
            'default' => null,
            'unique' => false,
        ]
    ];

    $moduleGenerator = new \Application\Generator\ModuleGenerator($data);
});

//Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//    return Inertia::render('Dashboard');
//})->name('dashboard');
