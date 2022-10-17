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
                    <a href="#!">View Exam</a>
                </li>
                <li>
                    <a href="#!">Take Exam</a>
                </li>
                <li>
                    <a href="#!">Grades</a>
                </li>
                <li>
                    <a href="#!">Logout</a>
                </li>
            <?php endif; ?>
            <?php if (has_role("Teacher")): ?>
                <li>
                    <a href="#!">Make Questions</a>
                </li>
                <li>
                    <a href="#!">Make Exam</a>
                </li>
                <li>
                    <a href="#!">View Exam</a>
                </li>
                <li>
                    <a href="#!">Logout</a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</section>