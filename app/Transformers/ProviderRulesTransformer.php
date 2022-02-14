<?php

namespace App\Transformers;

use App\Models\ProviderRules;
use League\Fractal\TransformerAbstract;

class ProviderRulesTransformer extends TransformerAbstract
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
    public function transform(ProviderRules $rules): array
    {
        return [
            /*     'id' => $rules->id,*/
            'fileType' => $rules->file_type,
            'Restrictions' => $rules->rule,
        ];
    }

}
