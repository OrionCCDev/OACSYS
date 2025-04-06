<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orion Contracting Co. - Employee Evaluation Form</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .rating-row {
            background-color: rgba(0, 0, 0, 0.03);
            border-radius: 0.25rem;
        }

        .rating-row:nth-child(even) {
            background-color: rgba(0, 0, 0, 0.06);
        }

        .radio-label {
            border: 1px solid #dee2e6;
            font-size: 0.85rem;
            height: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        @media (max-width: 768px) {
            .radio-label {
                font-size: 0.75rem;
            }
        }
    </style>
</head>

<body class="bg-light">
    <div class="container py-4">
        <div class="card shadow-sm">
            <div class="card-header text-center border-bottom border-primary border-2 bg-white">
                <h1 class="text-primary mb-0">Orion Contracting Co.</h1>
                <img width='50%' src="{{ asset('X-Files/Dash/logo-blue.webp') }}" alt="" srcset="">
                <h2 class="fs-4">Employee Performance Evaluation</h2>
            </div>

            <div class="card-body">
                <form id="evaluationForm">
                    <!-- Employee Information -->
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h3 class="fs-5 mb-0">Employee Information</h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="employeeId" class="form-label fw-bold">Employee ID:</label>
                                <input type="text" class="form-control" id="employeeId" name="employeeId" required>
                            </div>
                            <div class="mb-3">
                                <label for="employeeName" class="form-label fw-bold">Employee Name:</label>
                                <input type="text" class="form-control" id="employeeName" name="employeeName" required>
                            </div>
                            <div class="mb-3">
                                <label for="evaluator" class="form-label fw-bold">Evaluator Name:</label>
                                <input type="text" class="form-control" id="evaluator" value="{{ Auth::user()->name }}"
                                    name="evaluator" disabled>
                            </div>
                        </div>
                    </div>

                    <!-- Cultural Compatibility -->
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h3 class="fs-5 mb-0">Cultural Compatibility</h3>
                        </div>
                        <div class="card-body">
                            <p class="mb-3">Demonstrate a strong belief in Orion Contracting Co. and a willingness to
                                act in ways that serve organizational goals and priorities at all levels.</p>

                            <div class="rating-row p-3 mb-3">
                                <div class="row align-items-center">
                                    <div class="col-md-12 mb-3">
                                        <div class="fw-semibold">Understands the meaning of being part of Orion
                                            Contracting Co. and respects the way of working within the organization.
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-2 mb-md-0 group-of-inputs">
                                        <div class="btn-group w-100 row" role="group">
                                            <div class="radio-label col-12 col-md-6 col-lg-4 col-xl-auto flex-grow-1">
                                                <input type="radio" class="form-check-input"
                                                    name="cultural_understanding" value="1">
                                                <div>Unacceptable</div>
                                            </div>
                                            <div class="radio-label col-12 col-md-6 col-lg-4 col-xl-auto flex-grow-1">
                                                <input type="radio" class="form-check-input"
                                                    name="cultural_understanding" value="2">
                                                <div>Less than Satisfactory</div>
                                            </div>
                                            <div class="radio-label col-12 col-md-6 col-lg-4 col-xl-auto flex-grow-1">
                                                <input type="radio" class="form-check-input"
                                                    name="cultural_understanding" value="3">
                                                <div>Satisfactory</div>
                                            </div>
                                            <div class="radio-label col-12 col-md-6 col-lg-4 col-xl-auto flex-grow-1">
                                                <input type="radio" class="form-check-input"
                                                    name="cultural_understanding" value="4">
                                                <div>More than Satisfactory</div>
                                            </div>
                                            <div class="radio-label col-12 col-md-6 col-lg-4 col-xl-auto flex-grow-1">
                                                <input type="radio" class="form-check-input"
                                                    name="cultural_understanding" value="5">
                                                <div>Exceeding Satisfactory</div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="rating-row p-3 mb-3">
                                <div class="row align-items-center">
                                    <div class="col-md-12 mb-3">
                                        <div class="fw-semibold">Demonstrates interest in the company's image and acts
                                            in accordance with authorities, standards, and organizational practices.
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-2 mb-md-0 group-of-inputs">
                                        <div class="btn-group w-100 row" role="group">
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="company_image"
                                                    value="1">
                                                <div>Unacceptable</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="company_image"
                                                    value="2">
                                                <div>Less than Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="company_image"
                                                    value="3">
                                                <div>Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="company_image"
                                                    value="4">
                                                <div>More than Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="company_image"
                                                    value="5">
                                                <div>Exceeding Satisfactory</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="rating-row p-3 mb-3">
                                <div class="row align-items-center">
                                    <div class="col-md-12 mb-3">
                                        <div class="fw-semibold">Makes decisions and sets priorities to meet OCC's
                                            needs, collaborating with others to achieve organizational goals and support
                                            the company.</div>
                                    </div>
                                    <div class="col-md-12 mb-2 mb-md-0 group-of-inputs">
                                        <div class="btn-group w-100 row" role="group">
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="decisions_priorities"
                                                    value="1">
                                                <div>Unacceptable</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="decisions_priorities"
                                                    value="2">
                                                <div>Less than Satisfactory
                                                </div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="decisions_priorities"
                                                    value="3">
                                                <div>Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="decisions_priorities"
                                                    value="4">
                                                <div>More than Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="decisions_priorities"
                                                    value="5">
                                                <div>Exceeding Satisfactory</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="rating-row p-3 mb-3">
                                <div class="row align-items-center">
                                    <div class="col-md-12 mb-3">
                                        <div class="fw-semibold">Acts publicly in alignment with OCC’s mission, seeks
                                            opportunities to enhance the company’s market position, and acts as a
                                            spokesperson and advocate.</div>
                                    </div>
                                    <div class="col-md-12 mb-2 mb-md-0 group-of-inputs">
                                        <div class="btn-group w-100 row" role="group">
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="decisions_priorities"
                                                    value="1">
                                                <div>Unacceptable</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="decisions_priorities"
                                                    value="2">
                                                <div>Less than Satisfactory
                                                </div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="decisions_priorities"
                                                    value="3">
                                                <div>Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="decisions_priorities"
                                                    value="4">
                                                <div>More than Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="decisions_priorities"
                                                    value="5">
                                                <div>Exceeding Satisfactory</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="rating-row p-3 mb-3">
                                <div class="row align-items-center">
                                    <div class="col-md-12 mb-3">
                                        <div class="fw-semibold">Advocates for decisions that benefit the organization
                                            even if they are unpopular or controversial, and is willing to support
                                            decisions that may negatively affect the interest of their department in
                                            order to achieve the best interest of the company as a whole.</div>
                                    </div>
                                    <div class="col-md-12 mb-2 mb-md-0 group-of-inputs">
                                        <div class="btn-group w-100 row" role="group">
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="decisions_priorities"
                                                    value="1">
                                                <div>Unacceptable</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="decisions_priorities"
                                                    value="2">
                                                <div>Less than Satisfactory
                                                </div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="decisions_priorities"
                                                    value="3">
                                                <div>Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="decisions_priorities"
                                                    value="4">
                                                <div>More than Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="decisions_priorities"
                                                    value="5">
                                                <div>Exceeding Satisfactory</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Achieving Results -->
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h3 class="fs-5 mb-0">Achieving Results</h3>
                        </div>
                        <div class="card-body">
                            <p class="mb-3">Demonstrates the ability to analyze situations or problems, make sound
                                decisions at the right time, and develop plans to achieve optimal results.</p>

                            <div class="rating-row p-3 mb-3">
                                <div class="row align-items-center">
                                    <div class="col-md-12 mb-3">
                                        <div class="fw-semibold">Strives to get the job done correctly and effectively.
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-2 mb-md-0 group-of-inputs">
                                        <div class="btn-group w-100 row" role="group">
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="job_effectiveness"
                                                    value="1">
                                                <div>Unacceptable</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="job_effectiveness"
                                                    value="2">
                                                <div>Less than Satisfactory
                                                </div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="job_effectiveness"
                                                    value="3">
                                                <div>Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="job_effectiveness"
                                                    value="4">
                                                <div>More than Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="job_effectiveness"
                                                    value="5">
                                                <div>Exceeding Satisfactory</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="rating-row p-3 mb-3">
                                <div class="row align-items-center">
                                    <div class="col-md-12 mb-3">
                                        <div class="fw-semibold">Gradually integrates multiple activities.</div>
                                    </div>
                                    <div class="col-md-12 mb-2 mb-md-0 group-of-inputs">
                                        <div class="btn-group w-100 row" role="group">
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="effort_commitment"
                                                    value="1">
                                                <div>Unacceptable</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="effort_commitment"
                                                    value="2">
                                                <div>Less than Satisfactory
                                                </div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="effort_commitment"
                                                    value="3">
                                                <div>Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="effort_commitment"
                                                    value="4">
                                                <div>More than Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="effort_commitment"
                                                    value="5">
                                                <div>Exceeding Satisfactory</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="rating-row p-3 mb-3">
                                <div class="row align-items-center">
                                    <div class="col-md-12 mb-3">
                                        <div class="fw-semibold">Commits the required effort to fulfill job
                                            responsibilities.</div>
                                    </div>
                                    <div class="col-md-12 mb-2 mb-md-0 group-of-inputs">
                                        <div class="btn-group w-100 row" role="group">
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="effort_commitment"
                                                    value="1">
                                                <div>Unacceptable</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="effort_commitment"
                                                    value="2">
                                                <div>Less than Satisfactory
                                                </div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="effort_commitment"
                                                    value="3">
                                                <div>Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="effort_commitment"
                                                    value="4">
                                                <div>More than Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="effort_commitment"
                                                    value="5">
                                                <div>Exceeding Satisfactory</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="rating-row p-3 mb-3">
                                <div class="row align-items-center">
                                    <div class="col-md-12 mb-3">
                                        <div class="fw-semibold">Aims to deliver high-quality work.</div>
                                    </div>
                                    <div class="col-md-12 mb-2 mb-md-0 group-of-inputs">
                                        <div class="btn-group w-100 row" role="group">
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="quality_work"
                                                    value="1">
                                                <div>Unacceptable</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="quality_work"
                                                    value="2">
                                                <div>Less than Satisfactory
                                                </div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="quality_work"
                                                    value="3">
                                                <div>Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="quality_work"
                                                    value="4">
                                                <div>More than Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="quality_work"
                                                    value="5">
                                                <div>Exceeding Satisfactory</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="rating-row p-3 mb-3">
                                <div class="row align-items-center">
                                    <div class="col-md-12 mb-3">
                                        <div class="fw-semibold">Sometimes focuses on major tasks while seeking to
                                            address minor issues early to meet deadlines and optimize resource
                                            utilization.</div>
                                    </div>
                                    <div class="col-md-12 mb-2 mb-md-0 group-of-inputs">
                                        <div class="btn-group w-100 row" role="group">
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="quality_work"
                                                    value="1">
                                                <div>Unacceptable</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="quality_work"
                                                    value="2">
                                                <div>Less than Satisfactory
                                                </div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="quality_work"
                                                    value="3">
                                                <div>Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="quality_work"
                                                    value="4">
                                                <div>More than Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="quality_work"
                                                    value="5">
                                                <div>Exceeding Satisfactory</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Management Focus -->
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h3 class="fs-5 mb-0">Management Focus</h3>
                        </div>
                        <div class="card-body">
                            <p class="mb-3">Provides high-quality, professional, responsive and innovative service to
                                the customers of OCC.</p>

                            <div class="rating-row p-3 mb-3">
                                <div class="row align-items-center">
                                    <div class="col-md-12 mb-3">
                                        <div class="fw-semibold">Listens to the customers and follows up on their
                                            requests and inquiries.</div>
                                    </div>
                                    <div class="col-md-12 mb-2 mb-md-0 group-of-inputs">
                                        <div class="btn-group w-100 row" role="group">
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="customer_listening"
                                                    value="1">
                                                <div>Unacceptable</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="customer_listening"
                                                    value="2">
                                                <div>Less than Satisfactory
                                                </div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="customer_listening"
                                                    value="3">
                                                <div>Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="customer_listening"
                                                    value="4">
                                                <div>More than Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="customer_listening"
                                                    value="5">
                                                <div>Exceeding Satisfactory</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="rating-row p-3 mb-3">
                                <div class="row align-items-center">
                                    <div class="col-md-12 mb-3">
                                        <div class="fw-semibold">He may face difficulty in maintaining calm when dealing
                                            with angry Managers or in challenging situations, with an opportunity to
                                            enhance flexibility and remain composed under pressure.</div>
                                    </div>
                                    <div class="col-md-12 mb-2 mb-md-0 group-of-inputs">
                                        <div class="btn-group w-100 row" role="group">
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="customer_listening"
                                                    value="1">
                                                <div>Unacceptable</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="customer_listening"
                                                    value="2">
                                                <div>Less than Satisfactory
                                                </div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="customer_listening"
                                                    value="3">
                                                <div>Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="customer_listening"
                                                    value="4">
                                                <div>More than Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="customer_listening"
                                                    value="5">
                                                <div>Exceeding Satisfactory</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="rating-row p-3 mb-3">
                                <div class="row align-items-center">
                                    <div class="col-md-12 mb-3">
                                        <div class="fw-semibold">He handles customer issues and concerns</div>
                                    </div>
                                    <div class="col-md-12 mb-2 mb-md-0 group-of-inputs">
                                        <div class="btn-group w-100 row" role="group">
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="handling_pressure"
                                                    value="1">
                                                <div>Unacceptable</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="handling_pressure"
                                                    value="2">
                                                <div>Less than Satisfactory
                                                </div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="handling_pressure"
                                                    value="3">
                                                <div>Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="handling_pressure"
                                                    value="4">
                                                <div>More than Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="handling_pressure"
                                                    value="5">
                                                <div>Exceeding Satisfactory</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="rating-row p-3 mb-3">
                                <div class="row align-items-center">
                                    <div class="col-md-12 mb-3">
                                        <div class="fw-semibold">He maintains clear and two-way communication with
                                            customers.</div>
                                    </div>
                                    <div class="col-md-12 mb-2 mb-md-0 group-of-inputs">
                                        <div class="btn-group w-100 row" role="group">
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="handling_pressure"
                                                    value="1">
                                                <div>Unacceptable</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="handling_pressure"
                                                    value="2">
                                                <div>Less than Satisfactory
                                                </div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="handling_pressure"
                                                    value="3">
                                                <div>Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="handling_pressure"
                                                    value="4">
                                                <div>More than Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="handling_pressure"
                                                    value="5">
                                                <div>Exceeding Satisfactory</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="rating-row p-3 mb-3">
                                <div class="row align-items-center">
                                    <div class="col-md-12 mb-3">
                                        <div class="fw-semibold">He strives to understand the deep needs of customers.
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-2 mb-md-0 group-of-inputs">
                                        <div class="btn-group w-100 row" role="group">
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="customer_needs"
                                                    value="1">
                                                <div>Unacceptable</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="customer_needs"
                                                    value="2">
                                                <div>Less than Satisfactory
                                                </div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="customer_needs"
                                                    value="3">
                                                <div>Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="customer_needs"
                                                    value="4">
                                                <div>More than Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="customer_needs"
                                                    value="5">
                                                <div>Exceeding Satisfactory</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Technical Skills -->
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h3 class="fs-5 mb-0">Leadership and Change</h3>
                        </div>
                        <div class="card-body">
                            <p class="mb-3">Using personal knowledge and professional experience to envision the future,
                                anticipate changes, capitalize on opportunities, and develop innovative options that
                                support the organization's strategic direction.</p>

                            <div class="rating-row p-3 mb-3">
                                <div class="row align-items-center">
                                    <div class="col-md-12 mb-3">
                                        <div class="fw-semibold">He has a basic understanding of the need to adapt to
                                            new and changing situations.</div>
                                    </div>
                                    <div class="col-md-12 mb-2 mb-md-0 group-of-inputs">
                                        <div class="btn-group w-100 row" role="group">
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="1">
                                                <div>Unacceptable</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="2">
                                                <div>Less than Satisfactory
                                                </div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="3">
                                                <div>Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="4">
                                                <div>More than Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="5">
                                                <div>Exceeding Satisfactory</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="rating-row p-3 mb-3">
                                <div class="row align-items-center">
                                    <div class="col-md-12 mb-3">
                                        <div class="fw-semibold">He has the opportunity to enhance his creativity in
                                            identifying opportunities, possibilities, and emerging trends.</div>
                                    </div>
                                    <div class="col-md-12 mb-2 mb-md-0 group-of-inputs">
                                        <div class="btn-group w-100 row" role="group">
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="1">
                                                <div>Unacceptable</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="2">
                                                <div>Less than Satisfactory
                                                </div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="3">
                                                <div>Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="4">
                                                <div>More than Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="5">
                                                <div>Exceeding Satisfactory</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="rating-row p-3 mb-3">
                                <div class="row align-items-center">
                                    <div class="col-md-12 mb-3">
                                        <div class="fw-semibold">He may be cautious when facing opportunities and
                                            challenges, with the potential to take more initiatives to develop
                                            innovative solutions</div>
                                    </div>
                                    <div class="col-md-12 mb-2 mb-md-0 group-of-inputs">
                                        <div class="btn-group w-100 row" role="group">
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="1">
                                                <div>Unacceptable</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="2">
                                                <div>Less than Satisfactory
                                                </div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="3">
                                                <div>Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="4">
                                                <div>More than Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="5">
                                                <div>Exceeding Satisfactory</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="rating-row p-3 mb-3">
                                <div class="row align-items-center">
                                    <div class="col-md-12 mb-3">
                                        <div class="fw-semibold">He favors traditional behavioral patterns and
                                            performance, allowing for a quicker adaptation to the organization's
                                            priorities.</div>
                                    </div>
                                    <div class="col-md-12 mb-2 mb-md-0 group-of-inputs">
                                        <div class="btn-group w-100 row" role="group">
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="1">
                                                <div>Unacceptable</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="2">
                                                <div>Less than Satisfactory
                                                </div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="3">
                                                <div>Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="4">
                                                <div>More than Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="5">
                                                <div>Exceeding Satisfactory</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Technical Skills -->
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h3 class="fs-5 mb-0">Decision Making</h3>
                        </div>
                        <div class="card-body">
                            <p class="mb-3">The process of identifying and selecting alternative courses of action based
                                on values, preferences, and beliefs. This process involves evaluating information,
                                weighing options, and choosing a specific option to address a specific issue or achieve
                                a goal.</p>

                            <div class="rating-row p-3 mb-3">
                                <div class="row align-items-center">
                                    <div class="col-md-12 mb-3">
                                        <div class="fw-semibold">They tend to treat all decisions with equal care, no
                                            matter how important they are.</div>
                                    </div>
                                    <div class="col-md-12 mb-2 mb-md-0 group-of-inputs">
                                        <div class="btn-group w-100 row" role="group">
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="1">
                                                <div>Unacceptable</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="2">
                                                <div>Less than Satisfactory
                                                </div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="3">
                                                <div>Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="4">
                                                <div>More than Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="5">
                                                <div>Exceeding Satisfactory</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="rating-row p-3 mb-3">
                                <div class="row align-items-center">
                                    <div class="col-md-12 mb-3">
                                        <div class="fw-semibold">He focuses on practical solutions.</div>
                                    </div>
                                    <div class="col-md-12 mb-2 mb-md-0 group-of-inputs">
                                        <div class="btn-group w-100 row" role="group">
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="1">
                                                <div>Unacceptable</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="2">
                                                <div>Less than Satisfactory
                                                </div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="3">
                                                <div>Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="4">
                                                <div>More than Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="5">
                                                <div>Exceeding Satisfactory</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="rating-row p-3 mb-3">
                                <div class="row align-items-center">
                                    <div class="col-md-12 mb-3">
                                        <div class="fw-semibold">He usually follows established methods.</div>
                                    </div>
                                    <div class="col-md-12 mb-2 mb-md-0 group-of-inputs">
                                        <div class="btn-group w-100 row" role="group">
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="1">
                                                <div>Unacceptable</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="2">
                                                <div>Less than Satisfactory
                                                </div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="3">
                                                <div>Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="4">
                                                <div>More than Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="5">
                                                <div>Exceeding Satisfactory</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="rating-row p-3 mb-3">
                                <div class="row align-items-center">
                                    <div class="col-md-12 mb-3">
                                        <div class="fw-semibold">His decisions have a limited impact on improving the
                                            quality of products and services.</div>
                                    </div>
                                    <div class="col-md-12 mb-2 mb-md-0 group-of-inputs">
                                        <div class="btn-group w-100 row" role="group">
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="1">
                                                <div>Unacceptable</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="2">
                                                <div>Less than Satisfactory
                                                </div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="3">
                                                <div>Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="4">
                                                <div>More than Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="5">
                                                <div>Exceeding Satisfactory</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="rating-row p-3 mb-3">
                                <div class="row align-items-center">
                                    <div class="col-md-12 mb-3">
                                        <div class="fw-semibold">He has difficulty articulating the justifications for
                                            his decisions; he often postpones decision-making for others.</div>
                                    </div>
                                    <div class="col-md-12 mb-2 mb-md-0 group-of-inputs">
                                        <div class="btn-group w-100 row" role="group">
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="1">
                                                <div>Unacceptable</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="2">
                                                <div>Less than Satisfactory
                                                </div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="3">
                                                <div>Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="4">
                                                <div>More than Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="5">
                                                <div>Exceeding Satisfactory</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Technical Skills -->
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h3 class="fs-5 mb-0">The ability to take actions</h3>
                        </div>
                        <div class="card-body">
                            <p class="mb-3">Ability to take action in response to current and future opportunities,
                                including perseverance, proactivity and decisiveness</p>
                            <div class="rating-row p-3 mb-3">
                                <div class="row align-items-center">
                                    <div class="col-md-12 mb-3">
                                        <div class="fw-semibold">He takes responsibility for the outcomes, although
                                            there may be a tendency to shift responsibility when challenges arise.</div>
                                    </div>

                                    <div class="col-md-12 mb-2 mb-md-0 group-of-inputs">
                                        <div class="btn-group w-100 row" role="group">
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="1">
                                                <div>Unacceptable</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="2">
                                                <div>Less than Satisfactory
                                                </div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="3">
                                                <div>Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="4">
                                                <div>More than Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="5">
                                                <div>Exceeding Satisfactory</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="rating-row p-3 mb-3">
                                <div class="row align-items-center">
                                    <div class="col-md-12 mb-3">
                                        <div class="fw-semibold">It responds slowly to the demands of current situations
                                            and prefers to rely on higher levels to do so.</div>
                                    </div>
                                    <div class="col-md-12 mb-2 mb-md-0 group-of-inputs">
                                        <div class="btn-group w-100 row" role="group">
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="1">
                                                <div>Unacceptable</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="2">
                                                <div>Less than Satisfactory
                                                </div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="3">
                                                <div>Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="4">
                                                <div>More than Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="5">
                                                <div>Exceeding Satisfactory</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="rating-row p-3 mb-3">
                                <div class="row align-items-center">
                                    <div class="col-md-12 mb-3">
                                        <div class="fw-semibold">There is potential to strengthen alignment with the
                                            team's and department's goals and to enhance the quality and consistency of
                                            contributions.</div>
                                    </div>
                                    <div class="col-md-12 mb-2 mb-md-0 group-of-inputs">
                                        <div class="btn-group w-100 row" role="group">
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="1">
                                                <div>Unacceptable</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="2">
                                                <div>Less than Satisfactory
                                                </div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="3">
                                                <div>Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="4">
                                                <div>More than Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="5">
                                                <div>Exceeding Satisfactory</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="rating-row p-3 mb-3">
                                <div class="row align-items-center">
                                    <div class="col-md-12 mb-3">
                                        <div class="fw-semibold">Maintains a focus on immediate routine tasks, rather
                                            than customizing efforts and initiatives to align with the company's and
                                            departments' goals.</div>
                                    </div>
                                    <div class="col-md-12 mb-2 mb-md-0 group-of-inputs">
                                        <div class="btn-group w-100 row" role="group">
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="1">
                                                <div>Unacceptable</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="2">
                                                <div>Less than Satisfactory
                                                </div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="3">
                                                <div>Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="4">
                                                <div>More than Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="5">
                                                <div>Exceeding Satisfactory</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Technical Skills -->
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h3 class="fs-5 mb-0">Engineering Skills</h3>
                        </div>
                        <div class="card-body">
                            <p class="mb-3">Engineering skills encompass the technical knowledge and practical abilities
                                required to perform engineering tasks effectively.</p>

                            <div class="rating-row p-3 mb-3">
                                <div class="row align-items-center">
                                    <div class="col-md-12 mb-3">
                                        <div class="fw-semibold">AUTOCAD</div>
                                    </div>
                                    <div class="col-md-12 mb-2 mb-md-0 group-of-inputs">
                                        <div class="btn-group w-100 row" role="group">
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="1">
                                                <div>Unacceptable</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="2">
                                                <div>Less than Satisfactory
                                                </div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="3">
                                                <div>Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="4">
                                                <div>More than Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="5">
                                                <div>Exceeding Satisfactory</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check ms-3">
                                            <input type="checkbox" class="form-check-input" id="autocad_certified"
                                                name="autocad_certified" value="yes">
                                            <label class="form-check-label" for="autocad_certified">Certified</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="rating-row p-3 mb-3">
                                <div class="row align-items-center">
                                    <div class="col-md-12 mb-3">
                                        <div class="fw-semibold">MICROSOFT OFFICE</div>
                                    </div>
                                    <div class="col-md-12 mb-2 mb-md-0 group-of-inputs">
                                        <div class="btn-group w-100 row" role="group">
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="ms_office" value="1">
                                                <div>Unacceptable</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="ms_office" value="2">
                                                <div>Less than Satisfactory
                                                </div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="ms_office" value="3">
                                                <div>Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="ms_office" value="4">
                                                <div>More than Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="ms_office" value="5">
                                                <div>Exceeding Satisfactory</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check ms-3">
                                            <input type="checkbox" class="form-check-input" id="ms_office_certified"
                                                name="ms_office_certified" value="yes">
                                            <label class="form-check-label" for="ms_office_certified">Certified</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h3 class="fs-5 mb-0">Personal Skills</h3>
                        </div>
                        <div class="card-body">
                            <p>Skills related to effective communication, teamwork, site management, and reading
                                drawings.</p>

                            <div class="rating-row p-3 mb-3">
                                <div class="row align-items-center">
                                    <div class="col-md-12 mb-3">
                                        <div class="fw-semibold">Reading All Design and Shop drawings</div>
                                    </div>
                                    <div class="col-md-12 mb-2 mb-md-0 group-of-inputs">
                                        <div class="btn-group w-100 row" role="group">
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="reading_drawings"
                                                    value="1">
                                                <div>Unacceptable</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="reading_drawings"
                                                    value="2">
                                                <div>Less than Satisfactory
                                                </div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="reading_drawings"
                                                    value="3">
                                                <div>Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="reading_drawings"
                                                    value="4">
                                                <div>More than Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="reading_drawings"
                                                    value="5">
                                                <div>Exceeding Satisfactory</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="rating-row p-3 mb-3">
                                <div class="row align-items-center">
                                    <div class="col-md-12 mb-3">
                                        <div class="fw-semibold">Site Management</div>
                                    </div>
                                    <div class="col-md-12 mb-2 mb-md-0 group-of-inputs">
                                        <div class="btn-group w-100 row" role="group">
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="site_management"
                                                    value="1">
                                                <div>Unacceptable</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="site_management"
                                                    value="2">
                                                <div>Less than Satisfactory
                                                </div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="site_management"
                                                    value="3">
                                                <div>Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="site_management"
                                                    value="4">
                                                <div>More than Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="site_management"
                                                    value="5">
                                                <div>Exceeding Satisfactory</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="rating-row p-3 mb-3">
                                <div class="row align-items-center">
                                    <div class="col-md-12 mb-3">
                                        <div class="fw-semibold">Work Inspection</div>
                                    </div>
                                    <div class="col-md-12 mb-2 mb-md-0 group-of-inputs">
                                        <div class="btn-group w-100 row" role="group">
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="site_management"
                                                    value="1">
                                                <div>Unacceptable</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="site_management"
                                                    value="2">
                                                <div>Less than Satisfactory
                                                </div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="site_management"
                                                    value="3">
                                                <div>Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="site_management"
                                                    value="4">
                                                <div>More than Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="site_management"
                                                    value="5">
                                                <div>Exceeding Satisfactory</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="rating-row p-3 mb-3">
                                <div class="row align-items-center">
                                    <div class="col-md-12 mb-3">
                                        <div class="fw-semibold">Paperwork Management</div>
                                    </div>
                                    <div class="col-md-12 mb-2 mb-md-0 group-of-inputs">
                                        <div class="btn-group w-100 row" role="group">
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="site_management"
                                                    value="1">
                                                <div>Unacceptable</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="site_management"
                                                    value="2">
                                                <div>Less than Satisfactory
                                                </div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="site_management"
                                                    value="3">
                                                <div>Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="site_management"
                                                    value="4">
                                                <div>More than Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="site_management"
                                                    value="5">
                                                <div>Exceeding Satisfactory</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="rating-row p-3 mb-3">
                                <div class="row align-items-center">
                                    <div class="col-md-12 mb-3">
                                        <div class="fw-semibold">Conveying Ideas</div>
                                    </div>
                                    <div class="col-md-12 mb-2 mb-md-0 group-of-inputs">
                                        <div class="btn-group w-100 row" role="group">
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="conveying_ideas"
                                                    value="1">
                                                <div>Unacceptable</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="conveying_ideas"
                                                    value="2">
                                                <div>Less than Satisfactory
                                                </div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="conveying_ideas"
                                                    value="3">
                                                <div>Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="conveying_ideas"
                                                    value="4">
                                                <div>More than Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="conveying_ideas"
                                                    value="5">
                                                <div>Exceeding Satisfactory</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h3 class="fs-5 mb-0">Language Proficiency</h3>
                        </div>
                        <div class="card-body">
                            <p>Ability to clearly explain ideas, understand client perspectives, and communicate
                                effectively in various contexts.</p>
                            <div class="rating-row p-3 mb-3">
                                <div class="row align-items-center">
                                    <div class="col-md-12 mb-3">
                                        <div class="fw-semibold">Arabic ( Speaking & Listening )</div>
                                    </div>
                                    <div class="col-md-12 mb-2 mb-md-0 group-of-inputs">
                                        <div class="btn-group w-100 row" role="group">
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="reading_drawings"
                                                    value="1">
                                                <div>Unacceptable</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="reading_drawings"
                                                    value="2">
                                                <div>Less than Satisfactory
                                                </div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="reading_drawings"
                                                    value="3">
                                                <div>Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="reading_drawings"
                                                    value="4">
                                                <div>More than Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="reading_drawings"
                                                    value="5">
                                                <div>Exceeding Satisfactory</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="rating-row p-3 mb-3">
                                <div class="row align-items-center">
                                    <div class="col-md-12 mb-3">
                                        <div class="fw-semibold">Arabic ( Reading & Writing )</div>
                                    </div>
                                    <div class="col-md-12 mb-2 mb-md-0 group-of-inputs">
                                        <div class="btn-group w-100 row" role="group">
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="reading_drawings"
                                                    value="1">
                                                <div>Unacceptable</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="reading_drawings"
                                                    value="2">
                                                <div>Less than Satisfactory
                                                </div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="reading_drawings"
                                                    value="3">
                                                <div>Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="reading_drawings"
                                                    value="4">
                                                <div>More than Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="reading_drawings"
                                                    value="5">
                                                <div>Exceeding Satisfactory</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="rating-row p-3 mb-3">
                                <div class="row align-items-center">
                                    <div class="col-md-12 mb-3">
                                        <div class="fw-semibold">English ( Speaking & Listening )</div>
                                    </div>
                                    <div class="col-md-12 mb-2 mb-md-0 group-of-inputs">
                                        <div class="btn-group w-100 row" role="group">
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="reading_drawings"
                                                    value="1">
                                                <div>Unacceptable</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="reading_drawings"
                                                    value="2">
                                                <div>Less than Satisfactory
                                                </div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="reading_drawings"
                                                    value="3">
                                                <div>Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="reading_drawings"
                                                    value="4">
                                                <div>More than Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="reading_drawings"
                                                    value="5">
                                                <div>Exceeding Satisfactory</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="rating-row p-3 mb-3">
                                <div class="row align-items-center">
                                    <div class="col-md-12 mb-3">
                                        <div class="fw-semibold">English ( Reading & Writing )</div>
                                    </div>
                                    <div class="col-md-12 mb-2 mb-md-0 group-of-inputs">
                                        <div class="btn-group w-100 row" role="group">
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="reading_drawings"
                                                    value="1">
                                                <div>Unacceptable</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="reading_drawings"
                                                    value="2">
                                                <div>Less than Satisfactory
                                                </div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="reading_drawings"
                                                    value="3">
                                                <div>Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="reading_drawings"
                                                    value="4">
                                                <div>More than Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="reading_drawings"
                                                    value="5">
                                                <div>Exceeding Satisfactory</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Management Focus -->
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h3 class="fs-5 mb-0">Technical Skills </h3>
                        </div>
                        <div class="card-body">
                            <div class="rating-row p-3 mb-3">
                                <div class="row align-items-center">
                                    <div class="col-md-12 mb-3">
                                        <div class="fw-semibold">Attendance </div>
                                    </div>
                                    <div class="col-md-12 mb-2 mb-md-0 group-of-inputs">
                                        <div class="btn-group w-100 row" role="group">
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="customer_listening"
                                                    value="1">
                                                <div>Unacceptable</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="customer_listening"
                                                    value="2">
                                                <div>Less than Satisfactory
                                                </div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="customer_listening"
                                                    value="3">
                                                <div>Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="customer_listening"
                                                    value="4">
                                                <div>More than Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="customer_listening"
                                                    value="5">
                                                <div>Exceeding Satisfactory</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="rating-row p-3 mb-3">
                                <div class="row align-items-center">
                                    <div class="col-md-12 mb-3">
                                        <div class="fw-semibold">Work perfection </div>
                                    </div>
                                    <div class="col-md-12 mb-2 mb-md-0 group-of-inputs">
                                        <div class="btn-group w-100 row" role="group">
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="customer_listening"
                                                    value="1">
                                                <div>Unacceptable</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="customer_listening"
                                                    value="2">
                                                <div>Less than Satisfactory
                                                </div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="customer_listening"
                                                    value="3">
                                                <div>Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="customer_listening"
                                                    value="4">
                                                <div>More than Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="customer_listening"
                                                    value="5">
                                                <div>Exceeding Satisfactory</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="rating-row p-3 mb-3">
                                <div class="row align-items-center">
                                    <div class="col-md-12 mb-3">
                                        <div class="fw-semibold">Respect the time </div>
                                    </div>
                                    <div class="col-md-12 mb-2 mb-md-0 group-of-inputs">
                                        <div class="btn-group w-100 row" role="group">
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="handling_pressure"
                                                    value="1">
                                                <div>Unacceptable</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="handling_pressure"
                                                    value="2">
                                                <div>Less than Satisfactory
                                                </div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="handling_pressure"
                                                    value="3">
                                                <div>Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="handling_pressure"
                                                    value="4">
                                                <div>More than Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="handling_pressure"
                                                    value="5">
                                                <div>Exceeding Satisfactory</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="rating-row p-3 mb-3">
                                <div class="row align-items-center">
                                    <div class="col-md-12 mb-3">
                                        <div class="fw-semibold">Working in work procedures & methods </div>
                                    </div>
                                    <div class="col-md-12 mb-2 mb-md-0 group-of-inputs">
                                        <div class="btn-group w-100 row" role="group">
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="handling_pressure"
                                                    value="1">
                                                <div>Unacceptable</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="handling_pressure"
                                                    value="2">
                                                <div>Less than Satisfactory
                                                </div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="handling_pressure"
                                                    value="3">
                                                <div>Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="handling_pressure"
                                                    value="4">
                                                <div>More than Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="handling_pressure"
                                                    value="5">
                                                <div>Exceeding Satisfactory</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="rating-row p-3 mb-3">
                                <div class="row align-items-center">
                                    <div class="col-md-12 mb-3">
                                        <div class="fw-semibold">Achieve the works on specific time </div>
                                    </div>
                                    <div class="col-md-12 mb-2 mb-md-0 group-of-inputs">
                                        <div class="btn-group w-100 row" role="group">
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="customer_needs"
                                                    value="1">
                                                <div>Unacceptable</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="customer_needs"
                                                    value="2">
                                                <div>Less than Satisfactory
                                                </div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="customer_needs"
                                                    value="3">
                                                <div>Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="customer_needs"
                                                    value="4">
                                                <div>More than Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="customer_needs"
                                                    value="5">
                                                <div>Exceeding Satisfactory</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="rating-row p-3 mb-3">
                                <div class="row align-items-center">
                                    <div class="col-md-12 mb-3">
                                        <div class="fw-semibold">Achieve the works on specific quality </div>
                                    </div>
                                    <div class="col-md-12 mb-2 mb-md-0 group-of-inputs">
                                        <div class="btn-group w-100 row" role="group">
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="customer_needs"
                                                    value="1">
                                                <div>Unacceptable</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="customer_needs"
                                                    value="2">
                                                <div>Less than Satisfactory
                                                </div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="customer_needs"
                                                    value="3">
                                                <div>Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="customer_needs"
                                                    value="4">
                                                <div>More than Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="customer_needs"
                                                    value="5">
                                                <div>Exceeding Satisfactory</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="rating-row p-3 mb-3">
                                <div class="row align-items-center">
                                    <div class="col-md-12 mb-3">
                                        <div class="fw-semibold">Maintain and clean the tools </div>
                                    </div>
                                    <div class="col-md-12 mb-2 mb-md-0 group-of-inputs">
                                        <div class="btn-group w-100 row" role="group">
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="customer_needs"
                                                    value="1">
                                                <div>Unacceptable</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="customer_needs"
                                                    value="2">
                                                <div>Less than Satisfactory
                                                </div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="customer_needs"
                                                    value="3">
                                                <div>Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="customer_needs"
                                                    value="4">
                                                <div>More than Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="customer_needs"
                                                    value="5">
                                                <div>Exceeding Satisfactory</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="rating-row p-3 mb-3">
                                <div class="row align-items-center">
                                    <div class="col-md-12 mb-3">
                                        <div class="fw-semibold">Responding to emergency action </div>
                                    </div>
                                    <div class="col-md-12 mb-2 mb-md-0 group-of-inputs">
                                        <div class="btn-group w-100 row" role="group">
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="customer_needs"
                                                    value="1">
                                                <div>Unacceptable</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="customer_needs"
                                                    value="2">
                                                <div>Less than Satisfactory
                                                </div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="customer_needs"
                                                    value="3">
                                                <div>Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="customer_needs"
                                                    value="4">
                                                <div>More than Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="customer_needs"
                                                    value="5">
                                                <div>Exceeding Satisfactory</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="rating-row p-3 mb-3">
                                <div class="row align-items-center">
                                    <div class="col-md-12 mb-3">
                                        <div class="fw-semibold">Response after work time ends </div>
                                    </div>
                                    <div class="col-md-12 mb-2 mb-md-0 group-of-inputs">
                                        <div class="btn-group w-100 row" role="group">
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="customer_needs"
                                                    value="1">
                                                <div>Unacceptable</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="customer_needs"
                                                    value="2">
                                                <div>Less than Satisfactory
                                                </div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="customer_needs"
                                                    value="3">
                                                <div>Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="customer_needs"
                                                    value="4">
                                                <div>More than Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="customer_needs"
                                                    value="5">
                                                <div>Exceeding Satisfactory</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Management Focus -->
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h3 class="fs-5 mb-0">Management </h3>
                        </div>
                        <div class="card-body">
                            <div class="rating-row p-3 mb-3">
                                <div class="row align-items-center">
                                    <div class="col-md-12 mb-3">
                                        <div class="fw-semibold">Ability to arrange the material </div>
                                    </div>
                                    <div class="col-md-12 mb-2 mb-md-0 group-of-inputs">
                                        <div class="btn-group w-100 row" role="group">
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="customer_listening"
                                                    value="1">
                                                <div>Unacceptable</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="customer_listening"
                                                    value="2">
                                                <div>Less than Satisfactory
                                                </div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="customer_listening"
                                                    value="3">
                                                <div>Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="customer_listening"
                                                    value="4">
                                                <div>More than Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="customer_listening"
                                                    value="5">
                                                <div>Exceeding Satisfactory</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="rating-row p-3 mb-3">
                                <div class="row align-items-center">
                                    <div class="col-md-12 mb-3">
                                        <div class="fw-semibold">Ability to take decision </div>
                                    </div>
                                    <div class="col-md-12 mb-2 mb-md-0 group-of-inputs">
                                        <div class="btn-group w-100 row" role="group">
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="customer_listening"
                                                    value="1">
                                                <div>Unacceptable</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="customer_listening"
                                                    value="2">
                                                <div>Less than Satisfactory
                                                </div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="customer_listening"
                                                    value="3">
                                                <div>Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="customer_listening"
                                                    value="4">
                                                <div>More than Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="customer_listening"
                                                    value="5">
                                                <div>Exceeding Satisfactory</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="rating-row p-3 mb-3">
                                <div class="row align-items-center">
                                    <div class="col-md-12 mb-3">
                                        <div class="fw-semibold">Ability to plan & organize work </div>
                                    </div>
                                    <div class="col-md-12 mb-2 mb-md-0 group-of-inputs">
                                        <div class="btn-group w-100 row" role="group">
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="handling_pressure"
                                                    value="1">
                                                <div>Unacceptable</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="handling_pressure"
                                                    value="2">
                                                <div>Less than Satisfactory
                                                </div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="handling_pressure"
                                                    value="3">
                                                <div>Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="handling_pressure"
                                                    value="4">
                                                <div>More than Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="handling_pressure"
                                                    value="5">
                                                <div>Exceeding Satisfactory</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="rating-row p-3 mb-3">
                                <div class="row align-items-center">
                                    <div class="col-md-12 mb-3">
                                        <div class="fw-semibold">Ability to provide the reports </div>
                                    </div>
                                    <div class="col-md-12 mb-2 mb-md-0 group-of-inputs">
                                        <div class="btn-group w-100 row" role="group">
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="handling_pressure"
                                                    value="1">
                                                <div>Unacceptable</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="handling_pressure"
                                                    value="2">
                                                <div>Less than Satisfactory
                                                </div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="handling_pressure"
                                                    value="3">
                                                <div>Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="handling_pressure"
                                                    value="4">
                                                <div>More than Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="handling_pressure"
                                                    value="5">
                                                <div>Exceeding Satisfactory</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="rating-row p-3 mb-3">
                                <div class="row align-items-center">
                                    <div class="col-md-12 mb-3">
                                        <div class="fw-semibold">Manage time & Arrange priority </div>
                                    </div>
                                    <div class="col-md-12 mb-2 mb-md-0 group-of-inputs">
                                        <div class="btn-group w-100 row" role="group">
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="customer_needs"
                                                    value="1">
                                                <div>Unacceptable</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="customer_needs"
                                                    value="2">
                                                <div>Less than Satisfactory
                                                </div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="customer_needs"
                                                    value="3">
                                                <div>Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="customer_needs"
                                                    value="4">
                                                <div>More than Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="customer_needs"
                                                    value="5">
                                                <div>Exceeding Satisfactory</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="rating-row p-3 mb-3">
                                <div class="row align-items-center">
                                    <div class="col-md-12 mb-3">
                                        <div class="fw-semibold">Follow up on pending work </div>
                                    </div>
                                    <div class="col-md-12 mb-2 mb-md-0 group-of-inputs">
                                        <div class="btn-group w-100 row" role="group">
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="customer_needs"
                                                    value="1">
                                                <div>Unacceptable</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="customer_needs"
                                                    value="2">
                                                <div>Less than Satisfactory
                                                </div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="customer_needs"
                                                    value="3">
                                                <div>Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="customer_needs"
                                                    value="4">
                                                <div>More than Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="customer_needs"
                                                    value="5">
                                                <div>Exceeding Satisfactory</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- Technical Skills -->
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h3 class="fs-5 mb-0">Behavior</h3>
                        </div>
                        <div class="card-body">


                            <div class="rating-row p-3 mb-3">
                                <div class="row align-items-center">
                                    <div class="col-md-12 mb-3">
                                        <div class="fw-semibold">Communication</div>
                                    </div>
                                    <div class="col-md-12 mb-2 mb-md-0 group-of-inputs">
                                        <div class="btn-group w-100 row" role="group">
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="1">
                                                <div>Unacceptable</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="2">
                                                <div>Less than Satisfactory
                                                </div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="3">
                                                <div>Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="4">
                                                <div>More than Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="5">
                                                <div>Exceeding Satisfactory</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="rating-row p-3 mb-3">
                                <div class="row align-items-center">
                                    <div class="col-md-12 mb-3">
                                        <div class="fw-semibold">Ability to work without supervisor </div>
                                    </div>
                                    <div class="col-md-12 mb-2 mb-md-0 group-of-inputs">
                                        <div class="btn-group w-100 row" role="group">
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="1">
                                                <div>Unacceptable</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="2">
                                                <div>Less than Satisfactory
                                                </div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="3">
                                                <div>Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="4">
                                                <div>More than Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="5">
                                                <div>Exceeding Satisfactory</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="rating-row p-3 mb-3">
                                <div class="row align-items-center">
                                    <div class="col-md-12 mb-3">
                                        <div class="fw-semibold">Relations with co-workers & managers </div>
                                    </div>
                                    <div class="col-md-12 mb-2 mb-md-0 group-of-inputs">
                                        <div class="btn-group w-100 row" role="group">
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="1">
                                                <div>Unacceptable</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="2">
                                                <div>Less than Satisfactory
                                                </div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="3">
                                                <div>Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="4">
                                                <div>More than Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="5">
                                                <div>Exceeding Satisfactory</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="rating-row p-3 mb-3">
                                <div class="row align-items-center">
                                    <div class="col-md-12 mb-3">
                                        <div class="fw-semibold">Observing company policies & system </div>
                                    </div>
                                    <div class="col-md-12 mb-2 mb-md-0 group-of-inputs">
                                        <div class="btn-group w-100 row" role="group">
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="1">
                                                <div>Unacceptable</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="2">
                                                <div>Less than Satisfactory
                                                </div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="3">
                                                <div>Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="4">
                                                <div>More than Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="5">
                                                <div>Exceeding Satisfactory</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="rating-row p-3 mb-3">
                                <div class="row align-items-center">
                                    <div class="col-md-12 mb-3">
                                        <div class="fw-semibold">Ability to bear a large responsibility and job pressure
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-2 mb-md-0 group-of-inputs">
                                        <div class="btn-group w-100 row" role="group">
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="1">
                                                <div>Unacceptable</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="2">
                                                <div>Less than Satisfactory
                                                </div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="3">
                                                <div>Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="4">
                                                <div>More than Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="5">
                                                <div>Exceeding Satisfactory</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="rating-row p-3 mb-3">
                                <div class="row align-items-center">
                                    <div class="col-md-12 mb-3">
                                        <div class="fw-semibold">Accept all directions & evaluations </div>
                                    </div>
                                    <div class="col-md-12 mb-2 mb-md-0 group-of-inputs">
                                        <div class="btn-group w-100 row" role="group">
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="1">
                                                <div>Unacceptable</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="2">
                                                <div>Less than Satisfactory
                                                </div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="3">
                                                <div>Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="4">
                                                <div>More than Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="5">
                                                <div>Exceeding Satisfactory</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="rating-row p-3 mb-3">
                                <div class="row align-items-center">
                                    <div class="col-md-12 mb-3">
                                        <div class="fw-semibold">Working under safety instruction </div>
                                    </div>
                                    <div class="col-md-12 mb-2 mb-md-0 group-of-inputs">
                                        <div class="btn-group w-100 row" role="group">
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="1">
                                                <div>Unacceptable</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="2">
                                                <div>Less than Satisfactory
                                                </div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="3">
                                                <div>Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="4">
                                                <div>More than Satisfactory</div>
                                            </div>
                                            <div class="radio-label flex-grow-1  col-12 col-md-6 col-lg-4 col-xl-auto">
                                                <input type="radio" class="form-check-input" name="autocad" value="5">
                                                <div>Exceeding Satisfactory</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-primary">Submit Evaluation</button>
                        <a href='{{ url()->previous() }}' class="btn btn-danger">Back</a>
                    </div>
                </form>
            </div>

            <footer>
                <p>&copy; 2025 Orion Contracting Co. All rights reserved.</p>
            </footer>

            <style>
                .radio-label.flex-grow-1.col-12.col-md-6.col-lg-4.col-xl-auto {
                    background-color: ghostwhite;
                }
            </style>

</body>

</html>
