<?php

namespace App;

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

}
