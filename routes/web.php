<?php

use Illuminate\Support\Facades\Route;
use App\Batch;
use App\Workshop;
use App\User;
use App\Feedback;
use App\CourseEnrollment;
 use Telegram\Bot\Laravel\Facades\Telegram;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::view('/internship-certificate/8be76c72dffcb7c5','clgInternship.himanshu');
Route::view('/internship-certificate/8be76c72dffcb7c6','clgInternship.ashish');

Route::view('/complete','students.completeProfile');
Route::get('/webhook', 'TelegramController@webhook');
Route::view('/contact-us','contact');
Route::view('/game','game');
Route::view('/himanshu','team.himanshu');
Route::view('/ashish','team.ashish');
Route::view('/privacy','privacy');
Route::view('/learn-git-and-github','git');
Route::view('/javascript-live-masterclass','js');
Route::view('/web-development-live-masterclass','wd');
Route::view('/python-masterclass','python');
Route::view('/web-development-bootcamp','wdm');
Route::view('/love','love');
Route::view('/teach','teach');
Route::get('/l', function () {
    $feedbacks = Feedback::all();
    return view('l',compact('feedbacks'));
});

Route::get('/', function () {
    
    $batches = Workshop::where('status',1)->latest()->take(3)->get();
    $courses = Batch::where('status',1)->latest()->take(2)->get();
    $users = User::all()->count();
    return view('welcome', compact('batches', 'users', 'courses'));
});



Route::get('/batch', function () {
    return view('students.batchDetails');
});
Route::get('/about',  function(){
    return view('about');
});

Route::get('/logged-in-devices', 'ProfileController@index')
		->name('logged-in-devices.list')
		->middleware('auth');

Route::get('/logout/all', 'ProfileController@logoutAllDevices')
		->name('logged-in-devices.logoutAll')
		->middleware('auth');

Route::get('/logout/{device_id}', 'ProfileController@logoutDevice')
		->name('logged-in-devices.logoutSpecific')
		->middleware('auth');
// student routes start
Route::get('/notes/{id}', 'StudentController@notes');
Route::get('/recording-sessions/{id}/{key?}', 'StudentController@recordings');

//student routes end
Route::get('/event', 'WorkshopController@index');
Route::resource('/faq', 'FaqController');
Route::resource('/course', 'BatchController');
Route::resource('/feedback', 'FeedbackController');

Auth::routes(['verify' => true]);
Route::get('/redirect', 'googlelogin@redirectToProvider');
Route::get('/callback', 'googlelogin@handleProviderCallback');
Route::get('autocomplete','ProfileController@locationAutoComplete');

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/my-account', 'ProfileController@editProfile');
route::post('/edit-profile', 'ProfileController@updateStudentsProfile')->name('updateStudentsProfile');
route::post('/complete-profile', 'ProfileController@completeStudentsProfile')->name('completeStudentsProfile');

Route::get('/enroll/{id}', 'CourseEnrollmentController@checkEnroll');
Route::get('/workshop-enroll/{id}', 'WorkshopEnrollmentController@checkEnroll')->middleware('auth');
Route::get('/checkout/{id}', 'CourseEnrollmentController@checkout');
Route::post('payment', 'CourseEnrollmentController@payment')->name('payment');
Route::get('invoice/{id}', 'CourseEnrollmentController@invoice');
Route::get('/my-course', 'CourseEnrollmentController@myCourse');
Route::get('/batch/{id}', 'BatchController@batchDetails');
Route::get('/workshop/{id}', 'WorkshopController@details');
Route::get('/workshop-details/{id}', 'WorkshopController@workshopDetails');
Route::get('/workshop-certificate/{id}', 'WorkshopEnrollmentController@certificate');
Route::get('/course-certificate/{id}', 'BatchController@certificate');
Route::get('/explore-course/{id}', 'BatchController@details');



Route::get('/certificate', function(){
    $certificate = CourseEnrollment::first();
    // $students = CourseEnrollment::where('teacher_id', $ck_user->id)->count();
    $batch = Batch::first();

    return view('students.certificate', compact('certificate', 'batch'));
});


// Route::get('payment-razorpay', 'PaymentController@create')->name('paywithrazorpay');


// teachers
route::post('/update-class', 'BatchController@updateClass')->name('updateClass');
route::post('/update-workshop', 'TeacherController@updateWorkshopClass')->name('updateWorkshopClass');
Route::get('/my-classes', 'BatchController@myClasses');
Route::get('/class-details/{id}', 'BatchController@classDetails');
Route::get('/enrollments/{id}', 'TeacherController@enrollments');
Route::get('/workshop-enrollments/{id}', 'TeacherController@workshopEnrollments');
Route::get('/generate-certificate/{id}', 'TeacherController@generateCertificate');
Route::get('/addContent/{id}', 'TeacherController@addContent');
Route::post('/store-content', 'TeacherController@storeContent')->name('addContent');
Route::post('/update-batch-status', 'TeacherController@updateBatchStatus')->name('updateBatchStatus');




//admin
Route::get('/admin/students', 'AdminController@students');
Route::get('/admin/students/{id}', 'AdminController@studentDetails');
Route::post('/search', 'AdminController@search')->name('search');
Route::get('/admin/ban-student/{id}', 'AdminController@banStudent');
Route::get('/admin/activate-student/{id}', 'AdminController@activateStudent');
Route::get('/admin/make-teacher/{id}', 'AdminController@makeTeacher');
Route::get('/admin/downgrade-teacher/{id}', 'AdminController@downgradeTeacher');
Route::get('/admin/batches', 'AdminController@liveBatches');
Route::get('/admin/create/batch', 'AdminController@createBatch');
Route::get('/admin/create/batch/topics/{id}', 'AdminController@addTopics');
Route::post('/storeTopic', 'AdminController@storeTopic')->name('storeTopic');
Route::get('/delete-topic/{id}', 'AdminController@deleteTopic');
Route::get('/create-workshop', 'AdminController@createWorkshop');
Route::post('/storeWorkshop', 'AdminController@addWorkshop')->name('storeWorkshop');
Route::get('/admin/batch-enrollment/{id}', 'AdminController@batchEnrollment');
Route::get('/admin/payment-received/{id}', 'AdminController@paymentReceived');
Route::post('/updatePaymentStatus', 'AdminController@updatePaymentStatus')->name('updatePaymentStatus');
Route::get('/admin/users', 'AdminController@getUsers');
Route::get('/admin/workshops', 'AdminController@workshops');



