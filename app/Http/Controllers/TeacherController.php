<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\CourseEnrollment;
use App\WorkshopEnrollment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Notification;
use App\Batch;
use App\Workshop;
use App\BatchContent;
use App\BatchTopics;
use App\Feedback;
use App\Notifications\recordingAdded;

class TeacherController extends Controller
{
    public function updateClass(Request $request)
    {   

    
        $batch = Batch::findorFail($request->batchId);
        $batch->topic = $request->topic;
        $batch->nextClass = $request->nextClass;
        $batch->desc = $request->desc;
        $batch->meetingLink = $request->meetingLink;
        $batch->save();
        return redirect()->back();
        
    }

    public function updateWorkshopClass(Request $request)
    {   

    
        $batch = Workshop::findorFail($request->batchId);
        $batch->topic = $request->topic;
        $batch->nextClass = $request->nextClass;
        $batch->desc = $request->desc;
        $batch->meetingLink = $request->meetingLink;
        $batch->save();
        return redirect()->back();
        
    }
    public function enrollments($id)
    {
        $batch = Batch::findorFail($id);
        if($batch->teacherId == Auth::user()->id)
        {
        $enrollments = CourseEnrollment::where('batchId', $id)->where('hasPaid', 1)->get();
        return view('teachers.enrollments', compact('enrollments', 'batch'))->with('i');
        }
        else{
            return redirect()->back();
        }
    }

    public function workshopEnrollments($id)
    {
        $batch = Workshop::findorFail($id);
        if($batch->teacherId == Auth::user()->id)
        {
        $enrollments = WorkshopEnrollment::where('workshopId', $id)->where('status', 1)->get();
        $failedEnrollments = WorkshopEnrollment::where('workshopId', $id)->where('status', 0)->get();
        return view('teachers.workshopEnrollments', compact('enrollments', 'failedEnrollments'))->with('i');
        }
        else{
            return redirect()->back();
        }
    }



    public function generateCertificate($id)
    {
        $enrollment = CourseEnrollment::findorFail($id);
        if($enrollment->certificateId == '')
        {
            $enrollment->certificateId = substr(md5(time()), 0, 16);
            $enrollment->save();
            $name = Auth::user()->name;
            session()->flash('alert-success',  'Certificate Generated Successfully!');
            return back();
        }
    }

    public function addContent($id)
    {
        $batch = Batch::findorFail($id);
        $batchContent = BatchContent::where('batchId', $batch->id)->get();
        if($batch->teacherId == Auth::user()->id)
        return view('teachers.addContent', compact('batch', 'batchContent'));
    }

    public function updateBatchStatus(Request $request)
    {
        $batch = Batch::findorFail($request->batchId);
        $batch->status = $request->status;
        $batch->payable = $request->payable;
        $batch->save();
        session()->flash('alert-success',  'Status Updated!');
        return back();

    }

    public function updateWorkshop(Request $request)
    {
        $batch = Workshop::findorFail($request->batchId);
        if($batch->teacherId == Auth::user()->id)
        {
        $batch->name = $request->name;
        $batch->description = $request->description;
        $batch->limit = $request->limit;
        $batch->schedule = $request->schedule;
        $batch->startDate = $request->startDate;
        $batch->endDate = $request->endDate;
        $batch->groupLink = $request->groupLink;
        $batch->status = $request->status;

        $batch->save();
        session()->flash('alert-success',  'Status Updated!');
        return back();
        }
        else{
            session()->flash('alert-danger',  'You can not update this workshop!');
            return back();
        }

    }

    public function generateAllCertificate($id)
{
    $batch = Batch::findOrFail($id);

    if ($batch->teacherId == Auth::user()->id) {
        $enrollments = CourseEnrollment::where('batchId', $id)
            ->where('hasPaid', 1)
            ->get();

        foreach ($enrollments as $enrollment) {
            $this->generateCertificate($enrollment->id);
        }

        session()->flash('alert-success', 'Certificates Generated Successfully!');
        return redirect()->back();
    } else {
        return redirect()->back();
    }
}


    public function storeContent( Request $request)
    {
        $batch = Batch::findorFail($request->batchId);
        
        if($batch->teacherId == Auth::user()->id)
        {
            $a = new BatchContent;
            $a->title = $request->title;
            $a->type = $request->type;
            $a->desc  = $request->desc;
            $a->videoLink = $request->videoLink;
            $a->batchId = $batch->id;
            $a->teacherId = Auth::user()->id;
            $a->save();
            $users = CourseEnrollment::where('batchId', $batch->id)->where('hasPaid', 1)->select('userId')->get();
            $usersList = array();
            foreach($users as $user){
                $emailData = array(
                    'title' => $request['title'],
                    'name' =>  strtok($user->students->name, ' ') 
                );
                $email = array($user->students->email);
                // Notification::route('mail', $email)->notify(new recordingAdded($emailData) );
                // $user->email = $user->students->email;
                // $name = $user->students->name;
                // $email = $user->students->email;
                // array_push($usersList,  );
                // $usersList = $user->students->email;
            }
            // $this->notifyRecordingAdded($request->title, $users);
            
            session()->flash('alert-success',  'Content added Successfully!');
            return back();

        }
    }

    private function notifyRecordingAdded($title, $users){
        // Notification::route('mail', $users)->notify(new recordingAdded() );
    }
    public function workshopDetails($id){
        $batch = Workshop::findorFail($id);

        return view('teachers.workshopDetails', compact('batch'));
    }
    public function myWorkshops()
    {
        $workshops = Workshop::where('teacherId', Auth::User()->id)->get();
        foreach($workshops as $workshop){
            $enrollments = WorkshopEnrollment::where('workshopId',$workshop->id);
            $totalEnrollments = $enrollments->count();
            $workshop->totalEnrollments = $totalEnrollments;
        }
        // dd($batches);
        return view('teachers.myWorkshops',compact('workshops'));
        
    }
}
