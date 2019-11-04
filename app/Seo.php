<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Seo
 *
 * @property int $id
 * @property string $route_name
 * @property string $title
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Seo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Seo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Seo query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Seo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Seo whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Seo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Seo whereRouteName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Seo whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Seo whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Seo extends Model
{
    protected $table = 'seo';
}
