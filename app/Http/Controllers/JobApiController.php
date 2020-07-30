<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Job;
use App\Http\Resources\JobResource;
use App\Http\Resources\JobResourceCollection;

class JobApiController extends Controller
{
    public function show(Job $job): JobResource
    {
        return new Jobresource($job);
    }

    public function index()
    {
        return new JobResourceCollection(Job::paginate());
    }
}
