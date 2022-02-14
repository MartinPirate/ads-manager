<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\ProviderRules
 *
 * @method static Builder|ProviderRules newModelQuery()
 * @method static Builder|ProviderRules newQuery()
 * @method static Builder|ProviderRules query()
 * @mixin \Eloquent
 * @property int $id
 * @property int $provider_id
 * @property string $file_type
 * @property string $rule
 * @property string|null $notes
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|ProviderRules whereCreatedAt($value)
 * @method static Builder|ProviderRules whereFileType($value)
 * @method static Builder|ProviderRules whereId($value)
 * @method static Builder|ProviderRules whereNotes($value)
 * @method static Builder|ProviderRules whereProviderId($value)
 * @method static Builder|ProviderRules whereRule($value)
 * @method static Builder|ProviderRules whereUpdatedAt($value)
 * @property string|null $deleted_at
 * @property-read \App\Models\Provider $provider
 * @method static Builder|ProviderRules whereDeletedAt($value)
 */
class ProviderRules extends Model
{
    use HasFactory;

    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class);
    }


}
