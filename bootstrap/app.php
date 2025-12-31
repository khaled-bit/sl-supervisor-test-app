<?php

use Illuminate\Foundation\Application;

return Application::configure(dirname(__DIR__))
    ->withBasePath(dirname(__DIR__))
    ->withBootPath(dirname(__DIR__).'/bootstrap')
    ->withConfigPath(dirname(__DIR__).'/config')
    ->withDatabasePath(dirname(__DIR__).'/database')
    ->withLanguagePath(dirname(__DIR__).'/resources/lang')
    ->withPublicPath(dirname(__DIR__).'/public')
    ->withStoragePath(dirname(__DIR__).'/storage')
    ->withRoutesPath(dirname(__DIR__).'/routes')
    ->withEnvironmentPath(dirname(__DIR__))
    ->withEnvironmentFile('.env')
    ->withProviders([
        Illuminate\Auth\AuthServiceProvider::class,
        Illuminate\Broadcasting\BroadcastServiceProvider::class,
        Illuminate\Bus\BusServiceProvider::class,
        Illuminate\Cache\CacheServiceProvider::class,
        Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
        Illuminate\Cookie\CookieServiceProvider::class,
        Illuminate\Database\DatabaseServiceProvider::class,
        Illuminate\Encryption\EncryptionServiceProvider::class,
        Illuminate\Filesystem\FilesystemServiceProvider::class,
        Illuminate\Foundation\Providers\FoundationServiceProvider::class,
        Illuminate\Hashing\HashServiceProvider::class,
        Illuminate\Mail\MailServiceProvider::class,
        Illuminate\Notifications\NotificationServiceProvider::class,
        Illuminate\Pagination\PaginationServiceProvider::class,
        Illuminate\Pipeline\PipelineServiceProvider::class,
        Illuminate\Queue\QueueServiceProvider::class,
        Illuminate\Redis\RedisServiceProvider::class,
        Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
        Illuminate\Session\SessionServiceProvider::class,
        Illuminate\Translation\TranslationServiceProvider::class,
        Illuminate\Validation\ValidationServiceProvider::class,
        Illuminate\View\ViewServiceProvider::class,
        Supervisor\SupervisorServiceProvider::class,
    ])
    ->withAliases([
        'Supervisor' => Supervisor\Facades\Supervisor::class,
    ])
    ->create();
