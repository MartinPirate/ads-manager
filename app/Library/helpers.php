<?php
/**
 * google Rules
 *
 */

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\JsonResponse;

if (!function_exists('googleRules')) {
    function googleRules(): array
    {
        $rules = [
            // //'image_file' => 'required|mimes:jpg,JPG,jpeg|max:2048|dimensions:ratio=4/3',
            'image_file' => 'required|mimes:jpg,JPG,mp3|dimensions:ratio=4/3',
        ];
        return $rules;


    }
}
/**
 * Google Custom Messages
 *
 */
if (!function_exists('googleCustomMessages')) {
    function googleCustomMessages(): array
    {
        $messages = [
            'image_file.mimes' => 'Kindly upload a jpg,png or jpeg file.',
            'image_file.max' => 'The image size must be less than 2MB for Image files and 5 MB for Audio',
            'image_file.dimensions' => 'The Image Must be in aspect ratio 4:3',
            'image_file.file_length' => 'The Audio file should not be longer than 30 seconds',

        ];
        return $messages;

    }
}


/**
 * Snap Rules
 *
 */
if (!function_exists('snapChatRules')) {
    function snapChatRules(): array
    {
        $rules = [
            'image_file' => 'required|mimes:jpeg,jpg,gif,mp3|dimensions:ratio=16/9',
        ];
        return $rules;

    }
}

/**
 * SnapChat Custom Messages
 *
 */
if (!function_exists('snapChatCustomMessages')) {
    function snapChatCustomMessages(): array
    {
        $messages = [
            'image_file.mimes' => 'Kindly upload a jpg,gif or jpeg file.',
            'image_file.max' => 'The image size must be less than 5MB',
            'image_file.dimensions' => 'The Image Must be in aspect ratio 16:9',

        ];
        return $messages;

    }
}


/**
 * Video Rules
 *
 */
if (!function_exists('videoFilesRules')) {
    function videoFilesRules(): array
    {
        $rules = [
            'name' => 'required',
            'provider' => 'exists:providers,id|required',
        ];
        return $rules;

    }
}
/**
 * video Rules Messages
 *
 */
if (!function_exists('videoFilesCustomMessages')) {
    function videoFilesCustomMessages(): array
    {
        $messages = [
            'video_file.video_length' => 'The video File should be less than 5 Minutes',
            'video_file.name' => 'The name Field is Required',
            'video_file.provider' => 'The provider Field is Required',
        ];
        return $messages;

    }
}

/**
 * @param Validator $validator
 * @throws HttpResponseException
 */

if (!function_exists("failedValidation")) {

    function failedValidation($validator)
    {
        $messageBag = collect($validator->errors()->messages());
        $message = implode('|', $messageBag->flatten()->toArray());
        throw new HttpResponseException(response()->json(['error' => true, 'message' => $message], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
    }
}
