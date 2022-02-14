<?php

namespace Database\Seeders;

use App\Models\Provider;
use App\Models\ProviderRules;
use Illuminate\Database\Seeder;

class ProvicerRulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //google provider rules seeder
        $provider_google = Provider::whereProviderName("Google")->first();
        $provider_rule = new ProviderRules();
        $provider_rule->provider_id = $provider_google->id;
        $provider_rule->file_type = ".jpg";
        $provider_rule->rule = "Must be in aspect ratio 4:3< 2 mb size";
        $provider_rule->save();

        $provider_rule = new ProviderRules();
        $provider_rule->provider_id = $provider_google->id;
        $provider_rule->file_type = ".mp4";
        $provider_rule->rule = "< 1 minutes long";
        $provider_rule->save();

        $provider_rule = new ProviderRules();
        $provider_rule->provider_id = $provider_google->id;
        $provider_rule->file_type = ".mp3";
        $provider_rule->rule = "< 30 seconds long";
        $provider_rule->save();

        $provider_rule = new ProviderRules();
        $provider_rule->provider_id = $provider_google->id;
        $provider_rule->file_type = ".mp3";
        $provider_rule->rule = "< 5mb size";
        $provider_rule->save();

        //snapchat seeder
        $provider_snapchat = Provider::whereProviderName("Snapchat")->first();
        $provider_rule = new ProviderRules();
        $provider_rule->provider_id = $provider_snapchat->id;
        $provider_rule->file_type = ".jpg";
        $provider_rule->rule = "Must be in aspect ratio 16:9";
        $provider_rule->save();

        $provider_rule = new ProviderRules();
        $provider_rule->provider_id = $provider_snapchat->id;
        $provider_rule->file_type = ".jpg";
        $provider_rule->rule = "< 5mb in size";
        $provider_rule->save();

        $provider_rule = new ProviderRules();
        $provider_rule->provider_id = $provider_snapchat->id;
        $provider_rule->file_type = ".gif";
        $provider_rule->rule = "Must be in aspect ratio 16:9";
        $provider_rule->save();

        $provider_rule = new ProviderRules();
        $provider_rule->provider_id = $provider_snapchat->id;
        $provider_rule->file_type = ".gif";
        $provider_rule->rule = "< 5mb in size";
        $provider_rule->save();

        $provider_rule = new ProviderRules();
        $provider_rule->provider_id = $provider_snapchat->id;
        $provider_rule->file_type = ".mp4";
        $provider_rule->rule = "< 50mb in size";
        $provider_rule->save();

        $provider_rule = new ProviderRules();
        $provider_rule->provider_id = $provider_snapchat->id;
        $provider_rule->file_type = ".mov";
        $provider_rule->rule = "< 50mb in size";
        $provider_rule->save();

        $provider_rule = new ProviderRules();
        $provider_rule->provider_id = $provider_snapchat->id;
        $provider_rule->file_type = ".mp4";
        $provider_rule->rule = "< 5 minutes long";
        $provider_rule->save();

        $provider_rule = new ProviderRules();
        $provider_rule->provider_id = $provider_snapchat->id;
        $provider_rule->file_type = ".mov";
        $provider_rule->rule = "< 5 minutes long";
        $provider_rule->save();
    }
}
