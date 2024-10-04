<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\PlagiarismController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CreditController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\GoogleLoginController;
use App\Models\User;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $user = User::all();
    $usersWithUserRole = User::role('user')->get();
    $data = User::selectRaw("date_format(created_at, '%Y-%m-%d') as date, count(*) as aggregate")
        ->whereHas('roles', function ($query) {
            $query->where('name', 'user'); // Filtrer par le rôle 'user'
        })
        ->whereDate('created_at', '>=', now()->subDays(30))
        ->groupBy('date')
        ->get();
    return view('dashboard', compact('user', 'usersWithUserRole', 'data'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('login/google', [GoogleLoginController::class, 'redirectToProvider'])->name('social.login');
Route::get('login/google/callback', [GoogleLoginController::class, 'handleProviderCallback']);
Route::get('/admin/roles-permissions', [RolePermissionController::class, 'index'])->name('admin.roles-permissions');
Route::post('/admin/roles-permissions/assign', [RolePermissionController::class, 'assignRole'])->name('admin.roles.assign');
Route::post('/admin/roles-permissions/revoke', [RolePermissionController::class, 'revokeRole'])->name('admin.roles.revoke');
Route::get('/credits/renouveler/{id}', [CreditController::class, 'showRenewalForm'])->name('credits.renouveler');
Route::post('/credits/renouveler', [CreditController::class, 'renewCredits'])->name('credits.renouveler.submit');
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/plagiasme/results', [DocumentController::class, 'showResults'])->name('document.results');
Route::get('/documents/upload', [DocumentController::class, 'create'])->name('documents.create');
Route::get('/documents/show', [DocumentController::class, 'show'])->name('documents.show');
Route::get('/documents/index', [DocumentController::class, 'index'])->name('documents.index');
Route::get('/documents/{document}/detect-plagiarism', [PlagiarismController::class, 'detect'])->name('documents.detect-plagiarism');
Route::post('/documents/upload', [DocumentController::class, 'upload'])->name('documents.upload');




require __DIR__ . '/auth.php';
