<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HackathonController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\AdminController;

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

Route::get('/', [HomeController::class, 'index'])->name('home');

// Auth routes
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes
Route::middleware(['auth'])->group(function () {
    // Profile routes
    Route::get('/profile', function () {
        return view('profile');
    })->name('profile');

    Route::get('/profile/edit', function () {
        return view('profile.edit');
    })->name('profile.edit');

    Route::put('/profile', function (\Illuminate\Http\Request $request) {
        $user = auth()->user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'avatar' => 'nullable|image|mimes:jpeg,png,gif|max:2048',
            'current_password' => 'required_with:password|current_password',
            'password' => 'nullable|min:8|confirmed',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar_url = $path;
        }

        if (!empty($validated['password'])) {
            $user->password = bcrypt($validated['password']);
        }

        $user->save();

        return redirect()->route('profile')
            ->with('success', 'Profile updated successfully!');
    })->name('profile.update');

    // Application routes
    Route::get('/applications', [ApplicationController::class, 'index'])->name('applications');
    Route::get('/applications/create', [ApplicationController::class, 'create'])->name('applications.create');
    Route::post('/applications', [ApplicationController::class, 'store'])->name('applications.store');
    Route::get('/applications/{application}', [ApplicationController::class, 'show'])->name('applications.show');
    Route::put('/applications/{application}', [ApplicationController::class, 'update'])->name('applications.update');
    Route::post('/applications/{application}/check-in', [ApplicationController::class, 'checkIn'])->name('applications.check-in');
    Route::put('/applications/{application}/approve', [ApplicationController::class, 'approve'])->name('applications.approve');
    Route::put('/applications/{application}/reject', [ApplicationController::class, 'reject'])->name('applications.reject');

    // Team routes
    Route::get('/teams', [TeamController::class, 'index'])->name('teams');
    Route::get('/teams/create', [TeamController::class, 'create'])->name('teams.create');
    Route::post('/teams', [TeamController::class, 'store'])->name('teams.store');
    Route::get('/teams/{team}', [TeamController::class, 'show'])->name('teams.show');
    Route::get('/teams/{team}/edit', [TeamController::class, 'edit'])->name('teams.edit');
    Route::put('/teams/{team}', [TeamController::class, 'update'])->name('teams.update');
    Route::delete('/teams/{team}', [TeamController::class, 'destroy'])->name('teams.destroy');
    Route::post('/teams/{team}/join', [TeamController::class, 'join'])->name('teams.join');
    Route::post('/teams/{team}/leave', [TeamController::class, 'leave'])->name('teams.leave');
    Route::delete('/teams/{team}/members/{user}', [TeamController::class, 'removeMember'])->name('teams.remove-member');

    // Hackathon routes
    Route::get('/hackathons', [HackathonController::class, 'index'])->name('hackathons.index');
    Route::get('/hackathons/create', [HackathonController::class, 'create'])->name('hackathons.create');
    Route::post('/hackathons', [HackathonController::class, 'store'])->name('hackathons.store');
    Route::get('/hackathons/{hackathon}', [HackathonController::class, 'show'])->name('hackathons.show');
    Route::get('/hackathons/{hackathon}/edit', [HackathonController::class, 'edit'])->name('hackathons.edit');
    Route::put('/hackathons/{hackathon}', [HackathonController::class, 'update'])->name('hackathons.update');
    Route::delete('/hackathons/{hackathon}', [HackathonController::class, 'destroy'])->name('hackathons.destroy');
    Route::get('/hackathons/{hackathon}/statistics', [HackathonController::class, 'statistics'])->name('hackathons.statistics');

    // Admin routes
    Route::middleware(['admin'])->group(function () {
        Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::put('/admin/settings', [AdminController::class, 'updateSettings'])->name('admin.settings.update');
    });
});
