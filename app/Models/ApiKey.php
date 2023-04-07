<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\ApiKey
 *
 * @property string $visitor_uuid
 * @property string $api_key
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|ApiKey newModelQuery()
 * @method static Builder|ApiKey newQuery()
 * @method static Builder|ApiKey query()
 * @method static Builder|ApiKey whereApiKey($value)
 * @method static Builder|ApiKey whereCreatedAt($value)
 * @method static Builder|ApiKey whereUpdatedAt($value)
 * @method static Builder|ApiKey whereVisitorUuid($value)
 * @mixin Eloquent
 */
class ApiKey extends Model
{
    use HasFactory;
    use HasUuids;

    protected $primaryKey = 'visitor_uuid';

    protected $fillable = [
        'api_key'
    ];
}
