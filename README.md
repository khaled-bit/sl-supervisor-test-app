# Laravel Supervisor Test Application

A Laravel test application to verify the `sl-supervisor` package works correctly with your Supervisor instance.

## Features

- ✅ Test connection to remote Supervisor instances
- ✅ Retrieve Supervisor and API versions
- ✅ List all running processes
- ✅ Check process states
- ✅ Integration tests with PHPUnit

## Setup

### 1. Clone and Install

```bash
git clone https://github.com/khaled-bit/sl-supervisor-test-app.git
cd sl-supervisor-test-app
composer install
```

### 2. Configure Environment

Copy `.env.example` to `.env` and add your Supervisor credentials:

```bash
cp .env.example .env
```

Edit `.env` with your Supervisor details:

```env
SUPERVISOR_XMLRPC_ENDPOINT=http://192.168.1.39:9001/RPC2
SUPERVISOR_USERNAME=your_username
SUPERVISOR_PASSWORD=your_password
```

### 3. Quick Test (Artisan Command)

Run the test command to verify connection:

```bash
php artisan supervisor:test
```

**Output example:**
```
Testing Supervisor Connection...
✓ Connected to Supervisor!
Supervisor Version: 4.2.4
API Version: 3.0
State Code: 2
State Name: RUNNING

Running Processes:
  ✓ laravel-worker - RUNNING
  ✓ nginx - RUNNING
  ✗ redis - FATAL

All tests passed!
```

### 4. Run PHPUnit Tests

```bash
php vendor/bin/phpunit tests/
```

## Architecture

```
sl-supervisor-test-app/
├── bootstrap/
│   └── app.php                 # Laravel bootstrap
├── config/
│   ├── app.php
│   └── supervisor.php          # Supervisor configuration
├── routes/
│   └── console.php             # Artisan commands
├── tests/
│   └── Feature/
│       └── SupervisorConnectionTest.php
├── .env.example                # Environment template
├── composer.json
└── README.md
```

## Available Commands

### Test Connection

```bash
php artisan supervisor:test
```

Tests:
- Connection to Supervisor
- Supervisor and API versions
- Service state
- List all running processes

### Run Full Test Suite

```bash
php vendor/bin/phpunit
```

Tests verify:
- Connection to Supervisor
- Getting supervisor version
- Getting API version
- Getting supervisor state
- Retrieving all processes

## Troubleshooting

### Connection Failed

**Error:** `Could not connect to Supervisor at http://192.168.1.39:9001/RPC2`

**Solutions:**
1. Verify Supervisor is running: `supervisorctl status`
2. Check endpoint URL and port are correct
3. Verify username and password are correct
4. Check firewall allows connection from your machine to `192.168.1.39:9001`
5. Verify XML-RPC is enabled in `/etc/supervisor/supervisord.conf`:
   ```ini
   [inet_http_server]
   port=192.168.1.39:9001
   username=your_username
   password=your_password
   ```

### Authentication Failed

**Error:** `Authentication failed`

**Solutions:**
1. Verify credentials in `.env` match Supervisor config
2. Check Supervisor's `[rpcinterface:supervisor]` section
3. Verify `[unix_http_server]` or `[inet_http_server]` has correct credentials

## Next Steps

Once tests pass, you can:

1. **Extend tests** - Add more integration tests for your use cases
2. **Use in production** - Integrate the package into your main application
3. **Develop features** - Build upon the Supervisor integration

## References

- [Supervisor Documentation](http://supervisord.org/)
- [Supervisor XML-RPC API](http://supervisord.org/api.html)
- [sl-supervisor Package](https://github.com/RD-Softlock/sl-supervisor)
- [Laravel Documentation](https://laravel.com/docs)

## License

MIT
