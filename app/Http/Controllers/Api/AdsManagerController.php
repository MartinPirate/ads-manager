<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UploadImageAndAudioRequest;
use App\Http\Requests\UploadVideoRequest;
use App\Models\AdsManager;
use App\Transformers\AdsTransformer;
use App\Transformers\Json;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Fractalistic\ArraySerializer;
use Symfony\Component\HttpFoundation\Response;

class AdsManagerController extends Controller
{
    public function loadAllFiles(Request $request): JsonResponse
    {
        $perPage = 5;
        $ads_files = (new AdsManager)->newQuery();

        if ($request->has('media_Type')) {
            $ads_files->where('file_name', 'like', '%' . $request->media_Type . '%');
        }
        if ($request->has('uploaded_date')) {
            $ads_files->where('created_at', "=", $request->uploaded_date);
        }


        $total_files = $ads_files->count();
        $ads_files = $ads_files->orderBy("created_at", "desc")->paginate($perPage);


        $ads_files = fractal()->collection($ads_files, new AdsTransformer(), 'ads_files')->serializeWith(new ArraySerializer());

        $response['success'] = 'true';
        $response['totalRecords'] = $total_files;
        $response['RecordsPerPage'] = 5;
        $response['files'] = $ads_files;


        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }

    public function uploadImageAndAudiFiles(UploadImageAndAudioRequest $request): JsonResponse
    {
        $provider = $request->provider;
        $file = $request->file("image_file");
        $provided_file_Name = $request->name;
        $mediaType = AdsManager::IMAGES;

        if ($file->getMimeType() == "audio/mpeg") {
            $mediaType = AdsManager::AUDIOS;
        }

        if ($provider == 1) {

            $googleRules = googleRules();
            $customGoogleMessages = googleCustomMessages();

            $validator = Validator::make($request->all(), $googleRules, $customGoogleMessages);

            $validator->sometimes('image_file', 'max:200|file_length:2', function ($input) {
                return $input->image_file->getMimeType() == "audio/mpeg";
            });
            $validator->sometimes('image_file', 'max:2000', function ($input) {
                return $input->image_file->getMimeType() != "audio/mpeg";
            });

            if ($validator->fails()) {
                return response()->json(Json::response(true, $validator->errors()->first()), 400);
            }

        } elseif ($provider == 2) {

            $snapChatRules = snapChatRules();

            $customSnapMessages = snapChatCustomMessages();

            $validators = Validator::make($request->all(), $snapChatRules, $customSnapMessages);
            if ($validators->fails()) {
                return response()->json(Json::response(true, $validators->errors()->first()), 400);
            }
        }

        $extension = $file->getClientOriginalExtension();
        $fileNameToStore = $provided_file_Name . '_' . time() . '.' . $extension;
        $path = $file->storeAs('files', $fileNameToStore);

        $adsAttachment = new AdsManager();
        $adsAttachment->provider_id = $provider;
        $adsAttachment->file_name = $fileNameToStore;
        $adsAttachment->file_url = $path;
        $adsAttachment->save();

        if ($adsAttachment) {
            $response = [
                'error' => false,
                'message' => 'File Saved Successfully',
                'ImageFile' => fractal()
                    ->item($adsAttachment, new AdsTransformer())
                    ->serializeWith(new ArraySerializer())
            ];

            return response()->json($response, 200, [], JSON_PRETTY_PRINT);

        }
        return response()->json(Json::response(true, 'Something Went wrong while saving File, Please try again later'), 400);
    }


    public function uploadVideo(UploadVideoRequest $request): JsonResponse
    {
        $rules = [];


        $validator = Validator::make($request->all(), $rules);

        $validator->sometimes('video_file', 'required|mimes:mp4,MP4', function ($input) {
            return $input->provider == 1;
        });

        $validator->sometimes('video_file', 'required|mimes:mp4,MP4,mov,MOV|max:50000', function ($input) {
            return $input->provider == 2;
        });

        if ($validator->fails()) {
            failedValidation($validator);
        }


        $provider = $request->provider;
        $file = $request->file("video_file");
        $provided_video_Name = $request->name;
        $mediaType = AdsManager::VIDEOS;

        $extension = $file->getClientOriginalExtension();
        $fileNameToStore = $provided_video_Name . '_' . time() . '.' . $extension;
        $path = $file->storeAs('videos', $fileNameToStore);

      $preview_image_path =  generate_preview_image($file,$path,$provided_video_Name);

        $adsAttachment = new AdsManager();
        $adsAttachment->provider_id = $provider;
        $adsAttachment->file_name = $fileNameToStore;
        $adsAttachment->file_url = $path;
        $adsAttachment->preview_image_url = $preview_image_path;
        $adsAttachment->save();

        if ("$adsAttachment") {
            $response = [
                'error' => false,
                'message' => 'Video File Saved Successfully',
                'ImageFile' => fractal()
                    ->item($adsAttachment, new AdsTransformer())
                    ->serializeWith(new ArraySerializer())
            ];
            return response()->json($response, 200, [], JSON_PRETTY_PRINT);
        }
        return response()->json(Json::response(true, 'Something Went wrong while saving File, Please try again later'), 400);


    }
}
