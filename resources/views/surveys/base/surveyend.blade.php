@extends('layouts.app')

@section('title') Intro to Managing Partner Survey @endsection

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h4 class="text-center fw-bold"> MANAGING PARTNER SURVEY  </h4>
            <h5 class="text-center mt-4 pb-2 fw-bold"> Thank you for Your Time! 😊 </h5>

            <p class="fs-6">                
                That's all folks. That concludes the Managing Partner Survey
                <br><br>
                To recap, this is how you rated the current Managing Partner:
            </p>
        </div>
        <div class="col-6 text-center">
            <table class="table table-responsive table-striped table-hover table-borderless m-3">
                <thead class="table-dark">
                    <th>Category</th>
                    <th>Rating</th>
                </thead>
                <tbody>
                    <tr>
                        <td>Punctuality</td>
                        <td>{{ $part1 }}</td>
                    </tr>
                    <tr>
                        <td>Committment</td>
                        <td>{{ $part2 }}</td>
                    </tr>
                    <tr>
                        <td>Integrity/ Trust</td>
                        <td>{{ $part3 }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-12 text-center">
            <a class="text-decoration-none" href="{{ route('dashboard', ['id', auth()->user()->id]) }}">
                <button class="btn btn-outline-success p-2 mt-1 text-center">Finish</button>
            </a>
        </div>
    </div>
</div>

@endsection