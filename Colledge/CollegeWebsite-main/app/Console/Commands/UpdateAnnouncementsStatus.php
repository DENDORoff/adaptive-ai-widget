<?php

namespace App\Console\Commands;

use App\Models\YouthAnnouncement;
use Illuminate\Console\Command;

class UpdateAnnouncementsStatus extends Command
{
    protected $signature = 'announcements:update-status';
    protected $description = 'Update announcements status based on published_at and expires_at';

    public function handle()
    {
        $this->info('Обновление статусов объявлений...');
        
        // Все объявления
        $announcements = YouthAnnouncement::all();
        $updated = 0;
        
        foreach ($announcements as $announcement) {
            $originalStatus = $announcement->is_published;
            $announcement->updateStatus();
            
            if ($originalStatus != $announcement->is_published) {
                $updated++;
                $action = $announcement->is_published ? 'ОПУБЛИКОВАНО' : 'СКРЫТО';
                $this->line("{$action}: {$announcement->title}");
            }
        }
        
        $this->info("Обновлено {$updated} объявлений из {$announcements->count()}");
        
        return 0;
    }
}