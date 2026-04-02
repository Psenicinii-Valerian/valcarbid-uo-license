<?php

namespace App\Actions\Jetstream;

use App\Models\User;
use App\Models\Car;
use App\Models\UserMessages;
use App\Models\BidLog;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Laravel\Jetstream\Contracts\DeletesUsers;

class DeleteUser implements DeletesUsers
{
    /**
     * Delete the given user.
     */
    public function delete(User $user): bool
    {
        if (Car::where('seller_id', $user->id)->exists()) {
            $warningMessage = "You can't' delete your account with active listings!";
            session()->flash('warning', $warningMessage);
            return false;
        } elseif (BidLog::where('bidder_id', $user->id)->exists()) {
            $warningMessage = "You can't delete your account while involved in a bid!";
            session()->flash('warning', $warningMessage);
            return false;
        } elseif (UserMessages::where('seller_id', $user->id)->orWhere('winner_id', $user->id)->exists()) {
            $warningMessage = "You can't delete your account while a deal is ongoing!";
            session()->flash('warning', $warningMessage);
            return false;
        }

        $directory = "uploads/" . $user->name . " " . $user->surname;
        if (Storage::disk('public')->exists($directory)) {
            Storage::disk('public')->deleteDirectory($directory);
        }

        $user->deleteProfilePhoto();
        $user->tokens->each->delete();
        $user->delete();

        return true;
    }
}
