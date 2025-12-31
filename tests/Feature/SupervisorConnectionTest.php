<?php

namespace Tests\Feature;

use PHPUnit\Framework\TestCase;
use Supervisor\Supervisor;
use Supervisor\SupervisorServiceProvider;
use Illuminate\Foundation\Application;
use Illuminate\Config\Repository;
use Dotenv\Dotenv;

class SupervisorConnectionTest extends TestCase
{
    protected Supervisor $supervisor;
    
    protected function setUp(): void
    {
        parent::setUp();
        
        // Load .env file
        if (file_exists(dirname(__DIR__, 2) . '/.env')) {
            $dotenv = Dotenv::createImmutable(dirname(__DIR__, 2));
            $dotenv->load();
        }
        
        // Create a minimal Laravel container
        $app = new Application();
        
        // Load config from environment variables
        $endpoint = $_ENV['SUPERVISOR_XMLRPC_ENDPOINT'] ?? $_SERVER['SUPERVISOR_XMLRPC_ENDPOINT'] ?? 'http://127.0.0.1:9001/RPC2';
        $username = $_ENV['SUPERVISOR_USERNAME'] ?? $_SERVER['SUPERVISOR_USERNAME'] ?? null;
        $password = $_ENV['SUPERVISOR_PASSWORD'] ?? $_SERVER['SUPERVISOR_PASSWORD'] ?? null;
        
        $config = new Repository([
            'supervisor' => [
                'endpoint' => $endpoint,
                'username' => $username,
                'password' => $password,
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
