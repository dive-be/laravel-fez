<?php

namespace Dive\Fez\Commands;

use Illuminate\Console\Command;

class InstallPackageCommand extends Command
{
    protected $description = 'Install fez.';

    protected $signature = 'fez:install';

    public function handle()
    {
        if ($this->isHidden()) {
            $this->error('🤚  Fez is already installed.');

            return 1;
        }

        $this->line('🏎  Installing fez...');
        $this->line('📑  Publishing configuration...');

        $this->call('vendor:publish', [
            '--provider' => "Dive\Fez\FezServiceProvider",
            '--tag' => 'config',
        ]);

        $this->line('📑  Publishing migration...');

        $this->call('vendor:publish', [
            '--provider' => "Dive\Fez\FezServiceProvider",
            '--tag' => 'migrations',
        ]);

        $this->info('🏁  Fez installed successfully!');
    }

    public function isHidden()
    {
        return file_exists(config_path('fez.php'));
    }
}
