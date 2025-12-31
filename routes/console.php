<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Supervisor\Exception\SupervisorException;

Artisan::command('supervisor:test', function () {
    $this->info('Testing Supervisor Connection...');
    $this->line('Endpoint: ' . config('supervisor.endpoint'));
    $this->line('Username: ' . (config('supervisor.username') ? 'Set' : 'Not Set'));
    
    try {
        $supervisor = app(\Supervisor\Supervisor::class);
        
        // Try to get version directly instead of isConnected() to get the real error
        $version = $supervisor->getSupervisorVersion();
            
        $this->info('✓ Connected to Supervisor!');
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
                $status = $process->isRunning() ? '✓' : '✗';
                $stateName = $process->getState()->name;  // Get enum name (Running, Stopped, etc.)
                $this->line("  {$status} {$process->getName()} - {$stateName}");
            }
        }
        
        $this->newLine();
        $this->info('All tests passed!');

    } catch (\Exception $e) {
        $this->error('✗ Connection Failed!');
        $this->error('Error Type: ' . get_class($e));
        $this->error('Message: ' . $e->getMessage());
        
        if ($e instanceof \fXmlRpc\Exception\HttpException) {
            $this->line('Response Code: ' . $e->getCode());
            if ($e->getCode() == 401) {
                $this->error('👉 Authentication Failed. Check your username and password.');
            }
        }
    }
})->describe('Test connection to Supervisor instance');
