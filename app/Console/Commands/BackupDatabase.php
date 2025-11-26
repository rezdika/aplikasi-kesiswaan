<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;

class BackupDatabase extends Command
{
    protected $signature = 'backup:database';
    protected $description = 'Backup database harian otomatis';

    public function handle()
    {
        $filename = 'backup_' . Carbon::now()->format('Y-m-d_H-i-s') . '.sql';
        $path = storage_path('app/backups/' . $filename);
        
        if (!file_exists(storage_path('app/backups'))) {
            mkdir(storage_path('app/backups'), 0755, true);
        }

        $database = config('database.connections.mysql.database');
        $username = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');
        $host = config('database.connections.mysql.host');

        $command = "mysqldump --user={$username} --password={$password} --host={$host} {$database} > {$path}";
        
        exec($command, $output, $return);

        if ($return === 0) {
            $this->info("Backup berhasil: {$filename}");
            $this->cleanOldBackups();
        } else {
            $this->error("Backup gagal!");
        }
    }

    private function cleanOldBackups()
    {
        $files = glob(storage_path('app/backups/backup_*.sql'));
        
        foreach ($files as $file) {
            if (filemtime($file) < strtotime('-7 days')) {
                unlink($file);
                $this->info("Backup lama dihapus: " . basename($file));
            }
        }
    }
}