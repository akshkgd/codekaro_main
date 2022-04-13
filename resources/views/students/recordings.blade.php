
@extends('layouts.app')
@section('content')
<style>
  .fw-400{
    font-weight: 400 !important;
  }
  .a{
    color: #00bcd4;
  }
  
</style>

<div class="navbar-container ">
  <nav class="navbar navbar-expand-lg navbar-light border-bottom-0" data-overlay>
    @include('layouts.header')
  </nav>
</div>

    
@isset($content)
 @if($content->count()>0)   

<section>
  <div class="container pt-5">
    <div class="row justify-content-cente">
      <div class="col-lg-8 col-xl-8">
        <div class="rounde o-hidden">
           
  
        
    @isset($video)
        
    <div class=""></div>
    <div id="playe" class="js-player" data-plyr-provider="youtube" data-plyr-embed-id="{{$video->videoLink}}"></div>
    <h1 class="lead-1 pt-2 pb-0" id="title">{{$video->title}}</h1>
    <div class="">
        {!!$video->desc!!}
    </div>
  </div>
  @endisset
    

       
           
       
      </div>
      <div class="col-lg-4 col-xl-4">
        <div class=" card card-dark shadow-3d border-noe " style="height: 600px; overflow-y: auto;">
          <div class="">
            <h4 class="px-3 py-2 m-0 ck-font fw-400">Previous Recordings</h3>
            @foreach ($content as $c)
            <a href="{{action('StudentController@recordings', [$batchId, $c->videoLink])}}" class="list-group-item-card list-group-item-action  lead fw-400"> <span class="mr-1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-play-circle" viewBox="0 0 16 16">
              <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
              <path d="M6.271 5.055a.5.5 0 0 1 .52.038l3.5 2.5a.5.5 0 0 1 0 .814l-3.5 2.5A.5.5 0 0 1 6 10.5v-5a.5.5 0 0 1 .271-.445z"/>
            </svg></span> {{$c->title}} </a>
             @endforeach
            
        
          </div>
        </div>
      </div>
    </div>


    
    {{$video->id}}

  </div>
  </div>
</section>
@else
<section class="">
    <div class="container mt-5 pt-5">
        
        <div class="row justify-content-center text-center">
            <div class="col-lg-5 col-md-5 d-non">
                <img src="{{asset('assets/img/search_1.png')}}" alt="" class="img-fluid">
                <h1 class="lead-1">No recordings found, </h1>
            <p class="lead">Recordings will be added shortly, for more details get in touch with your mentor.</p>
            <a href="{{url('/home')}}" class="btn btn-primary fw-400">Homepage</a>
            <a href="{{action('BatchController@batchDetails', $batchId )}}" class="btn btn-outline-primary fw-400">Course Details</a>

            </div>
        </div>
        
    </div>
</section>




@endif
@endisset



<script src="{{asset('js/plyr.js')}}"></script>
<script>
  document.addEventListener('DOMContentLoaded', () => {
 // Controls (as seen below) works in such a way that as soon as you explicitly define (add) one control
 // to the settings, ALL default controls are removed and you have to add them back in by defining those below.

 // For example, let's say you just simply wanted to add 'restart' to the control bar in addition to the default.
 // Once you specify *just* the 'restart' property below, ALL of the controls (progress bar, play, speed, etc) will be removed,
 // meaning that you MUST specify 'play', 'progress', 'speed' and the other default controls to see them again.

 const controls = [
     'play-large', // The large play button in the center
     'restart', // Restart playback
     'rewind', // Rewind by the seek time (default 10 seconds)
     'play', // Play/pause playback
     'fast-forward', // Fast forward by the seek time (default 10 seconds)
     'progress', // The progress bar and scrubber for playback and buffering
     'current-time', // The current time of playback
     'duration', // The full duration of the media
     'mute', // Toggle mute
     'volume', // Volume control
     'captions', // Toggle captions
     'settings', // Settings menu
     'pip', // Picture-in-picture (currently Safari only)
     'airplay', // Airplay (currently Safari only)
     'download', // Show a download button with a link to either the current source or a custom URL you specify in your options
     'fullscreen' // Toggle fullscreen
 ];

 const player = Plyr.setup('.js-player', { controls });

});

</script>
@endsection