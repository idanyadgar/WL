<?php
namespace System\Enums {
    /**
     * Request method enum.
     *
     * @package System\Enums
     */
    class RequestMethodEnum extends Enum {
        const POST   = 'post';
        const GET    = 'get';
        const PUT    = 'put';
        const DELETE = 'delete';
    }
}