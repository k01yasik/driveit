<?php
/**
 * Created by PhpStorm.
 * User: Bzdykin
 * Date: 05.11.2019
 * Time: 23:49
 */

namespace App\Repositories;


use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

final class CachedUserRepository implements UserRepositoryInterface
{
    private $user;

    public function __construct(UserRepositoryInterface $user)
    {
        $this->user = $user;
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Database\Eloquent\Model|static
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getCurrentUserWithProfile(int $id)
    {
        return Cache::rememberForever('user_with_profile_'.$id, function () use ($id) {
            return $this->user->getCurrentUserWithProfile($id);
        });
    }

    /**
     * @return Collection
     */
    public function getAllUsers(): Collection
    {
        return Cache::rememberForever('all-users', function () {
            return $this->user->getAllUsers();
        });
    }

    public function getAllUnbannedUsers(): Collection
    {
        return Cache::rememberForever('unbanned-users', function () {
           return $this->user->getAllUnbannedUsers();
        });
    }

    public function getVerifiedUsers(): Collection
    {
        return Cache::rememberForever('verified-users', function () {
           return $this->user->getVerifiedUsers();
        });
    }

    public function getUnverifiedUsers(): Collection
    {
        return Cache::rememberForever('unverified-users', function () {
            return $this->user->getUnverifiedUsers();
        });
    }

    public function getBannedUsers(): Collection
    {
        return Cache::rememberForever('banned-users', function () {
            return $this->user->getBannedUsers();
        });
    }

    /**
     * @param string $username
     * @return Model
     */
    public function getUserByUsername(string $username): Model
    {
        return $this->user->getUserByUsername($username);
    }

    /**
     * @param string $username
     * @return Model
     */
    public function getMessageUser(string $username): Model
    {
        return $this->user->getMessageUser($username);
    }

    /**
     * @param int $id
     * @return Collection
     */
    public function getAllPublicUsers(int $id): Collection
    {
        return Cache::rememberForever('all-public-users', function () use ($id) {
            return $this->user->getAllPublicUsers($id);
        });
    }

    /**
     * @param int $id
     * @return Model
     */
    public function getUsersWithFriends(int $id): Model
    {
        return $this->user->getUsersWithFriends($id);
    }

    /**
     * @param string $username
     * @return Model
     */
    public function getUserForAlbums(string $username): Model
    {
        return $this->user->getUserForAlbums($username);
    }
}