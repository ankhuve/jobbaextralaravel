<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeaturedCompany extends Model
{
    protected $table = 'featured_companies';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id',
        'start_date',
        'end_date',
    ];

    /**
     * A featured company has exactly one user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'company_id', 'id');
    }

    /**
     * Check if the company has made a presentation yet.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hasPresentation()
    {
        if($this->title)
        {
            return true;
        }
        return false;
    }
}
