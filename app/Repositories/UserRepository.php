<?php

namespace App\Repositories;

use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Rip;
use App\User;
use App\Profile;

class UserRepository implements UserRepositoryInterface
{
    public function getCurrentUserWithProfile(int $id):array
    {
        return User::with('profile')->where('id', $id)->firstOrFail()->toArray();
    }

    /**
     * @return array
     */
    public function getAllUsers(): array
    {
        return User::with('profile', 'rip')->orderBy('id')->get()->toArray();
    }

    public function getVerifiedUsers(): array
    {
        return User::with('profile', 'rip')->whereNotNull('email_verified_at')->get()->toArray();
    }

    public function getUnverifiedUsers(): array
    {
        return User::with('profile', 'rip')->whereNull('email_verified_at')->get()->toArray();
    }

    public function getBannedUsers(array $ripIds): array
    {
        return User::with('profile', 'rip')->whereIn('id', $ripIds)->get()->toArray();
    }

    public function getUserByUsername(string $username): array
    {
        return  User::with('profile', 'rip')->where('username', $username)->firstOrFail()->toArray();
    }

    public function getMessageUser(string $username): array
    {
        return User::with('profile')->where('username', $username)->firstOrFail()->toArray();
    }

    public function getAllPublicUsers(int $id): array
    {
        return Profile::with(['user', 'user.friends'])->where([['public', true], ['user_id', '<>', $id]] )->get()->toArray();
    }

    public function getUsersWithFriends(int $id): array
    {
        return User::with('friends')->find($id)->toArray();
    }

    public function getUserForAlbums(string $username): array
    {
        return User::with('profile', 'albums', 'albums.images')->where('username', $username)->firstOrFail()->toArray();
    }

    public function getAllUnbannedUsers(array $ripIds): array
    {
        return User::with('profile')->whereNotIn('id', $ripIds)->get()->toArray();
    }
}