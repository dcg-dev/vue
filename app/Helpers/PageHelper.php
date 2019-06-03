<?php

namespace App\Helpers;

use Ramsey\Uuid\Uuid;

class PageHelper {

    /**
     * Generates a hash based on page identifier
     *
     * @param string $identifier
     * @param null|integer $id
     * 
     * @return string
     */
    public static function pageId($identifier, $id = null) {
        $uuid5 = Uuid::uuid5(Uuid::NAMESPACE_DNS, $identifier);
        if ($id) {
            $uuid5 = Uuid::uuid5(Uuid::NAMESPACE_DNS, $identifier . '-' . $id);
        }
        return $uuid5;
    }

}
