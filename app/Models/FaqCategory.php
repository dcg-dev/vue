<?php

namespace App\Models;

use App\Models\Model;
use EloquentFilter\Filterable;
use App\Models\FaqTopic;

class FaqCategory extends Model {

    use Filterable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'faq_categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp'
    ]; 

    /**
     * Returns list of topics
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function topics() {
        return $this->hasMany(FaqTopic::class, 'faq_category_id')->orderBy('created_at', 'desc');
    }
}
