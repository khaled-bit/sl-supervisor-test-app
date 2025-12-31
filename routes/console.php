<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('supervisor:test', function () {
    $this->info('Testing Supervisor Connection...');
    
    try {
        $supervisor = app(\Supervisor\Supervisor::class);
        
        if ($supervisor->isConnected()) {
            $this->info('✓ Connected to Supervisor!');
            
            // Get supervisor version
            $version = $supervisor->getSupervisorVersion();
            $this->line("Supervisor Version: <comment>{$version}</comment>");
            
            // Get API version
            $apiVersion = $supervisor->getAPIVersion();
            $this->line("API Version: <comment>{$apiVersion}</comment>");
            
            // Get supervisor state
            $state = $supervisor->getState();
            $this->line("State Code: <comment>{$state['statecode']}</comment>");
            $this->line("State Name: <comment>{$state['statename']}</comment>");
            
            // List all processes
            $this->newLine();
            $this->info('Running Processes:');
            $processes = $supervisor->getAllProcesses();
            
            if (empty($processes)) {
                $this->line('<warn>No processes found</warn>');
            } else {
                foreach ($processes as $process) {
                    $status = $process->getState() ? '✓' : '✗';
                    $this->line("  {$status} {$process->getName()} - {$process->getStateName()}");
                }
            }
            
            $this->newLine();
            $this->info('All tests passed!');
        } else {
            $this->error('✗ Could not connect to Supervisor at ' . config('supervisor.endpoint'));
            $this->line('Please check your .env configuration.');
        }
    } catch (\Exception $e) {
        $this->error('Error: ' . $e->getMessage());
    }
})->describe('Test connection to Supervisor instance');
