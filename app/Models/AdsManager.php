<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\AdsManager
 *
 * @property int $id
 * @property int $provider_id
 * @property string $file_name
 * @property string $file_url
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static Builder|AdsManager newModelQuery()
 * @method static Builder|AdsManager newQuery()
 * @method static Builder|AdsManager query()
 * @method static Builder|AdsManager whereCreatedAt($value)
 * @method static Builder|AdsManager whereDeletedAt($value)
 * @method static Builder|AdsManager whereFileName($value)
 * @method static Builder|AdsManager whereFileUrl($value)
 * @method static Builder|AdsManager whereId($value)
 * @method static Builder|AdsManager whereProviderId($value)
 * @method static Builder|AdsManager whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $media_type
 * @property-read \App\Models\Provider $provider
 * @method static Builder|AdsManager whereMediaType($value)
 * @property string|null $preview_image_url
 * @method static Builder|AdsManager wherePreviewImageUrl($value)
 */
class AdsManager extends Model
{
    use HasFactory;

    const IMAGES = "image";
    const VIDEOS = "video";
    const AUDIOS = "audio";

    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class);
    }
}
