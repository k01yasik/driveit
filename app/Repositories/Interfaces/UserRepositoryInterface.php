<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection as Collection;
use Illuminate\Database\Eloquent\Model as Model;

interface UserRepositoryInterface
{
    /**
     * @param int $id
     *
     * @return \Illuminate\Database\Eloquent\Model|static
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getCurrentUserWithProfile(int $id);

    /**
     * @return Collection
     */
    public function getAllUsers(): Collection;


    /**
     * @param string $username
     * @return Model
     */
    public function getUserByUsername(string $username): Model;

    /**
     * @param string $username
     * @return Model
     */
    public function getMessageUser(string $username): Model;


    /**
     * @param int $id
     * @return Collection
     */
    public function getAllPublicUsers(int $id): Collection;

    /**
     * @param int $id
     * @return Model
     */
    public function getUsersWithFriends(int $id): Model;
}