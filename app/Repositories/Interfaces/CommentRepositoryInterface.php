<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\DTO\CommentDTO;
use App\DTO\CommentUpdateDTO;

interface CommentRepositoryInterface
{
    /**
     * Get comment by ID
     * 
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getById(int $id): array;

    /**
     * Update existing comment
     */
    public function update(CommentUpdateDTO $commentData): void;

    /**
     * Create new comment
     */
    public function create(CommentDTO $commentData): array;

    /**
     * Get count of verified comments
     */
    public function getVerifiedCount(): int;

    /**
     * Get count of unverified comments
     */
    public function getUnverifiedCount(): int;

    /**
     * Get all comments for specific post
     * 
     * @return array<array-key, array{
     *     id: int,
     *     user_id: int,
     *     post_id: int,
     *     message: string,
     *     is_verified: bool,
     *     level: int,
     *     parent_id: int|null,
     *     created_at: string,
     *     updated_at: string,
     *     user: array,
     * }>
     */
    public function getByPostId(int $postId): array;

    /**
     * Get paginated comments list
     * 
     * @param int|null $page Page number for pagination
     */
    public function getPaginated(?int $page = null): LengthAwarePaginator;

    /**
     * Get all unverified comments
     * 
     * @return array<array-key, array{
     *     id: int,
     *     user_id: int,
     *     post_id: int,
     *     message: string,
     *     is_verified: bool,
     *     level: int,
     *     parent_id: int|null,
     *     created_at: string,
     *     updated_at: string,
     *     user: array,
     * }>
     */
    public function getUnverified(): array;
}
