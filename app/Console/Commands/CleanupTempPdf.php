<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class CleanupTempPdf extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pdf:cleanup-temp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cleanup temporary PDF files older than 1 hour';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $tempPath = storage_path('app/temp/pdf');
        
        if (!File::exists($tempPath)) {
            $this->info('No temp PDF directory found.');
            return 0;
        }

        $files = File::files($tempPath);
        $deletedCount = 0;
        $now = time();

        foreach ($files as $file) {
            $fileAge = $now - File::lastModified($file);
            
            if ($fileAge > 3600) {
                try {
                    File::delete($file);
                    $deletedCount++;
                } catch (\Exception $e) {
                    Log::warning('Failed to delete temp PDF: ' . $file->getFilename(), [
                        'error' => $e->getMessage()
                    ]);
                }
            }
        }

        $this->info("Cleaned up {$deletedCount} temporary PDF file(s).");
        Log::info("Cleaned up {$deletedCount} temporary PDF file(s).");

        return 0;
    }
}
