<?php

namespace App\Repositories\Interfaces;

interface UserRepositoryInterface
{
    public function getCurrentUserWithProfile(int $id): array;

    public function getAllUsers(): array;

    public function getVerifiedUsers(): array;

    public function getUnverifiedUsers(): array;

    public function getBannedUsers(array $ripIds): array;

    public function getUserByUsername(string $username): array;

    public function getMessageUser(string $username): array;

    public function getAllPublicUsers(int $id): array;

    public function getAllUnbannedUsers(array $ripIds): array;

    public function getUsersWithFriends(int $id): array;

    public function getUserForAlbums(string $username): array;
}