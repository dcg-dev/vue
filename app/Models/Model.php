<?php

namespace App\Models;
use Illuminate\Support\Facades\Input;

class Model extends \Illuminate\Database\Eloquent\Model {

    public function toArray() {
        $relations = Input::get('relations');
        if ($relations) {
            if (is_array($relations)) {
                foreach ($relations as $relation) {
                    $this->$relation;
                }
            } else {
                $this->$relation;
            }
        }
        $data = parent::toArray();
        return $data;
    }

}
