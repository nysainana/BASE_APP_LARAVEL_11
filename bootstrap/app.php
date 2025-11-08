<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Response;
use Illuminate\Console\Scheduling\Schedule;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            \App\Http\Middleware\HandleInertiaRequests::class,
            \Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets::class,
        ]);

        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
            'permission.auto' => \App\Http\Middleware\CheckPermission::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {

        $exceptions->respond(function ($response) {
            $message = "Nous sommes désolés, une erreur technique s'est produite lors du traitement de votre demande. Merci de réessayer ultérieurement.";

            if(app()->environment('production') && $response->getStatusCode() === 500) {
                return back()->with("message.error", $message);
            }

            if($response->getStatusCode() === 404) {
                return back()->with("message.error", "La ressource demandée est introuvable.");
            }

            return $response;
        });
    })
    ->withSchedule(function (Schedule $schedule) {
        $schedule->command('absences:update-statut')->dailyAt('00:01');
        $schedule->command('employer:check-soldeconge')->dailyAt('00:02');
    })
    ->create();
