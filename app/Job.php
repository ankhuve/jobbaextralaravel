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

}
