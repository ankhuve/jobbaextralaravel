<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $table = 'jobs';

    protected $fillable = [
        'title',
        'work_place',
        'type',
        'county',
        'municipality',
        'description',
        'latest_application_date',
        'contact_email',
        'external_link',
    ];

    protected $hidden = [
        'page_views',
        'application_clicks',
        'updated_at',
        'created_at',
        'published_on_fb'
    ];

    /**
     * Open a new Job
     *
     * @param array $data
     * @return static
     */
    public static function open(array $data = [])
    {
        return new static($data);
    }


    public static function getActiveJobs()
    {
        // NOT WORKING
        return Job::all()->where('latest_application_date', '>', Carbon::now());
    }

    public static function numActiveJobs()
    {
        return Job::where('latest_application_date', '>', Carbon::now())->count();
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * A job may be profiled.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function profiledJob()
    {
        return $this->hasOne('App\ProfiledJob');
    }

    /**
     * Is the job currently profiled?
     *
     * @return bool
     */
    public function isCurrentlyProfiled()
    {
        return count($this->profiledJob) && ($this->profiledJob->end_date > Carbon::now()) ? true : false;
    }

    /**
     * Has the job been profiled?
     *
     * @return bool
     */
    public function hasBeenProfiled()
    {
        return count($this->profiledJob) && ($this->profiledJob->end_date < Carbon::now());
    }
}
