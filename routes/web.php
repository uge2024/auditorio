<?php

use App\Http\Livewire\Calendar;
use App\Http\Livewire\Dashboard;
use App\Http\Livewire\ResetPassword;
use App\Http\Livewire\ForgotPassword;
use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\Profile;
use App\Http\Livewire\Auth\Register;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Users;
use App\Http\Livewire\CreateSolicitud;
use App\Http\Livewire\CreateSolicitudUser;
use App\Http\Livewire\Equipos;
use App\Http\Livewire\AuditorioComponent;
use App\Http\Livewire\Logout;
use App\Http\Livewire\CalendarUser;
use App\Http\Livewire\Reportes;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Livewire\Notifications;
use App\Models\Solicitud;
use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/', '/login');

// Rutas públicas (sin autenticación)
Route::get('/register', Register::class)->name('register');
Route::get('/login', Login::class)->name('login');
Route::get('/forgot-password', ForgotPassword::class)->name('forgot-password');
Route::get('/reset-password/{id}', ResetPassword::class)->name('reset-password')->middleware('signed');
Route::get('/logout', Logout::class)->name('logout');
// Rutas protegidas por autenticación
Route::middleware('auth')->group(function () {
    // Rutas accesibles para todos los usuarios autenticados
    Route::get('/profile', Profile::class)->name('profile');
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/create-solicitud-user', CreateSolicitudUser::class)->name('create-solicitud-user');
    Route::get('/calendar-user', CalendarUser::class)->name('calendar-user');
    Route::get('/notifications', Notifications::class)->name('notifications');
    // Rutas accesibles solo para administradores
    Route::middleware('userType:admin')->group(function () {
        Route::get('/users', Users::class)->name('users');
        Route::get('/equipos', Equipos::class)->name('equipos');
        Route::get('/auditorio-component', AuditorioComponent::class)->name('auditorio-component');
        Route::get('/create-solicitud', CreateSolicitud::class)->name('create-solicitud');
        Route::get('/calendar', Calendar::class)->name('calendar');
        Route::get('/reportes', Reportes::class)->name('reportes');
        // Exportar a PDF
        Route::get('/reportes/pdf', function () {
            $today = Carbon::today();
            $reportes = Solicitud::whereDate('fecha_uso', $today)->get();
            return Pdf::loadView('pdf.reportes', ['reportes' => $reportes])->download('reporte_diario.pdf');
        })->name('reportes.pdf');
    });
});

/*
|--------------------------------------------------------------------------
| comados de prueba
|--------------------------------------------------------------------------
|composer install
|php artisan migrate
|php artisan solicitud:update-estado
|* * * * * php /ruta/a/tu/proyecto/artisan schedule:run >> /dev/null 2>&1
|composer show dompdf/dompdf
|composer show barryvdh/laravel-dompdf
composer require intervention/image
php artisan storage:link
php artisan optimize:clear
*/
