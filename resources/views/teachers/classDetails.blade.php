@extends('layouts.app')
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<style>

</style>
@section('content')
    <div class="navbar-container ">
        <nav class="navbar navbar-expand-lg navbar-light border-bottom-0 " data-overlay>
            @include('layouts.header')
        </nav>
    </div>



    {{-- batch details start --}}

    <section class="">
        <div class="container pt-5 mt-5">
            <div class="row justify-content-center">
                <div class="col-lg-11 col-xl-9 col-sm-10 col-md-10 ">
                    @include('layouts.alert')
                    <div class="card">
                        <div class="card-body">
                            <h2 class="lead-1 m-0">{{ $batch->name }}</h3>
                                <p class="">{!! $batch->desc !!}</p>

                                <a href="{{ action('BatchController@classDetails', $batch->id) }}"
                                    class="btn ck-c-btn">Details</a>
                                <a href="{{ action('TeacherController@enrollments', $batch->id) }}"
                                    class="btn ck-c-btn">Enrollments</a>
                                <a href="{{ action('TeacherController@addContent', $batch->id) }}"
                                    class="btn ck-c-btn">Add
                                    Content</a>

                                
                    </div>

                    <div class="d-non card-body border-top">
                        @if ($batch->status >= 1)
                            <span
                                class="badge badge-pill badge-primary bg-primary-alt-2 text-primary text-center lead my-1">Upcoming
                                Class</span>
                            <h5 class="lead-1">{{ $batch->topic }}</h5>
                            <div class="d-flex justify-content-between">
                                <div class="">
                                    <h5 class="mb-0 text-primary-3 ck-font">
                                        {{ Carbon\Carbon::parse($batch->nextClass)->format('D, d M Y') }} </h4>
                                        <h6 class="ck-font">
                                            {{ Carbon\Carbon::parse($batch->nextClass)->format('h:i A') }}
                                    </h5>
                                </div>
                                <div class="">
                                    <a href="{{ $batch->meetingLink }}" target="_blank"
                                        class="btn btn-outline-primary">Launch Class</a>
                                </div>
                            </div>



                        @endif
                        @if ($batch->status > 0)
                            <div class="progress text-success mt-3">
                                <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25"
                                    aria-valuemin="0" aria-valuemax="100"></div>

                            </div>
                            <p class="lead">45% Compleated</p>
                        @endif
                    </div>
                    <div class="border-top ">
                        <div data-target="#panel-{{ $batch->id }}" class="accordion-panel-title px-3 py-3"
                            data-toggle="collapse" role="button" aria-expanded="false" aria-controls="panel-1">
                            <span class="h6 mb-0  fw-400">Update Next Class</span>
                            <img class="icon" src="{{ asset('assets/img/icons/interface/plus.svg') }}"
                                alt="plus interface icon" data-inject-svg />
                        </div>

                        <div class="collapse" id="panel-{{ $batch->id }}">
                            <div class="px-3 py-1">
                                <form action="{{ route('updateClass') }}" method="POST" class="form-inlin ">
                                    @csrf
                                    {{-- <div class="row pl-0 pr-0"> --}}
                                    <div class="form-floating mt-3 mb-2 ">

                                        <input type="text" id="floatingInput" class="form-control"
                                            value="{{ $batch->topic }}" name="topic" placeholder="Password">
                                        <label for="floatingInput">Next Topic</label>
                                    </div>
                                    <div class="form-floating mt-3 mb-2">
                                        <input type="password" class="form-control" name="nextClass"
                                            value="{{ $batch->nextClass }}" placeholder="Next Class Timings"
                                            data-flatpickr data-enable-time="true" data-date-format="Y-m-d H:i">
                                        <label for="inputPassword2">Date and time</label>
                                        <input type="hidden" value="{{ $batch->id }}" name="batchId">
                                    </div>
                                    <div class="form-floating mt-3 mb-2">
                                        <input type="text" class="form-control" value="{{ $batch->meetingLink }}"
                                            name="meetingLink" placeholder="Meeting Link"><label
                                            for="inputPassword2">Meeting Link</label>
                                        <label for="inputPassword2">Meeting Link</label>

                                    </div>
                                    <p>Additional info or link</p>
                                    <div id="quill_editor"></div>
                                    <input type="hidden" id="quill_html" name="desc mb-2"></input>

                                    <button type="submit" class="btn btn-outline-primary mt-2">Update</button>






                                    <div class="">

                                    </div>

                                    {{-- </div> --}}
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center">
                  <div class="col ">
                      <div class="card">
                          <div class="card-body">
                              <h2 class="lead-1 m-0">Update Batch Status - <span class="text-danger">Warning!!</span> </h3>
                                <p class="text-danger">Changing the batch status can restrict some features for students!</p>
                                  
  
                                  <form action="{{ route('updateBatchStatus') }}" method="POST" class="form-inlin ">
                                      @csrf
                                      {{-- <div class="row pl-0 pr-0"> --}}
                                        <div class="form-floating mt-3 mb-2 ">
  
                                            <input type="text" id="floatingInput" class="form-control"
                                                value="{{ $batch->payable }}" name="payable" placeholder="Amount Payable">
                                            <label for="floatingInput">Batch Pricing</label>
                                            <input type="hidden" value="{{ $batch->id }}" name="batchId">
    
    
                                        </div>
                                      <div class="form-floating mt-3 mb-2 ">
  
                                          <input type="text" id="floatingInput" class="form-control"
                                              value="{{ $batch->status }}" name="status" placeholder="status">
                                          <label for="floatingInput">Batch Current Status</label>
                                          <input type="hidden" value="{{ $batch->id }}" name="batchId">
                                          <p class="small pl-1">Enter 2 for live and 3 for complete</p>
  
                                          <button type="submit" class="btn btn-outline-primary">Update</button>
  
                                      </div>

                                  </form>
                      </div>
                      </div>
                  </div>
                </div>

                <div class="row">
                    <div class="col-md-6 col-lg-6 d-flx">
                        <div class="card">
                            <div class="card-bod">
                                <div class="flex-grow-1">
                                    <div class="card-body">
                                        <h1 class="lead-1">Important Links</h1>
                                        <p>Important links and groups of this batch</p>

                                    </div>
                                    <div class="">
                                        <a href="#" class="list-group-item-card list-group-item-action ">Cras justo
                                            odio</a>
                                        <a href="#" class="list-group-item-card list-group-item-action ">Cras justo
                                            odio</a>
                                        <a href="#" class="list-group-item-card list-group-item-action ">Cras justo
                                            odio</a>
                                        <a href="#" class="list-group-item-card list-group-item-action ">Cras justo
                                            odio</a>
                                        <a href="#" class="list-group-item-card list-group-item-action ">Cras justo
                                            odio</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 d-flex">
                        <div class="card">
                            <div class="card-bod">
                                <div class="flex-grow-1">
                                    <div class="card-body">
                                        <h1 class="lead-1 mr-6">Earnings for this batch</h1>
                                        <h1 class="lead-1">
                                            </h3>
                                            <p class="text-primary mb-0"></p>
                                            <h1 class="mb-0">{{ $total }}.00 Rs</h1>
                                            <p class="lead pt-5">Earnings will be automatically processed at the end of the month! Status will be changed to paid once compensation is processed</p>

                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>



                </div>






            </div>
        </div>
        </div>
    </section>
    {{-- batch details ends --}}
    <script>
        var quill = new Quill('#quill_editor', {
            theme: 'snow'
        });
        quill.on('text-change', function(delta, oldDelta, source) {
            document.getElementById("quill_html").value = quill.root.innerHTML;
        });

    </script>
@endsection
