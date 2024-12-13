<?php

use App\Models\User;
use App\Models\Credit;
use App\Models\Document;
use App\Models\DocumentsLocal;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CreditController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\PlagiarismController;
use App\Http\Controllers\GoogleLoginController;
use App\Http\Controllers\DocumentsLocalController;
use App\Http\Controllers\RolePermissionController;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    $user = User::all();
    $usersWithUserRole = User::role('user')->get();
    $user1 = Auth::user();

    // Récupérer les documents appartenant à cet utilisateur
    $documents = Document::where('user_id', $user1->id)->get();
    $credits = Credit::where('user_id', $user1->id)->get();
    $data = User::selectRaw("date_format(created_at, '%Y-%m-%d') as date, count(*) as aggregate")
        ->whereHas('roles', function ($query) {
            $query->where('name', 'user'); // Filtrer par le rôle 'user'
        })
        ->whereDate('created_at', '>=', now()->subDays(30))
        ->groupBy('date')
        ->get();

    $documentsUploaded = Credit::selectRaw("date_format(created_at, '%Y-%m-%d') as date, sum(documents_uploaded) as aggregate")
        ->where('user_id', $user1) // Filtrer par l'utilisateur connecté
        ->whereDate('created_at', '>=', now()->subDays(30)) // Limiter aux 30 derniers jours
        ->groupBy('date')
        ->orderBy('date', 'asc') // Changez à 'asc' si vous souhaitez les dates du plus ancien au plus récent
        ->get();
    return view('dashboard', compact('user', 'usersWithUserRole', 'data', 'documents', 'credits', 'documentsUploaded'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/api/progress/{document}', [DocumentController::class, 'checkBatchProgress']);

    Route::get('/document/local/', [DocumentsLocalController::class, 'index'])->name('documents_local.index');
    Route::post('/document/local/create', [DocumentsLocalController::class, 'upload'])->name('documents_local.upload');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::get('/admin/roles-permissions', [RolePermissionController::class, 'index'])->name('admin.roles-permissions');
    Route::get('/users-roles', [RolePermissionController::class, 'getUsersRoles'])->name(name: 'roles.users.index');
    Route::post('/users/roles/update', [RolePermissionController::class, 'updateUserRole'])->name('users.roles.update');
    Route::post('/admin/roles-permissions/assign', action: [RolePermissionController::class, 'assignRole'])->name('admin.roles.assign');
    Route::post('/admin/roles-permissions/revoke', [RolePermissionController::class, 'revokeRole'])->name('admin.roles.revoke');

    Route::get('/credits/renouveler/{id}', [CreditController::class, 'showRenewalForm'])->name('credits.renouveler');
    Route::post('/credits/renouveler', [CreditController::class, 'renewCredits'])->name('credits.renouveler.submit');

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/plagiasme/results', [DocumentController::class, 'showResults'])->name('document.results');
    Route::get('/documents/upload', [DocumentController::class, 'create'])->name('documents.create');
    Route::get('/documents/show/{document}', [DocumentController::class, 'show'])->name('documents.show');

    Route::get('/documents/index', [DocumentController::class, 'index'])->name('documents.index');
    Route::get('/documents/{document}/detect-plagiarism', [PlagiarismController::class, 'detect'])->name('documents.detect-plagiarism');
    Route::post('/documents/upload', [DocumentController::class, 'upload'])->name('documents.upload');
});



Route::get('login/google', [GoogleLoginController::class, 'redirectToProvider'])->name('social.login');
Route::get('login/google/callback', [GoogleLoginController::class, 'handleProviderCallback']);






require __DIR__ . '/auth.php';