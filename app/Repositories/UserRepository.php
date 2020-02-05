<?php

namespace App\Repositories;

use App\Repositories\Interfaces\UserRepositoryInterface;
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
        return User::with('profile', 'rip')->get();
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
}