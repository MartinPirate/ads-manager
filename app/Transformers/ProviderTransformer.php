<?php

namespace App\Transformers;

use App\Models\Provider;
use App\Models\ProviderRules;
use League\Fractal\TransformerAbstract;
use Spatie\Fractal\Fractal;
use Spatie\Fractalistic\ArraySerializer;

class ProviderTransformer extends TransformerAbstract
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
    public function transform(Provider $provider): array
    {
        return [
            'id' => $provider->id,
            'name' => $provider->provider_name,
            'description' => $this->ProviderRules($provider)
        ];
    }


    public function ProviderRules(Provider $provider): Fractal
    {
        $rules = ProviderRules::whereProviderId($provider->id)
            ->get();
        return fractal()->collection($rules, new ProviderRulesTransformer(), 'rules')->serializeWith(new ArraySerializer());


    }
}
