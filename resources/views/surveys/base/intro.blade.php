@extends('layouts.app')

@section('title') Survey Introduction @endsection

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            {{-- <h4 class="text-center fw-bold"> MANAGING PARTNER SURVEY  </h4> --}}
            <h4 class="text-center pb-2 fw-bold"> Ratings Explained </h4>

            <p>                
                <ul>
                    <li>
                        <strong>EXCEPTIONAL (5): </strong><br>
                        Consistently exceeds all relevant performance standards. Provides leadership, fosters teamwork, is highly productive, innovative, and responsive and generates top quality work.
                    </li> <br>
                    <li>
                        <strong>EXCEEDS EXPECTATIONS (4): </strong><br>
                        Consistently meets and often exceeds all relevant performance standards. Shows initiative and versatility, works collaboratively, has strong technical & interpersonal skills or has achieved significant improvement in these areas.
                    </li> <br>
                    <li>
                        <strong>MEETS EXPECTATIONS (3): </strong><br>
                        Meets all relevant performance standards. Seldom exceeds or falls short of desired results or objectives.
                    </li> <br>
                    <li>
                        <strong>BELOW EXPECTATIONS (2): </strong><br>
                        Sometimes meets the performance standards. Seldom exceeds and often falls short of desired results. Performance has declined significantly, or employee has not sustained adequate improvement, as required since the last performance review or performance.
                    </li> <br>
                    <li>
                        <strong>NEEDS IMPROVEMENT (1): </strong><br>Consistently falls short of performance standards.
                    </li> <br>
                </ul>
            </p>
        </div>
        <div class="col-12 text-center">

            @if (str_contains(url()->current(), 'managing'))
                <a class="text-decoration-none" href="{{ route('mp.survey.p1', ['user_id' => auth()->user()->id]) }}">
                    <button class="btn btn-outline-info p-2 mt-1 text-center">Let's Get Started!</button>
                </a>

            @elseif (str_contains(url()->current(), 'staff'))
                <a class="text-decoration-none" href="#">
                    <button class="btn btn-outline-info p-2 mt-1 text-center">Select a Department!</button>
                </a>

            @elseif ((str_contains(url()->current(), 'supervisor')))
                <a class="text-decoration-none" href="#">
                    <button class="btn btn-outline-info p-2 mt-1 text-center">Let's Get Started!</button>
                </a>

            @endif
        </div>
    </div>
</div>

@endsection