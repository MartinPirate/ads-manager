# PHP Laravel Simple Ads Manager

This project is designed to upload ads from different providers and manage files

### Installation

This application is built in [Laravel Framework](https://laravel.com/) v8.0, It requires next components to run
properly:

- PHP v7.3+
- Mysql v5.7+
- Apache Server v2.4+

### Files Configuration

1. To deploy the application, clone this repository:

   `$ git clone git@github.com:MartinPirate/ads-manager.git`

2. Create th environment file .env, or rename .env.example file, then add next parammeters:

Create a database previously, then add connection parameters

        DB_CONNECTION=mysql
        DB_HOST=[SERVER OR LOCALHOST]
        DB_PORT=3306
        DB_DATABASE=[DATABASE NAME]
        DB_USERNAME=[MYSQL USER]
        DB_PASSWORD=[MYSQL PASSWORD]

Generate the Application Key

`php artisan key:generate`

3. Update dependencies and clean precompiled files and cache, run migrations and seed the database

   `$ composer update`

   `$ php artisan optimize`

   `$ php artisan migrate:refresh --seed`

Laravel is accessible, powerful, and provides tools required for large, robust applications.

4. Launch web server without docker

   `$ php artisan config:clear`

   `$ php artisan serve`

   Now you can see it in your browser
   http://127.0.0.1:8000

   To use port 8080 run  `$ php artisan serve --port=8080`


5. To run Unit Tests run  `$ php artisan test`


6. Rest Endpoints

The REST API to the add_manager app is described below.

## Get list of Providers

### Request

`GET /providers/`

    http://127.0.0.1:8000/api/v1/providers

### Response

    HTTP/1.1 200 OK
    Date: Thu, 24 Feb 2011 12:36:30 GMT
    Status: 200 OK
    Connection: close
    Content-Type: application/json
    Content-Length: 2

      {
        "id": 1,
        "name": "Google",
        "description": [
            {
                "fileType": ".jpg",
                "Restrictions": "Must be in aspect ratio 4:3< 2 mb size"
            },
            {
                "fileType": ".mp4",
                "Restrictions": "< 1 minutes long"
            },
            {
                "fileType": ".mp3",
                "Restrictions": "< 30 seconds long"
            },
            {
                "fileType": ".mp3",
                "Restrictions": "< 5mb size"
            }
        ]
    },

## Get list of All files


`GET /files/`

    http://127.0.0.1:8000/api/v1/files

### Response

    HTTP/1.1 200 OK
    Date: Thu, 24 Feb 2011 12:36:30 GMT
    Status: 200 OK
    Connection: close
    Content-Type: application/json
    Content-Length: 2

     [
    {
        "id": 3,
        "fileName": "testfile_1644815580.jpg",
        "filePath": "files/testfile_1644815580.jpg",
        "provider": "Google",
        "date_created": "Feb 14, 2022 5:13 AM"
    },
    {
        "id": 2,
        "fileName": "testfile_1644815271.jpg",
        "filePath": "files/testfile_1644815271.jpg",
        "provider": "Google",
        "date_created": "Feb 14, 2022 5:07 AM"
    },
    {
        "id": 1,
        "fileName": "testfile_1644815174.jpg",
        "filePath": "files/testfile_1644815174.jpg",
        "provider": "Google",
        "date_created": "Feb 14, 2022 5:06 AM"
    }]

## Upload an Image File


`Post /upload-image/`

    http://127.0.0.1:8000/api/v1/upload-image


### Response

    HTTP/1.1 200 OK
    Date: Thu, 24 Feb 2011 12:36:30 GMT
    Status: 200 OK
    Connection: close
    Content-Type: application/json
    Content-Length: 2

     {
    "error": false,
    "message": "File Saved Successfully",
    "ImageFile": {
        "id": 4,
        "fileName": "testfile_1644817511.jpg",
        "filePath": "files/testfile_1644817511.jpg",
        "provider": "Google",
        "date_created": "Feb 14, 2022 5:45 AM"
    }

## Upload a Video File

### Request

`Post /upload-video/`

    http://127.0.0.1:8000/api/v1/upload-video


### Response

    HTTP/1.1 200 OK
    Date: Thu, 24 Feb 2011 12:36:30 GMT
    Status: 200 OK
    Connection: close
    Content-Type: application/json
    Content-Length: 2

    {
    "error": false,
    "message": "Video File Saved Successfully",
    "ImageFile": {
        "id": 10,
        "fileName": "final test_1644813974.mov",
        "filePath": "videos/final test_1644813974.mov",
        "provider": "Google",
        "date_created": "Feb 14, 2022 4:46 AM"
    }


    
