<?php

declare(strict_types=1);

namespace Runtime\Swoole\Tests\Unit;

use Illuminate\Contracts\Http\Kernel;
use PHPUnit\Framework\TestCase;
use Runtime\Swoole\LaravelRunner;
use Runtime\Swoole\ServerFactory;
use Swoole\Http\Request;
use Swoole\Http\Response;
use Swoole\Http\Server;

class LaravelRunnerTest extends TestCase
{
    public function testRun(): void
    {
        $application = $this->createMock(Kernel::class);

        $server = $this->createMock(Server::class);
        $server->expects(self::once())->method('start');

        $factory = $this->createMock(ServerFactory::class);
        $factory->expects(self::once())->method('createServer')->willReturn($server);

        $runner = new LaravelRunner($factory, $application);

        self::assertSame(0, $runner->run());
    }

    public function testHandle(): void
    {
        $application = $this->createMock(Kernel::class);
        $application->expects(self::once())->method('handle');

        $factory = $this->createMock(ServerFactory::class);
        $request = $this->createMock(Request::class);
        $response = $this->createMock(Response::class);

        $runner = new LaravelRunner($factory, $application);
        $runner->handle($request, $response);
    }
}
