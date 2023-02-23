<?php

namespace App\Support;

trait PreparesResponse
{

    public static function prepareResponse($data = [], $message = '', $success = true)
    {
        if (empty($message)) {
            $message = __('success.success');
        }

        return [
           'success' => $success,
           'message' => $message,
           'data' => $data,
        ];
    }
}
