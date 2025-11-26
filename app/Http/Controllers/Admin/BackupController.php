<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BackupData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BackupController extends Controller
{
    public function index()
    {
        $backups = BackupData::latest('backup_date')->paginate(20);
        $backupStats = [
            'daily' => BackupData::where('type', 'daily')->count(),
            'weekly' => BackupData::where('type', 'weekly')->count(),
            'monthly' => BackupData::where('type', 'monthly')->count(),
            'total_size' => BackupData::sum('size'),
        ];
        return view('admin.backup.index', compact('backups', 'backupStats'));
    }

    public function backup(Request $request)
    {
        try {
            $type = $request->input('type', 'daily');
            $date = date('Ymd_His');
            $filename = "backup_{$type}_{$date}.sql";
            $filepath = storage_path("app/backups/{$filename}");
            
            if (!file_exists(storage_path('app/backups'))) {
                mkdir(storage_path('app/backups'), 0755, true);
            }
            
            // Get all tables
            $tables = \DB::select('SHOW TABLES');
            $dbName = env('DB_DATABASE');
            $sql = "-- Database Backup\n";
            $sql .= "-- Date: " . date('Y-m-d H:i:s') . "\n\n";
            
            foreach ($tables as $table) {
                $tableName = $table->{"Tables_in_{$dbName}"};
                
                // Get CREATE TABLE statement
                $createTable = \DB::select("SHOW CREATE TABLE `{$tableName}`");
                $sql .= "\n-- Table: {$tableName}\n";
                $sql .= "DROP TABLE IF EXISTS `{$tableName}`;\n";
                $sql .= $createTable[0]->{'Create Table'} . ";\n\n";
                
                // Get table data
                $rows = \DB::table($tableName)->get();
                if ($rows->count() > 0) {
                    $sql .= "INSERT INTO `{$tableName}` VALUES\n";
                    $values = [];
                    foreach ($rows as $row) {
                        $rowData = [];
                        foreach ($row as $value) {
                            if (is_null($value)) {
                                $rowData[] = 'NULL';
                            } else {
                                $rowData[] = "'" . addslashes($value) . "'";
                            }
                        }
                        $values[] = '(' . implode(',', $rowData) . ')';
                    }
                    $sql .= implode(",\n", $values) . ";\n\n";
                }
            }
            
            // Save SQL file
            file_put_contents($filepath, $sql);
            
            // Compress with gzip
            $gzFilepath = $filepath . '.gz';
            $gz = gzopen($gzFilepath, 'w9');
            gzwrite($gz, file_get_contents($filepath));
            gzclose($gz);
            unlink($filepath);
            
            BackupData::create([
                'filename' => basename($gzFilepath),
                'filepath' => $gzFilepath,
                'type' => $type,
                'size' => filesize($gzFilepath),
                'backup_date' => now(),
            ]);
            
            $this->cleanOldBackups();
            
            return redirect()->route('admin.backup.index')->with('success', 'Backup berhasil dibuat');
        } catch (\Exception $e) {
            return redirect()->route('admin.backup.index')->with('error', 'Backup gagal: ' . $e->getMessage());
        }
    }

    public function download($id)
    {
        $backup = BackupData::findOrFail($id);
        if (file_exists($backup->filepath)) {
            return response()->download($backup->filepath);
        }
        return redirect()->route('admin.backup.index')->with('error', 'File backup tidak ditemukan');
    }

    public function restore($id)
    {
        try {
            $backup = BackupData::findOrFail($id);
            
            if (!file_exists($backup->filepath)) {
                return redirect()->route('admin.backup.index')->with('error', 'File backup tidak ditemukan');
            }
            
            // Extract .gz file
            $sqlContent = gzdecode(file_get_contents($backup->filepath));
            
            // Disable foreign key checks
            \DB::statement('SET FOREIGN_KEY_CHECKS=0');
            
            // Execute SQL statements
            $statements = array_filter(array_map('trim', explode(';', $sqlContent)));
            foreach ($statements as $statement) {
                if (!empty($statement)) {
                    \DB::statement($statement);
                }
            }
            
            // Enable foreign key checks
            \DB::statement('SET FOREIGN_KEY_CHECKS=1');
            
            // Verification
            $tables = \DB::select('SHOW TABLES');
            $pelanggaranCount = \DB::table('pelanggaran')->count();
            
            return redirect()->route('admin.backup.index')
                ->with('success', "Database berhasil direstore! Total tables: " . count($tables) . ", Total pelanggaran: {$pelanggaranCount}");
                
        } catch (\Exception $e) {
            return redirect()->route('admin.backup.index')->with('error', 'Restore gagal: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $backup = BackupData::findOrFail($id);
        if (file_exists($backup->filepath)) {
            unlink($backup->filepath);
        }
        $backup->delete();
        return redirect()->route('admin.backup.index')->with('success', 'Backup berhasil dihapus');
    }

    private function cleanOldBackups()
    {
        $oldBackups = BackupData::where('backup_date', '<', now()->subDays(30))
            ->where('type', 'daily')
            ->get();
        
        foreach ($oldBackups as $backup) {
            if (file_exists($backup->filepath)) {
                unlink($backup->filepath);
            }
            $backup->delete();
        }
    }
}
