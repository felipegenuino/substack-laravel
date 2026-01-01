<?php
require __DIR__.'/../vendor/autoload.php';
$app = require __DIR__.'/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$results = Illuminate\Support\Facades\DB::table('contents')->orderBy('id','desc')->limit(5)->get();
echo "count: ".Illuminate\Support\Facades\DB::table('contents')->count()."\n\n";
foreach($results as $row){
    echo $row->id." | ".$row->type." | ".$row->title." | ".substr($row->body,0,60)."\n";
}
