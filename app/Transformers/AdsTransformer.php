<?php

namespace App\Transformers;

use App\Models\AdsManager;
use App\Models\Provider;
use League\Fractal\TransformerAbstract;

class AdsTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        //
    ];

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        //
    ];

    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(AdsManager $ad): array
    {
        return [
            "id" => $ad->id,
            "fileName" => $ad->file_name,
            "filePath" => $ad->file_url,
            "PreviewImage" => $ad->preview_image_url,
            "provider" => $this->getProviderName($ad->provider_id),
            "date_created" => $ad->created_at->format('M d, Y g:i A') /* .', ' . $ad->created_at->diffForHumans()*/

        ];
    }

    public function getProviderName($id)
    {
        $provider = Provider::whereId($id)->first();
        return $provider->provider_name;
    }
}
