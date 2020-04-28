<?php

namespace App\Repositories;

use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Rip;
use App\User;
use App\Profile;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class UserRepository implements UserRepositoryInterface
{

    /**
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Model|static
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getCurrentUserWithProfile(int $id)
    {
        return User::with('profile')->where('id', $id)->firstOrFail();
    }

    /**
     * @return Collection
     */
    public function getAllUsers(): Collection
    {
        return User::with('profile', 'rip')->orderBy('id')->get();
    }

    public function getVerifiedUsers(): Collection
    {
        return User::with('profile', 'rip')->whereNotNull('email_verified_at')->get();
    }

    public function getUnverifiedUsers(): Collection
    {
        return User::with('profile', 'rip')->whereNull('email_verified_at')->get();
    }

    public function getBannedUsers(): Collection
    {
        $rips_ids = [];

        $rips = Rip::all();

        foreach ($rips as $r) {
            array_push($rips_ids, $r->user_id);
        }

        return User::with('profile', 'rip')->whereIn('id', $rips_ids)->get();
    }

    /**
     * @param string $username
     * @return Model
     */
    public function getUserByUsername(string $username): Model
    {
        return  User::with('profile', 'rip')->where('username', $username)->firstOrFail();
    }

    /**
     * @param string $username
     * @return Model
     */
    public function getMessageUser(string $username): Model
    {
        return User::with('profile')->where('username', $username)->firstOrFail();
    }


    /**
     * @param int $id
     * @return Collection
     */
    public function getAllPublicUsers(int $id): Collection
    {
        return Profile::with(['user', 'user.friends'])->where([['public', true], ['user_id', '<>', $id]] )->get();
    }

    /**
     * @param int $id
     * @return Model
     */
    public function getUsersWithFriends(int $id): Model
    {
        return User::with('friends')->find($id);
    }

    /**
     * @param string $username
     * @return Model
     */
    public function getUserForAlbums(string $username): Model
    {
        return User::with('profile', 'albums', 'albums.images')->where('username', $username)->firstOrFail();
    }

    /**
     * @return Collection
     */
    public function getAllUnbannedUsers(): Collection
    {
        $rips_ids = [];

        $rips = Rip::all();

        foreach ($rips as $r) {
            array_push($rips_ids, $r->user_id);
        }

        return User::with('profile')->whereNotIn('id', $rips_ids)->get();
    }
}