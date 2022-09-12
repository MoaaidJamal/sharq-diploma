<?php


namespace App\Helpers;


class APIResponse
{
    private $success;
    private $code;
    private $message;
    private $response;

    public function __construct($success, $code, $message)
    {
        $this->success = $success;
        $this->code = $code;
        $this->message = $message;
    }

    public function get()
    {
        $status = ['status' => [
            'success' => $this->success,
            'code' => $this->code,
            'message' => $this->message,
        ]];
        if ($this->response) {
            $this->response = $status + $this->response;
        } else {
            $this->response = $status;
        }
        return response()->json($this->response);
    }

    public function add($key, $value, $pagination_item = null)
    {
        $this->response[$key] = $value;
        if ($pagination_item && count($pagination_item)) {
            $this->response['pagination'] = [
                'total' => $pagination_item->count(),
                'per_page' => $pagination_item->perPage(),
                'current_page' => $pagination_item->currentPage(),
                'last_page' => $pagination_item->lastPage(),
                'next_page_url' => $pagination_item->nextPageUrl(),
                'prev_page_url' => $pagination_item->previousPageUrl(),
            ];
        }
        return $this;
    }
}
