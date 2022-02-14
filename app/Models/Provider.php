<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Provider
 *
 * @method static Builder|Provider newModelQuery()
 * @method static Builder|Provider newQuery()
 * @method static Builder|Provider query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $provider_name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Provider whereCreatedAt($value)
 * @method static Builder|Provider whereId($value)
 * @method static Builder|Provider whereProviderName($value)
 * @method static Builder|Provider whereUpdatedAt($value)
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProviderRules[] $rules
 * @property-read int|null $rules_count
 * @method static Builder|Provider whereDeletedAt($value)
 */
class Provider extends Model
{
    use HasFactory;

    public function rules(): HasMany
    {
        return $this->hasMany(ProviderRules::class);
    }
}
