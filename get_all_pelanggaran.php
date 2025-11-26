<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$data = DB::table('jenis_pelanggaran')->orderBy('id')->get();
echo "Total: " . $data->count() . " data\n\n";
foreach($data as $row) {
    echo $row->id . "|" . $row->nama_pelanggaran . "|" . $row->poin . "|" . $row->kategori . "\n";
}
