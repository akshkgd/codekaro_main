@extends('layouts.ck-admin')
@section('content')

<div class="container mt-5">
    <div class="card card-body">
        <h4 class="text-dark">Workshops Overview</h4>
         <div class="row mt-4">
        <div class="col-6 col-md">
            <div class="stat-cell stat-cell-red p-2">
                <p class="stat-cell-title">Total Workshops</p>
                <p class="stat-cell-value">{{$workshops}}</p>
            </div>

        </div>
        
        <div class="col-6 col-md">
            <div class="stat-cell stat-cell-purple p-2">
                <p class="stat-cell-title">Total Users</p>
                <p class="stat-cell-value">{{$users}}</p>
            </div>

        </div>
        <div class="col-6 col-md">
            <div class="stat-cell stat-cell-yellow p-2">
                <p class="stat-cell-title">Paid Conversions</p>
                <p class="stat-cell-value">{{$paidUsers}}</p>
            </div>

        </div>
        
        <div class="col-6 col-md">
            <div class="stat-cell stat-cell-green p-2">
                <p class="stat-cell-title">Conversions</p>
                <p class="stat-cell-value">{{($paidUsers / $users)*100}}</p>
            </div>

        </div>
        
        
    </div>
</div>
</div>



    {{-- Enrollment details --}}

    <section>
        <div class="container mt-5">
            @include('layouts.alert')
            <div class="row justify-content-center">
                <div class="col-lg-12 col-xl-12 col-sm-12 col-md-12 ">
                    
                    <div class="card mb-5">
                        <div class="card-boy">
                            <div class="p-3">
                                <h3 class="fs-5 text-dark">Students Enrolled</h3>
                            </div>
                            <div class="table-responsive">
                            <table class="table table-responsive">
                               
                                    <tr>
                                        <td scope="col">#</th>
                                        <td scope="col">Name</th>
                                        <td scope="col">Email</th>
                                        <td scope="col">Mobile</th>
                                        <td scope="col">Enrolled on </th>
                                        <td scope="col">Actions</th>

                                    </tr>
                               
                                    @foreach ($paidEnrollments as $enrollment)
                                        <tr>
                                            <td scope="row">{{ ++$i }}</th>
                                            <td> <img src="{{ $enrollment->students->avatar }}" alt=""
                                            class="avatar avatar-sm">
                                            <a class="text-dark td-none" href="{{action('AdminController@studentDetails', $enrollment->students->id  )}}">{{ $enrollment->students->name }}</a></td>
                                            <td>{{ $enrollment->students->email }}</td>
                                            <td>{{ $enrollment->students->mobile }}</td>
                                            <td>{{ $enrollment->created_at->format('d M ')}}</td>
                                            <td>
                                                <a href="{{action('AdminController@paymentReceived', Crypt::encrypt($enrollment->id) )}}" class="">Payment Received</a>
                                            </td>

                                        </tr>
                                    @endforeach

                               
                            </table>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-boy">
                            <div class="p-3">
                                <h4 class="ck-font">Students with pending Payment</h3>
                            </div>
                            <div class="table-responsive">
                            <table class="table table-responsive">
                                
                                    <tr>
                                        <td scope="col">#</th>
                                        <td scope="col">Name</th>
                                        <td scope="col">Email</th>
                                        <td scope="col">Mobile</th>
                                        <td scope="col">Enrolled on </th>
                                        <td scope="col">Actions</th>
                                    </tr>
                               
                                
                                    @foreach ($unpaidEnrollments as $enrollment)
                                        <tr>
                                            <td scope="row">{{ ++$i }}</th>
                                            <td> <img src="{{ $enrollment->students->avatar }}" alt=""
                                            class="avatar avatar-sm"> <a class="text-dark td-none" href="{{action('AdminController@studentDetails', $enrollment->students->id  )}}">{{ $enrollment->students->name }}</a></td></td>
                                            <td>{{ $enrollment->students->email }}</td>
                                            <td>{{ $enrollment->students->mobile }}</td>
                                            <td>{{ $enrollment->created_at->format('d M')}}</td>
                                            <td>
                                                <a href="{{action('AdminController@paymentReceived', Crypt::encrypt($enrollment->id) )}}" class="">Payment Received</a>
                                            </td>

                                        </tr>
                                    @endforeach

                              
                            </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
