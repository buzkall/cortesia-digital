<?php

use App\Livewire\FrontComponent;
use App\Models\User;
use Illuminate\Support\Facades\Route;

// autologin local
Route::get('al', function() {
    abort_unless(config('app.env') === 'local', 404);
    auth()->login(User::find(1), true);

    return redirect('/admin');
});

Route::get('/', FrontComponent::class);
