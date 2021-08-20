<?php

if (!function_exists('flash')) {

    function flash(string $message, string $status = 'success')
    {
        session()->flash('flash', [
            'message' => $message,
            'status' => $status
        ]);
    }

}
