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

        $path = $file->storeAs('files', $fileNameToStore);


        $data = [
            'provider' => 1,
            'name' => "test",
            'image_file' => $file,
            "file_url" => $path
        ];

        $this->post('api/v1/upload-image', $data)->assertStatus(200);
        $this->assertDatabaseHas('ads_managers',
            ['id' => 1, 'provider_id' => 1, 'file_name' => $fileNameToStore]);

        //asset the file exists
        Storage::disk('local')->assertExists($path);

        //remove the test file
        Storage::delete($path);

        //assert it was deleted
        Storage::assertMissing($path);

    }


    /**
     * @test
     * test file is uploaded with 16 by 9 aspect ratio and stored
     */
    public function test_file_is_saving_for_snap_chat()
    {
        //with 16 by 9 Aspect Ratio

        Storage::fake('files');
        $file = UploadedFile::fake()->image('photo1.jpg', 16, 9);

        $provided_file_Name = "test";
        $extension = $file->getClientOriginalExtension();
        $fileNameToStore = $provided_file_Name . '_' . time() . "." . $extension;

        $path = $file->storeAs('files', $fileNameToStore);


        $data = [
            'provider' => 2,
            'name' => "test",
            'image_file' => $file,
        ];

        $this->post('api/v1/upload-image', $data)->assertStatus(200);
        $this->assertDatabaseHas('ads_managers',
            ['id' => 1, 'provider_id' => 2, 'file_name' => $fileNameToStore]);

        Storage::disk('local')->assertExists($path);

        Storage::delete($path);

        Storage::assertMissing($path);


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

    /**
     * @test
     * assert short videos are uploaded for SnapChat provider
     */
    public function test_video_files_are_uploaded_and_saved()
    {
        $provided_file_Name = "test_video";
        $providerID = 2;

        $path = Storage::disk('local')->path('test_files/Sample-MP4-Video-File-for-Testing.mp4');

        Storage::fake('videos');
        $file = new UploadedFile($path, $provided_file_Name, "video/mp4", null,  true);

        $extension = $file->getClientOriginalExtension();
        $fileNameToStore = $provided_file_Name . '_' . time() . "." . $extension;

        $path = $file->storeAs('videos', $fileNameToStore);

      $data = [
            'provider' => 2,
            'name' => "test_video",
            'video_file' => $file,
        ];


        $this->post('api/v1/upload-video', $data)->assertStatus(200);
        $this->assertDatabaseHas('ads_managers',
            ['id' => 1, 'provider_id' => $providerID, 'file_name' => $fileNameToStore]);

        Storage::disk('local')->assertExists($path);

       Storage::delete($path);

        Storage::assertMissing($path);

    }

    /**
     * @test
     * assert longer videos are not saved
     */
    public function test_long_video_are_not_saved()
    {
        $provided_file_Name = "test_video";
        $providerID = 1;

        $path = Storage::disk('local')->path('test_files/sample_video_3.mp4');

        Storage::fake('videos');
        $file = new UploadedFile($path, $provided_file_Name);

        $extension = $file->getClientOriginalExtension();
        $fileNameToStore = $provided_file_Name . '_' . time() . "." . $extension;


        $data = [
            'provider' => $providerID,
            'name' => "test_video",
            'video_file' => $file,
        ];

        $this->post('api/v1/upload-video', $data)->assertStatus(422);
        $this->assertDatabaseMissing('ads_managers',
            ['id' => 1, 'provider_id' => $providerID, 'file_name' => $fileNameToStore]);


    }


}
