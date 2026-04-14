<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="{{ public_path('build/assets/app-NPxPbrIH.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
</head>
<body class="bg-white">
    <div class="container">
        <div class="col-12 mt-2 mb-5">
            <h4 class="text-center fw-bold">{{ $expired_survey->survey_name }}</h4>
        </div>

        <div class="col-12 mb-5">
            <h4 class="text-center fw-bold">Managing Partner Survey Report</h4>
        </div>

        <div class="col-12 mb-5">
            <h4 class="text-center fw-bold">{{ $managing_partner->first_name }} {{ $managing_partner->last_name }} ({{ $managing_partner->initials }})</h4>
        </div>

        <div class="col-12 mb-5">
            <h4 class="text-center">
                <strong>From:</strong> {{ \Carbon\Carbon::parse($expired_survey->start_date)->format('l, d F Y') }} {{ \Carbon\Carbon::parse($expired_survey->start_time)->format('g:i A')  }} <br></br> 
                <strong>To:</strong> {{ \Carbon\Carbon::parse($expired_survey->end_date)->format('l, d F Y') }} {{ \Carbon\Carbon::parse($expired_survey->end_time)->format('g:i A')  }}
            </h4>
        </div>

        <div class="col-12 mb-5">
            <h5 class="text-center fw-bold"><strong>Final Rating:</strong> {{ $managing_partner_final_rating }} / 5.0</h5>
        </div>

        <div class="d-flex mb-5">
            <div class="col-5 text-end me-3">
                <h6>Managing Partner Signature:</h6>
            </div>

            <div class="col-6 border-bottom border-dark"></div>
        </div>

        <div class="d-flex mb-5">
            <div class="col-5 text-end me-3">
                <h6>HR Officer Signature:</h6>
            </div>

            <div class="col-6 border-bottom border-dark"></div>
        </div>

        @pageBreak

        @php $chartCounter = 1; @endphp

        {{-- foreach statement starts here. For each question of this category that affects this user! --}}

        @foreach ($managing_partner_survey_questions as $chunk)
            <hr>
            <p>Category {{ $loop->iteration }}: {{ $chunk->first()->question_category->category_name }}</p>
            <hr>

            <div class="col-12 d-flex">
                @foreach ($chunk as $survey_question)
                    <div class="col-6 p-2 m-2 border border-secondary-subtle">
                        <div class="col-12">
                            <p>Question: {{ $survey_question->question }}</p>
                        </div>
                        <div style="width: 500px; height: 300px;">
                            <canvas id="ratingChart{{ $chartCounter }}"></canvas>
                        </div>

                        <script>
                            new Chart(document.getElementById('ratingChart{{ $chartCounter }}'), {
                                type: 'doughnut',
                                data: {
                                    labels: ['Rated 1', 'Rated 2', 'Rated 3', 'Rated 4', 'Rated 5'],
                                    datasets: [{
                                        data: [
                                            {{ $survey_question->managing_partner_survey_result->first()->grading_1_count ?? 0 }}, 
                                            {{ $survey_question->managing_partner_survey_result->first()->grading_2_count ?? 0 }}, 
                                            {{ $survey_question->managing_partner_survey_result->first()->grading_3_count ?? 0 }}, 
                                            {{ $survey_question->managing_partner_survey_result->first()->grading_4_count ?? 0 }}, 
                                            {{ $survey_question->managing_partner_survey_result->first()->grading_5_count ?? 0 }}
                                        ],
                                        backgroundColor: [
                                            '#dc3545',
                                            '#fd7e14',
                                            '#ffc107',
                                            '#0d6efd',
                                            '#198754',
                                        ],
                                    }]
                                },
                                options: {
                                    plugins: {
                                        legend: {
                                            display: true,
                                            position: 'right'
                                        }
                                    }
                                }
                            });
                        </script>
                    </div>
                    @php $chartCounter++; @endphp
                @endforeach
            </div>
            @pageBreak
        @endforeach
</body>
</html>