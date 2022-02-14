<?php

namespace Tests\Feature;

use App\Models\AdsManager;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdsManagerTest extends TestCase
{

    use RefreshDatabase;

    /**
     * @test
     * @group all providers
     */
    public function test_get_all_providers()
    {
        $this->json('get', 'api/v1/providers')
            ->assertStatus(200);
    }

    /**
     * @test
     * @group all files
     */
    public function test_get_all_files()
    {
        $this->json('get', 'api/v1/files')
            ->assertStatus(200);
    }

    /**
     * @test
     * test invalid and null data is not processed
     */
    public function test_invalid_and_null_are_not_process()
    {
        $data = [
            'provider_id' => null,
            'file_name' => null,
            'file_url' => null
        ];
        $this->json('post', 'api/v1/upload-image', $data)->assertStatus(422);
        $this->assertDatabaseMissing('ads_managers', $data);

    }

    /**
     * @test
     * test unavailable Provider ID is not processed
     */
    public function test_unavailable_provider_in_not_process()
    {
        $data = [
            'provider_id' => 4,
            'file_name' => "test",
            'file_url' => "test_url"
        ];
        $this->json('post', 'api/v1/upload-image', $data)->assertStatus(422);
        $this->assertDatabaseMissing('ads_managers', $data);

    }

    /**
     * @test
     * test file is uploaded and stored
     */
    public function test_file_is_saving_for_google()
    {
        //with 4 by 3 Aspect Ratio

        Storage::fake('files');
        $file = UploadedFile::fake()->image('photo1.jpg', 4, 3);

        $provided_file_Name = "test";
        $extension = $file->getClientOriginalExtension();
        $fileNameToStore = $provided_file_Name . '_' . time() . "." . $extension;

        Log::info($fileNameToStore);

        $data = [
            'provider' => 1,
            'name' => "test",
            'image_file' => $file,
        ];

        $this->post('api/v1/upload-image', $data)->assertStatus(200);
        $this->assertDatabaseHas('ads_managers',
            ['id' => 1, 'provider_id' => 1, 'file_name' => $fileNameToStore]);
    }


    /**
     * @test
     * test file is uploaded with 16 by 9 aspect ratio and stored
     */
    public function test_file_is_saving_for_snap_chat()
    {
        //with 4 by 3 Aspect Ratio

        Storage::fake('files');
        $file = UploadedFile::fake()->image('photo1.jpg', 16, 9);

        $provided_file_Name = "test";
        $extension = $file->getClientOriginalExtension();
        $fileNameToStore = $provided_file_Name . '_' . time() . "." . $extension;

        Log::info($fileNameToStore);

        $data = [
            'provider' => 2,
            'name' => "test",
            'image_file' => $file,
        ];

        $this->post('api/v1/upload-image', $data)->assertStatus(200);
        $this->assertDatabaseHas('ads_managers',
            ['id' => 1, 'provider_id' => 2, 'file_name' => $fileNameToStore]);
    }


    /**
     * @test
     * assert larger files are not uploaded
     */
    public function test_too_large_files_are_not_saved()
    {

        Storage::fake('files');
        $file = UploadedFile::fake()->image('photo1.jpg', 600, 800)->size(70000);

        $provided_file_Name = "test";
        $extension = $file->getClientOriginalExtension();
        $fileNameToStore = $provided_file_Name . '_' . time() . "." . $extension;

        $data = [
            'provider' => 1,
            'name' => "test",
            'image_file' => $file,
        ];

        $this->post('api/v1/upload-image', $data)->assertStatus(400);
        $this->assertDatabaseMissing('ads_managers',
            ['id' => 1, 'provider_id' => 1, 'file_name' => $fileNameToStore]);

    }


}
