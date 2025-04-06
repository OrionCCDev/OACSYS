<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orion Contracting Co. - Employee Evaluation Form</title>
    <style>
     body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 5px;
        }
        header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #2c3e50;
        }
        h1 {
            color: #2c3e50;
            margin: 0;
        }
        .form-section {
            margin-bottom: 25px;
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 5px;
        }
        .section-title {
            background-color: #2c3e50;
            color: white;
            padding: 10px;
            margin-top: 0;
            margin-bottom: 15px;
            border-radius: 3px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"],
        input[type="date"],
        input[type="number"],
        textarea,
        select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .rating-row {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            padding: 8px;
            background-color: #f9f9f9;
            border-radius: 4px;
        }
        .rating-row:nth-child(even) {
            background-color: #f1f1f1;
        }
        .rating-item {
            flex: 3;
        }
        .rating-scale {
            flex: 2;
            display: flex;
            justify-content: space-between;
        }
        .rating-comment {
            flex: 2;
        }
        .radio-group {
            display: flex;
            justify-content: space-between;
            width: 100%;
        }
        .radio-label {
            text-align: center;
            font-size: 11px;
            border: 1px solid #aaa;
            padding: 3px;
            margin: 0 2px;
            width: 90px;
            height: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        input[type="radio"] {
            margin: 0 5px;
        }
        .comment-box {
            width: 100%;
            padding: 5px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .btn {
            background-color: #2c3e50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        .btn:hover {
            background-color: #1a252f;
        }
        footer {
            text-align: center;
            margin-top: 20px;
            color: #777;
            font-size: 14px;
        }
        @media (max-width: 768px) {
            .rating-row {
                flex-direction: column;
            }
            .rating-item, .rating-scale, .rating-comment {
                width: 100%;
                margin-bottom: 10px;
            }
            .radio-group {
                flex-wrap: wrap;
            }
            .radio-label {
                width: 18%;
                margin-bottom: 5px;
                height: 50px;
                font-size: 9px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Orion Contracting Co.</h1>
            <h2>Employee Performance Evaluation</h2>
        </header>

        <form id="evaluationForm">
            <!-- Employee Information -->
            <div class="form-section">
                <h3 class="section-title">Employee Information</h3>
                <div class="form-group">
                    <label for="employeeId">Employee ID:</label>
                    <input type="text" id="employeeId" name="employeeId" required>
                </div>
                <div class="form-group">
                    <label for="employeeName">Employee Name:</label>
                    <input type="text" id="employeeName" name="employeeName" required>
                </div>
                <div class="form-group">
                    <label for="department">Department:</label>
                    <input type="text" id="department" name="department" required>
                </div>
                <div class="form-group">
                    <label for="position">Position:</label>
                    <input type="text" id="position" name="position" required>
                </div>
                <div class="form-group">
                    <label for="evaluationDate">Evaluation Date:</label>
                    <input type="date" id="evaluationDate" name="evaluationDate" required>
                </div>
                <div class="form-group">
                    <label for="evaluator">Evaluator Name:</label>
                    <input type="text" id="evaluator" name="evaluator" required>
                </div>
            </div>

            <!-- Cultural Compatibility -->
            <div class="form-section">
                <h3 class="section-title">Cultural Compatibility</h3>
                <p>Demonstrate a strong belief in Orion Contracting Co. and a willingness to act in ways that serve organizational goals and priorities at all levels.</p>

                <div class="rating-row">
                    <div class="rating-item">Understands the meaning of being part of Orion Contracting Co. and respects the way of working within the organization.</div>
                    <div class="rating-scale">
                        <div class="radio-group">
                            <div class="radio-label">
                                <input type="radio" name="cultural_understanding" value="1">
                                <div>1</div>
                            </div>
                            <div class="radio-label">
                                <input type="radio" name="cultural_understanding" value="2">
                                <div>2</div>
                            </div>
                            <div class="radio-label">
                                <input type="radio" name="cultural_understanding" value="3">
                                <div>3</div>
                            </div>
                            <div class="radio-label">
                                <input type="radio" name="cultural_understanding" value="4">
                                <div>4</div>
                            </div>
                            <div class="radio-label">
                                <input type="radio" name="cultural_understanding" value="5">
                                <div>5</div>
                            </div>
                        </div>
                    </div>
                    <div class="rating-comment">
                        <input type="text" class="comment-box" name="cultural_understanding_comment" placeholder="Comments">
                    </div>
                </div>

                <div class="rating-row">
                    <div class="rating-item">Demonstrates interest in the company's image and acts in accordance with authorities, standards, and organizational practices.</div>
                    <div class="rating-scale">
                        <div class="radio-group">
                            <div class="radio-label">
                                <input type="radio" name="company_image" value="1">
                                <div>1</div>
                            </div>
                            <div class="radio-label">
                                <input type="radio" name="company_image" value="2">
                                <div>2</div>
                            </div>
                            <div class="radio-label">
                                <input type="radio" name="company_image" value="3">
                                <div>3</div>
                            </div>
                            <div class="radio-label">
                                <input type="radio" name="company_image" value="4">
                                <div>4</div>
                            </div>
                            <div class="radio-label">
                                <input type="radio" name="company_image" value="5">
                                <div>5</div>
                            </div>
                        </div>
                    </div>
                    <div class="rating-comment">
                        <input type="text" class="comment-box" name="company_image_comment" placeholder="Comments">
                    </div>
                </div>

                <div class="rating-row">
                    <div class="rating-item">Makes decisions and sets priorities to meet OCC's needs, collaborating with others to achieve organizational goals and support the company.</div>
                    <div class="rating-scale">
                        <div class="radio-group">
                            <div class="radio-label">
                                <input type="radio" name="decisions_priorities" value="1">
                                <div>1</div>
                            </div>
                            <div class="radio-label">
                                <input type="radio" name="decisions_priorities" value="2">
                                <div>2</div>
                            </div>
                            <div class="radio-label">
                                <input type="radio" name="decisions_priorities" value="3">
                                <div>3</div>
                            </div>
                            <div class="radio-label">
                                <input type="radio" name="decisions_priorities" value="4">
                                <div>4</div>
                            </div>
                            <div class="radio-label">
                                <input type="radio" name="decisions_priorities" value="5">
                                <div>5</div>
                            </div>
                        </div>
                    </div>
                    <div class="rating-comment">
                        <input type="text" class="comment-box" name="decisions_priorities_comment" placeholder="Comments">
                    </div>
                </div>
            </div>

            <!-- Achieving Results -->
            <div class="form-section">
                <h3 class="section-title">Achieving Results</h3>
                <p>Demonstrates the ability to analyze situations or problems, make sound decisions at the right time, and develop plans to achieve optimal results.</p>

                <div class="rating-row">
                    <div class="rating-item">Strives to get the job done correctly and effectively.</div>
                    <div class="rating-scale">
                        <div class="radio-group">
                            <div class="radio-label">
                                <input type="radio" name="job_effectiveness" value="1">
                                <div>1</div>
                            </div>
                            <div class="radio-label">
                                <input type="radio" name="job_effectiveness" value="2">
                                <div>2</div>
                            </div>
                            <div class="radio-label">
                                <input type="radio" name="job_effectiveness" value="3">
                                <div>3</div>
                            </div>
                            <div class="radio-label">
                                <input type="radio" name="job_effectiveness" value="4">
                                <div>4</div>
                            </div>
                            <div class="radio-label">
                                <input type="radio" name="job_effectiveness" value="5">
                                <div>5</div>
                            </div>
                        </div>
                    </div>
                    <div class="rating-comment">
                        <input type="text" class="comment-box" name="job_effectiveness_comment" placeholder="Comments">
                    </div>
                </div>

                <div class="rating-row">
                    <div class="rating-item">Commits the required effort to fulfill job responsibilities.</div>
                    <div class="rating-scale">
                        <div class="radio-group">
                            <div class="radio-label">
                                <input type="radio" name="effort_commitment" value="1">
                                <div>1</div>
                            </div>
                            <div class="radio-label">
                                <input type="radio" name="effort_commitment" value="2">
                                <div>2</div>
                            </div>
                            <div class="radio-label">
                                <input type="radio" name="effort_commitment" value="3">
                                <div>3</div>
                            </div>
                            <div class="radio-label">
                                <input type="radio" name="effort_commitment" value="4">
                                <div>4</div>
                            </div>
                            <div class="radio-label">
                                <input type="radio" name="effort_commitment" value="5">
                                <div>5</div>
                            </div>
                        </div>
                    </div>
                    <div class="rating-comment">
                        <input type="text" class="comment-box" name="effort_commitment_comment" placeholder="Comments">
                    </div>
                </div>

                <div class="rating-row">
                    <div class="rating-item">Aims to deliver high-quality work.</div>
                    <div class="rating-scale">
                        <div class="radio-group">
                            <div class="radio-label">
                                <input type="radio" name="quality_work" value="1">
                                <div>1</div>
                            </div>
                            <div class="radio-label">
                                <input type="radio" name="quality_work" value="2">
                                <div>2</div>
                            </div>
                            <div class="radio-label">
                                <input type="radio" name="quality_work" value="3">
                                <div>3</div>
                            </div>
                            <div class="radio-label">
                                <input type="radio" name="quality_work" value="4">
                                <div>4</div>
                            </div>
                            <div class="radio-label">
                                <input type="radio" name="quality_work" value="5">
                                <div>5</div>
                            </div>
                        </div>
                    </div>
                    <div class="rating-comment">
                        <input type="text" class="comment-box" name="quality_work_comment" placeholder="Comments">
                    </div>
                </div>
            </div>

            <!-- Management Focus -->
            <div class="form-section">
                <h3 class="section-title">Management Focus</h3>
                <p>Provides high-quality, professional, responsive, and innovative service to the customers of OCC.</p>

                <div class="rating-row">
                    <div class="rating-item">Listens to the customers and follows up on their requests and inquiries.</div>
                    <div class="rating-scale">
                        <div class="radio-group">
                            <div class="radio-label">
                                <input type="radio" name="customer_listening" value="1">
                                <div>1</div>
                            </div>
                            <div class="radio-label">
                                <input type="radio" name="customer_listening" value="2">
                                <div>2</div>
                            </div>
                            <div class="radio-label">
                                <input type="radio" name="customer_listening" value="3">
                                <div>3</div>
                            </div>
                            <div class="radio-label">
                                <input type="radio" name="customer_listening" value="4">
                                <div>4</div>
                            </div>
                            <div class="radio-label">
                                <input type="radio" name="customer_listening" value="5">
                                <div>5</div>
                            </div>
                        </div>
                    </div>
                    <div class="rating-comment">
                        <input type="text" class="comment-box" name="customer_listening_comment" placeholder="Comments">
                    </div>
                </div>

                <div class="rating-row">
                    <div class="rating-item">Maintains calm when dealing with angry managers or in challenging situations.</div>
                    <div class="rating-scale">
                        <div class="radio-group">
                            <div class="radio-label">
                                <input type="radio" name="handling_pressure" value="1">
                                <div>1</div>
                            </div>
                            <div class="radio-label">
                                <input type="radio" name="handling_pressure" value="2">
                                <div>2</div>
                            </div>
                            <div class="radio-label">
                                <input type="radio" name="handling_pressure" value="3">
                                <div>3</div>
                            </div>
                            <div class="radio-label">
                                <input type="radio" name="handling_pressure" value="4">
                                <div>4</div>
                            </div>
                            <div class="radio-label">
                                <input type="radio" name="handling_pressure" value="5">
                                <div>5</div>
                            </div>
                        </div>
                    </div>
                    <div class="rating-comment">
                        <input type="text" class="comment-box" name="handling_pressure_comment" placeholder="Comments">
                    </div>
                </div>

                <div class="rating-row">
                    <div class="rating-item">Strives to understand the deep needs of customers.</div>
                    <div class="rating-scale">
                        <div class="radio-group">
                            <div class="radio-label">
                                <input type="radio" name="customer_needs" value="1">
                                <div>1</div>
                            </div>
                            <div class="radio-label">
                                <input type="radio" name="customer_needs" value="2">
                                <div>2</div>
                            </div>
                            <div class="radio-label">
                                <input type="radio" name="customer_needs" value="3">
                                <div>3</div>
                            </div>
                            <div class="radio-label">
                                <input type="radio" name="customer_needs" value="4">
                                <div>4</div>
                            </div>
                            <div class="radio-label">
                                <input type="radio" name="customer_needs" value="5">
                                <div>5</div>
                            </div>
                        </div>
                    </div>
                    <div class="rating-comment">
                        <input type="text" class="comment-box" name="customer_needs_comment" placeholder="Comments">
                    </div>
                </div>
            </div>

            <!-- Technical Skills -->
            <div class="form-section">
                <h3 class="section-title">Engineering Skills</h3>
                <p>Engineering skills encompass the technical knowledge and practical abilities required to perform engineering tasks effectively.</p>

                <div class="rating-row">
                    <div class="rating-item">AUTOCAD</div>
                    <div class="rating-scale">
                        <div class="radio-group">
                            <div class="radio-label">
                                <input type="radio" name="autocad" value="1">
                                <div>1</div>
                            </div>
                            <div class="radio-label">
                                <input type="radio" name="autocad" value="2">
                                <div>2</div>
                            </div>
                            <div class="radio-label">
                                <input type="radio" name="autocad" value="3">
                                <div>3</div>
                            </div>
                            <div class="radio-label">
                                <input type="radio" name="autocad" value="4">
                                <div>4</div>
                            </div>
                            <div class="radio-label">
                                <input type="radio" name="autocad" value="5">
                                <div>5</div>
                            </div>
                        </div>
                    </div>
                    <div class="rating-comment">
                        <div class="radio-label">
                            <input type="checkbox" name="autocad_certified" value="yes">
                            <span>Certified</span>
                        </div>
                    </div>
                </div>

                <div class="rating-row">
                    <div class="rating-item">MICROSOFT OFFICE</div>
                    <div class="rating-scale">
                        <div class="radio-group">
                            <div class="radio-label">
                                <input type="radio" name="ms_office" value="1">
                                <div>1</div>
                            </div>
                            <div class="radio-label">
                                <input type="radio" name="ms_office" value="2">
                                <div>2</div>
                            </div>
                            <div class="radio-label">
                                <input type="radio" name="ms_office" value="3">
                                <div>3</div>
                            </div>
                            <div class="radio-label">
                                <input type="radio" name="ms_office" value="4">
                                <div>4</div>
                            </div>
                            <div class="radio-label">
                                <input type="radio" name="ms_office" value="5">
                                <div>5</div>
                            </div>
                        </div>
                    </div>
                    <div class="rating-comment">
                        <div class="radio-label">
                            <input type="checkbox" name="ms_office_certified" value="yes">
                            <span>Certified</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Personal Skills -->
            <div class="form-section">
                <h3 class="section-title">Personal Skills</h3>
                <p>Skills related to effective communication, teamwork, site management, and reading drawings.</p>

                <div class="rating-row">
                    <div class="rating-item">Reading All Design and Shop drawings</div>
                    <div class="rating-scale">
                        <div class="radio-group">
                            <div class="radio-label">
                                <input type="radio" name="reading_drawings" value="1">
                                <div>1</div>
                            </div>
                            <div class="radio-label">
                                <input type="radio" name="reading_drawings" value="2">
                                <div>2</div>
                            </div>
                            <div class="radio-label">
                                <input type="radio" name="reading_drawings" value="3">
                                <div>3</div>
                            </div>
                            <div class="radio-label">
                                <input type="radio" name="reading_drawings" value="4">
                                <div>4</div>
                            </div>
                            <div class="radio-label">
                                <input type="radio" name="reading_drawings" value="5">
                                <div>5</div>
                            </div>
                        </div>
                    </div>
                    <div class="rating-comment">
                        <input type="text" class="comment-box" name="reading_drawings_comment" placeholder="Comments">
                    </div>
                </div>

                <div class="rating-row">
                    <div class="rating-item">Site Management</div>
                    <div class="rating-scale">
                        <div class="radio-group">
                            <div class="radio-label">
                                <input type="radio" name="site_management" value="1">
                                <div>1</div>
                            </div>
                            <div class="radio-label">
                                <input type="radio" name="site_management" value="2">
                                <div>2</div>
                            </div>
                            <div class="radio-label">
                                <input type="radio" name="site_management" value="3">
                                <div>3</div>
                            </div>
                            <div class="radio-label">
                                <input type="radio" name="site_management" value="4">
                                <div>4</div>
                            </div>
                            <div class="radio-label">
                                <input type="radio" name="site_management" value="5">
                                <div>5</div>
                            </div>
                        </div>
                    </div>
                    <div class="rating-comment">
                        <input type="text" class="comment-box" name="site_management_comment" placeholder="Comments">
                    </div>
                </div>

                <div class="rating-row">
                    <div class="rating-item">Conveying Ideas</div>
                    <div class="rating-scale">
                        <div class="radio-group">
                            <div class="radio-label">
                                <input type="radio" name="conveying_ideas" value="1">
                                <div>1</div>
                            </div>
                            <div class="radio-label">
                                <input type="radio" name="conveying_ideas" value="2">
                                <div>2</div>
                            </div>
                            <div class="radio-label">
                                <input type="radio" name="conveying_ideas" value="3">
                                <div>3</div>
                            </div>
                            <div class="radio-label">
                                <input type="radio" name="conveying_ideas" value="4">
                                <div>4</div>
                            </div>
                            <div class="radio-label">
                                <input type="radio" name="conveying_ideas" value="5">
                                <div>5</div>
                            </div>
                        </div>
                    </div>
                    <div class="rating-comment">
                        <input type="text" class="comment-box" name="conveying_ideas_comment" placeholder="Comments">
                    </div>
                </div>
            </div>

            <!-- Overall Assessment -->
            <div class="form-section">
                <h3 class="section-title">Overall Assessment</h3>
                <div class="form-group">
                    <label for="overallRating">Overall Performance Rating (1-5):</label>
                    <input type="number" id="overallRating" name="overallRating" min="1" max="5" required>
                </div>
                <div class="form-group">
                    <label for="strengths">Key Strengths:</label>
                    <textarea id="strengths" name="strengths" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label for="development">Areas for Development:</label>
                    <textarea id="development" name="development" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label for="action_plan">Action Plan:</label>
                    <textarea id="action_plan" name="action_plan" rows="3"></textarea>
                </div>
            </div>

            <!-- Form Submission -->
            <div class="form-section">
                <h3 class="section-title">Signatures</h3>
                <div class="form-group">
                    <label for="evaluator_signature">Evaluator Signature:</label>
                    <input type="text" id="evaluator_signature" name="evaluator_signature" required>
                </div>
                <div class="form-group">
                    <label for="employee_signature">Employee Signature:</label>
                    <input type="text" id="employee_signature" name="employee_signature">
                </div>
                <div class="form-group">
                    <label for="review_date">Review Date:</label>
                    <input type="date" id="review_date" name="review_date" required>
                </div>
            </div>

            <div style="text-align: center; margin-top: 20px;">
                <button type="submit" class="btn">Submit Evaluation</button>
            </div>
        </form>
    </div>

    <footer>
        <p>&copy; 2025 Orion Contracting Co. All rights reserved.</p>
    </footer>


</body>
</html>
