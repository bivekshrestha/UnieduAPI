<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Mail\ApplicationApply;
use App\Models\Partners\Institution;
use App\Models\Students\Student;
use App\Notifications\ApplicationSent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ApplicationController extends BaseController
{
    public function apply(Request $request)
    {
        $student = Student::with('detail')
            ->with('documents')
            ->where('id', $request->student_id)
            ->first();

        $institution = Institution::findOrFail($request->institution_id);

        Mail::to($institution->email)
            ->send(new ApplicationApply($student));

        return true;
    }
}
