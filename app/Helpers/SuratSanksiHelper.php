<?php

namespace App\Helpers;

use App\Models\Sanksi;

class SuratSanksiHelper
{
    public static function generateSuratSanksi($sanksi)
    {
        try {
            $pelanggaran = $sanksi->pelanggaran;
            $siswa = $pelanggaran->siswa;
            $jenisSanksi = $sanksi->jenisSanksi;
            
            // Create filename
            $filename = 'surat_sanksi_' . str_replace(' ', '_', $siswa->nama_siswa) . '_' . date('Y-m-d_H-i-s') . '.html';
            $filepath = storage_path('app/public/surat_sanksi/' . $filename);
            
            // Ensure directory exists
            if (!file_exists(dirname($filepath))) {
                mkdir(dirname($filepath), 0755, true);
            }
            
            // Generate HTML content
            $html = view('kesiswaan.export.surat-sanksi', compact('pelanggaran', 'siswa', 'jenisSanksi', 'sanksi'))->render();
            
            // Save HTML file
            file_put_contents($filepath, $html);
            
            \Log::info('Surat sanksi generated automatically for siswa: ' . $siswa->nama_siswa . ' - File: ' . $filename);
            
            return $filename;
            
        } catch (\Exception $e) {
            \Log::error('Failed to generate surat sanksi automatically: ' . $e->getMessage());
            return false;
        }
    }
}