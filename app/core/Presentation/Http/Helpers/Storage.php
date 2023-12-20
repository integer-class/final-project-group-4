<?php

namespace Presentation\Http\Helpers;

use Exception;

class Storage
{
    private static int $FILE_UPLOAD_SIZE = 5_000_000; // 5MB

    /**
     * Handles the uploaded image and validate it and then returns its path
     * It also moves the file to the specified directory
     * @param string $name
     * @param string|null $directory
     * @return string
     * @throws Exception
     */
    public static function handleUploadedImage(string $name, ?string $directory): string
    {
        $file = $_FILES[$name];

        if (!$file) {
            throw new Exception("File not found");
        }

        $file_name = $file['name'];
        $file_tmp = $file['tmp_name'];
        $file_error = $file['error'];
        $file_size = $file['size'];
        $file_ext = explode('.', $file_name);
        $file_ext = strtolower(end($file_ext));
        $allowed = ['png', 'jpg', 'jpeg', 'gif'];

        if ($file_error !== 0) {
            throw new Exception("Error uploading file");
        }

        if (!in_array($file_ext, $allowed)) {
            throw new Exception("File type not allowed");
        }

        if ($file_size > self::$FILE_UPLOAD_SIZE) {
            throw new Exception("File size too large");
        }

        $file_name_new = uniqid('', true) . '.' . $file_ext;
        $file_destination = __DIR__ . "/../Views/Assets/uploaded_images/$file_name_new";
        if ($directory) {
            $file_destination = __DIR__ . "/../Views/Assets/uploaded_images/$directory/$file_name_new";
        }

        if (!move_uploaded_file($file_tmp, $file_destination)) {
            throw new Exception("Error moving file");
        }

        return $file_name_new;
    }

    /**
     * Updates the uploaded image if the user uploads a new image
     * @param string $name
     * @param string $old_path
     * @param string|null $directory
     * @return string
     * @throws Exception
     */
    public static function updateUploadedImage(string $name, string $old_path, ?string $directory): string
    {
        if (!isset($_FILES[$name]) || $_FILES[$name]['size'] <= 0) {
            return $old_path;
        }
        self::removeStoredImage($old_path);
        return self::handleUploadedImage($name, $directory);
    }

    /**
     * Removes the stored image from the server
     * @param string $path
     */
    public static function removeStoredImage(string $path): void
    {
        unlink(__DIR__ . "/../Views/Assets/uploaded_images/$path");
    }
}