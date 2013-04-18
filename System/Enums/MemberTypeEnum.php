<?php
namespace System\Enums {
    /**
     * Member type enum.
     *
     * @package System\Enums
     */
    class MemberTypeEnum extends Enum {
        const Admin    = 'admin';
        const Standard = 'standard';
        const Banned   = 'banned';
    }
}