<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ProjectInitialize extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'project:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Project Initialization';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Pastikan folder livewire-tmp ada untuk upload file
        $livewireTmp = storage_path('app/livewire-tmp');
        if (! is_dir($livewireTmp)) {
            mkdir($livewireTmp, 0775, true);
        }

        $this->call('migrate:fresh', [
            '--force' => true,
        ]);
        $this->call('shield:generate', [
            '--all' => true,
            '--panel' => 'admin',
        ]);
        $this->call('db:seed', [
            '--force' => true,
        ]);

        $this->call('filament:optimize-clear');
        $this->call('optimize:clear');
    }
}
