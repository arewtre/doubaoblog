<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
class Adv extends Model{
    protected $table = 'ad_manage';
    protected $primaryKey = 'id';
    protected $guarded = [];
    
    function __construct() {
        //parent::__construct();
//        setLog("25235235","hot","hot");
//            $log = new Logger('register');
//            $log->pushHandler(new StreamHandler(storage_path('logs/hot'),Logger::INFO) );
//            $log->addInfo("hot".json_encode("35236236"));
        }
    
}
