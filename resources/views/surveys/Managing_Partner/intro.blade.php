@extends('layouts.app')

@section('title') Managing Partner Survey @endsection

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="mb-4 fst-italic">
                <h3 class="fw-bold text-center">Welcome to the Managing Partner Survey</h3>
            </div>
        </div>
        <div class="col-12 ms-2">    
            <div class="mb-4">
                <h5 class="fw-bold mb-3">Purpose:</h5>
                <p class="text-break mb-3"> 
                    This internal survey is designed to gather confidential feedback from staff and partners regarding the <strong>leadership, communication, and management style of the Managing Partner</strong>. It aims to provide constructive insights that will support continuous growth, enhance leadership effectiveness, and strengthen overall firm performance.
                </p>
                
                <h5 class="fw-bold mb-3">Importance:</h5>
                <p class="text-break">
                    This feedback is vital in <strong>promoting transparency, accountability, and open communication within MMAN Advocates</strong>. The results will help the Managing Partner understand how their leadership impacts the team, identify areas for improvement, and reinforce practices that contribute positively to the firm’s culture and strategic direction.
                </p>
                    
            </div>
            <div class="mb-4">
                <h5 class="fw-bold mb-3">Roles of the Managing Partner:</h5>
                <ol> 
                    <li class="text-break">
                        Oversee the firm's business operations, including establishing the law firm structure, communicating and enforcing team values, and contributing to strategic business decisions to achieve our overall company goals.
                    </li>
                    <li>
                        Oversee the recruitment, training, motivation, and development of legal and support staff to strengthen our team.
                    </li>
                    <li>
                        Ensure that the firm is achieving its short-term and long-term goals and client satisfaction by evaluating productivity and quality of service and making recommendations for improvement.
                    </li>
                    <li>
                        Oversee the financial strategy of the law firm by adequately distributing funds across the firm, monitoring the monthly budget, staying abreast of cash flow, anticipating requirements and trends, and evaluating the results.
                    </li>
                    <li>
                        Oversee the building of the firm’s credibility, business development, and public relations opportunities e.g., business development plans and marketing initiatives, etc.
                    </li>
                    <li>
                        Facilitate long-term planning.
                    </li>
                    <li>
                        Provide strategic leadership: <br>
                        <ul>
                            <li>
                                Ensuring operations run smoothly and consistently with the firm’s mission.
                            </li>
                            <li>
                                Being accessible to legal staff and support staff.
                            </li>
                            <li>
                                Managing expectations.
                            </li>
                            <li>
                                Managing people.
                            </li>
                        </ul>
                    </li>
                    <li>
                        Ensure firm policies and procedures are followed, Be a Watchdog.
                    </li>
                    <li>
                        Help different practice groups mesh together.
                    </li>
                    <li>
                        Develop the Firm's Culture.
                    </li>
                    <li>
                        Foster cohesiveness and communication.
                    </li>
                </ol>
            </div>
        </div>
        <div class="text-center mb-3">
            <a href="{{ route('mp.survey.ratings_explained', ['user_id' => auth()->user()->id]) }}" class="text-decoration-none">
                <button class="btn btn-outline-success">Understand the Grading System</button>
            </a>
        </div>
    </div>

</div>

@endsection