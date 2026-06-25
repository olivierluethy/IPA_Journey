<?php

class UploadController
{
    /* Accepts a single image upload (field "image"), stores it under
       public/uploads/ and returns its URL as JSON. Used by the TipTap editor. */
    public function image()
    {
        require_once 'app/Views/general/config.php';

        if (!isset($_SESSION['access_token']) || !$_SESSION['access_token']) {
            jsonResponse(['ok' => false, 'error' => 'auth'], 401);
        }
        if (empty($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
            jsonResponse(['ok' => false, 'error' => 'No file uploaded'], 400);
        }

        $file = $_FILES['image'];
        if ($file['size'] > 5 * 1024 * 1024) {
            jsonResponse(['ok' => false, 'error' => 'File too large (max 5 MB)'], 400);
        }

        $info = @getimagesize($file['tmp_name']);
        $extByMime = ['image/png' => 'png', 'image/jpeg' => 'jpg', 'image/gif' => 'gif', 'image/webp' => 'webp'];
        if ($info === false || !isset($extByMime[$info['mime']])) {
            jsonResponse(['ok' => false, 'error' => 'Unsupported image type'], 400);
        }

        $dir = __DIR__ . '/../../public/uploads';
        if (!is_dir($dir)) {
            @mkdir($dir, 0777, true);
        }
        $name = bin2hex(random_bytes(8)) . '.' . $extByMime[$info['mime']];
        if (!move_uploaded_file($file['tmp_name'], $dir . '/' . $name)) {
            jsonResponse(['ok' => false, 'error' => 'Could not store file'], 500);
        }

        jsonResponse(['ok' => true, 'url' => 'public/uploads/' . $name]);
    }
}
