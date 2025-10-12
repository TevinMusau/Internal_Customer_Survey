@extends('layouts.app')

@section('title') MMAN ICS Home @endsection

@section('content')
<div class="containter">
    <div class="row">
        <div class="col-12">
            <div class="text-center mb-4">
                <h1 class="text-center">Welcome one and all, to the new and improved ICS!</h1>
            </div>

            <div class="text-center fw-semibold mb-4">
                <h4>What is ICS? I'm glad you asked!</h4>
            </div>
        </div>
    </div>
    

    <div class="row">
        <div class="col-8">
            <div class="row" id="image">
                <div class="text-center">
                    <p class="">
                        This is an internal survey about the employees of the firm as well as the Partners of the firm. We assess thes people at individual levels and at supervisory levels. This assessment is done twice a year, after every half of the year (H1 and H2).
                        <br><br>
                        By now, HR and/or IT have already created your account. Click the below button to log into your account and start the assessment YO! Have fun!
                        <br><br>
                        We invite feedback as well. Feel free to tell us how your experience was!
                    </p>
                    <div class="">
                        <a class="me-3" href="{{ route('login') }}">
                            <button class="btn btn-outline-primary">Login Here</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="row">
                <img src="{{ asset('Images/ICS_Temp_Image.png') }}" class="w-90">
            </div>
        </div>
    </div>
</div>
@endsection