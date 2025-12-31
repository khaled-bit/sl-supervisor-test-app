<?php

namespace Tests\Feature;

use PHPUnit\Framework\TestCase;
use Supervisor\Supervisor;
use Supervisor\SupervisorServiceProvider;
use Illuminate\Foundation\Application;
use Illuminate\Config\Repository;

class SupervisorConnectionTest extends TestCase
{
    protected Supervisor $supervisor;
    
    protected function setUp(): void
    {
        parent::setUp();
        
        // Create a minimal Laravel container
        $app = new Application();
        
        // Load config from .env
        $config = new Repository([
            'supervisor' => [
                'endpoint' => env('SUPERVISOR_XMLRPC_ENDPOINT', 'http://127.0.0.1:9001/RPC2'),
                'username' => env('SUPERVISOR_USERNAME'),
                'password' => env('SUPERVISOR_PASSWORD'),
            ]
        ]);
        
        $app->instance('config', $config);
        $app->singleton('log', function () {
            return new \Psr\Log\NullLogger();
        });
        
        // Register the supervisor service provider
        $provider = new SupervisorServiceProvider($app);
        $provider->packageRegistered();
        
        $this->supervisor = $app->make(Supervisor::class);
    }
    
    public function test_can_connect_to_supervisor(): void
    {
        $this->assertTrue($this->supervisor->isConnected(), 'Failed to connect to Supervisor');
    }
    
    public function test_can_get_supervisor_version(): void
    {
        $version = $this->supervisor->getSupervisorVersion();
        $this->assertNotEmpty($version);
    }
    
    public function test_can_get_api_version(): void
    {
        $apiVersion = $this->supervisor->getAPIVersion();
        $this->assertNotEmpty($apiVersion);
    }
    
    public function test_can_get_supervisor_state(): void
    {
        $state = $this->supervisor->getState();
        $this->assertArrayHasKey('statecode', $state);
        $this->assertArrayHasKey('statename', $state);
    }
    
    public function test_can_get_all_processes(): void
    {
        $processes = $this->supervisor->getAllProcesses();
        $this->assertIsArray($processes);
    }
}
