<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Collection;

/**
 * App\Category
 *
 * @property int $id
 * @property string $name Уникальное системное имя категории
 * @property string $displayname Отображаемое имя категории
 * @property bool $has_child Флаг наличия дочерних категорий
 * @property int|null $parent_id ID родительской категории
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read Collection|\App\Models\Post[] $posts Связанные посты
 * @property-read int|null $posts_count Количество связанных постов
 * 
 * @method static Builder|Category newModelQuery()
 * @method static Builder|Category newQuery()
 * @method static Builder|Category query()
 * @method static Builder|Category whereCreatedAt($value)
 * @method static Builder|Category whereDisplayname($value)
 * @method static Builder|Category whereHasChild($value)
 * @method static Builder|Category whereId($value)
 * @method static Builder|Category whereName($value)
 * @method static Builder|Category whereParentId($value)
 * @method static Builder|Category whereUpdatedAt($value)
 * @method static Builder|Category hasChild() Только категории с дочерними элементами
 * @method static Builder|Category root() Корневые категории
 * @method static Builder|Category children(int $parentId) Дочерние категории
 * @method static Builder|Category popular(int $limit = 10) Популярные категории
 */
class Category extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'displayname',
        'has_child',
        'parent_id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'has_child' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'categories';

    /**
     * Posts that belong to the category.
     */
    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class);
    }

    /**
     * Scope a query to only include categories with children.
     */
    public function scopeHasChild(Builder $query): Builder
    {
        return $query->where('has_child', true);
    }

    /**
     * Scope a query to only include root categories (without parent).
     */
    public function scopeRoot(Builder $query): Builder
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Scope a query to only include children of specified parent.
     */
    public function scopeChildren(Builder $query, int $parentId): Builder
    {
        return $query->where('parent_id', $parentId);
    }

    /**
     * Scope a query to get popular categories.
     */
    public function scopePopular(Builder $query, int $limit = 10): Builder
    {
        return $query->withCount('posts')
            ->orderByDesc('posts_count')
            ->limit($limit);
    }

    /**
     * Get the full path of category names (parent -> child).
     */
    public function getFullPathAttribute(): string
    {
        if ($this->parent_id) {
            $parent = self::find($this->parent_id);
            return $parent->displayname . ' → ' . $this->displayname;
        }

        return $this->displayname;
    }

    /**
     * Check if category is root.
     */
    public function isRoot(): bool
    {
        return is_null($this->parent_id);
    }

    /**
     * Check if category has children.
     */
    public function hasChildren(): bool
    {
        return $this->has_child;
    }
}
