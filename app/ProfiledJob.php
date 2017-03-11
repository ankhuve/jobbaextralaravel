<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProfiledJob extends Model
{
    protected $table = 'profiled_jobs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id',
        'job_id',
        'start_date',
        'end_date',
        'title',
        'description',
    ];

    /**
     * A user may create many profiled jobs.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * A job may be profiled.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function job()
    {
        return $this->belongsTo('App\Job');
    }

    /**
     * Does the profiled job have a custom title and description?
     *
     * @return bool
     */
    public function hasCustomPresentation()
    {
        if($this->title && $this->description)
        {
            return true;
        }
        return false;
    }
}
