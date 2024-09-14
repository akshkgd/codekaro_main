<!DOCTYPE html>
<html class="h-full bg-white">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Codekaro Dashboard</title>
    
    <!-- Include the Alpine library on your page -->
    <script src="https://unpkg.com/alpinejs" defer></script>
    <link href="{{asset('css/app.css')}}" rel="stylesheet" />
    {{-- <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.css" rel="stylesheet" /> --}}
    {{-- <style>
      input:focus{
        border:1px solid gray !important;
      }
      td{
        color: black !important;
      }
    </style> --}}
  </head>
  <body class="font-sans">
    
    @yield('content')

    <!-- Footer Section -->
    <section class="bg-white hidden">
      <div
        class="max-w-screen-xl px-4 py-12 mx-auto space-y-8 overflow-hidden sm:px-6 lg:px-8"
      >
        
        
        <p class="mt-8 text-base leading-6 text-center text-neutral-600">
          {{-- &copy; 2024 Codekaro All rights reserved. --}}
        </p>
      </div>
    </section>


</body>
</html>
