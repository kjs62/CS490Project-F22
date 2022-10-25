<?php
session_start();
function has_role($role){
    if (isset($_SESSION["user"])){
        if ($_SESSION["role"] == $role){
            return true;
        }
        else{
            return false;
        }
    }
    return false;
}
?>
<section class="navigation">
    <div class="nav-container">
        <ul class="nav">
            <?php if (has_role("Student")): ?>
                <li>
                    <a href="takeExam.php">Take Exam</a>
                </li>
                <li>
                    <a href="studentGrades.php">Grades</a>
                </li>
                <li>
                    <a href="logout.php">Logout</a>
                </li>
            <?php endif; ?>
            <?php if (has_role("Teacher")): ?>
                <li>
                    <a href="teacherMakeQuestion.php">Make Questions</a>
                </li>
                <li>
                    <a href="teacherMakeExams.php">Make Exam</a>
                </li>
                <li>
                    <a href="teacherViewExams.php">View Exam</a>
                </li>
                <li>
                    <a href="logout.php">Logout</a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</section>