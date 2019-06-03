<?php

namespace App\Models;

use App\Models\FaqCategory;
use EloquentFilter\Filterable;
use Mews\Purifier\Facades\Purifier;

class FaqTopic extends Model {

    use Filterable;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'faq_topics';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'faq_category_id', 'question', 'answer', 'types'
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
        'faq_category_id' => 'integer',
        'question' => 'string',
        'answer' => 'string',
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
        'types' => 'array'
    ];
    
    /**
     * Clean an answer
     * 
     * @param  string  $value
     * @return void
     */
    public function setAnswerAttribute($value) {
        $this->attributes['answer'] = Purifier::clean($value);
    }

    /**
     * Returns category
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category() {
        return $this->belongsTo(FaqCategory::class, 'faq_category_id', 'id');
    }

}
