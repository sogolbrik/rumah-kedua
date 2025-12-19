<?php

namespace App\Observers;

use App\Jobs\NotifyWelcomeResident;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        //
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        if (
            $user->wasChanged('role') &&
            $user->role === 'penghuni' &&
            $user->id_kamar !== null &&
            $user->tanggal_masuk !== null &&
            $user->getOriginal('role') !== 'penghuni'
        ) {
            NotifyWelcomeResident::dispatch($user);

            // Log::info("📬 Job selamat datang diantrekan untuk user {$user->id}");
        }
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
