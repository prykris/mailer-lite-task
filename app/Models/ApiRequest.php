<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\ApiRequest
 *
 * @method static \Illuminate\Database\Eloquent\Builder|ApiRequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApiRequest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApiRequest query()
 * @property int $id
 * @property string $api_key
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ApiRequest whereApiKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApiRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApiRequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApiRequest whereUpdatedAt($value)
 * @mixin Eloquent
 */
class ApiRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'api_key'
    ];
}
