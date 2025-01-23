<?php 

namespace App\Services\ApiResponse\Facades;
use Illuminate\Support\Facades\Facade;

class ApiResponse extends Facade {
    protected static function getFacadeAccessor(){
        return 'apiResponse';
    }
}