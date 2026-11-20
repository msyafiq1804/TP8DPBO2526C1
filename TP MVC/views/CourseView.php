<?php

class CourseView
{
    public function render($data)
    {
        $header = "<tr>
            <th>ID</th>
            <th>COURSE CODE</th>
            <th>COURSE NAME</th>
            <th>CREDITS (SKS)</th>
            <th>LECTURER</th>
            <th>ACTIONS</th>
        </tr>";

        $rows = "";
        foreach ($data as $row) {
            $rows .= "<tr>
                <th>{$row['id']}</th>
                <td><span class='badge bg-secondary'>{$row['course_code']}</span></td>
                <td>{$row['course_name']}</td>
                <td>{$row['credits']} SKS</td>
                <td>{$row['lecturer_name']}</td>
                <td>
                    <a class='btn btn-success btn-sm' href='course.php?id_edit={$row['id']}'>Edit</a>
                    <a class='btn btn-danger btn-sm' href='course.php?id_hapus={$row['id']}' onclick=\"return confirm('Hapus mata kuliah ini?')\">Delete</a>
                </td>
            </tr>";
        }

        $tpl = new Template("templates/index.html");
        $tpl->replace("PAGE_TITLE", "Courses - Lecturers");
        $tpl->replace("NAV_LECTURER", "");
        $tpl->replace("NAV_DEPARTMENT", "");
        $tpl->replace("NAV_COURSE", "active");
        $tpl->replace("SECTION_HEADER", "Courses");
        $tpl->replace("ADD_LINK", "course.php?add_form=1");
        $tpl->replace("TABLE_HEADER", $header);
        $tpl->replace("TABLE_BODY", $rows);
        $tpl->write();
    }

    public function renderForm($lecturers, $course = null)
    {
        $isEdit = ($course !== null);
        $id = $isEdit ? $course['id'] : '';
        $course_code = $isEdit ? $course['course_code'] : '';
        $course_name = $isEdit ? $course['course_name'] : '';
        $credits = $isEdit ? $course['credits'] : '';
        $selectedLecturer = $isEdit ? $course['lecturer_id'] : '';

        $lecturerOptions = "";
        foreach ($lecturers as $lec) {
            $sel = ($lec['id'] == $selectedLecturer) ? "selected" : "";
            $lecturerOptions .= "<option value='{$lec['id']}' $sel>{$lec['name']}</option>";
        }

        $fields = ($isEdit ? "<input type='hidden' name='id' value='$id'>" : "") . "
            <div class='mb-3'>
                <label class='form-label'>COURSE CODE:</label>
                <input type='text' name='course_code' value='$course_code' class='form-control' required>
            </div>
            <div class='mb-3'>
                <label class='form-label'>COURSE NAME:</label>
                <input type='text' name='course_name' value='$course_name' class='form-control' required>
            </div>
            <div class='mb-3'>
                <label class='form-label'>CREDITS (SKS):</label>
                <input type='number' name='credits' value='$credits' class='form-control' required>
            </div>
            <div class='mb-3'>
                <label class='form-label'>LECTURER:</label>
                <select name='lecturer_id' class='form-select' required>
                    <option value=''>-- Select Lecturer --</option>
                    $lecturerOptions
                </select>
            </div>
        ";

        $tpl = new Template("templates/form.html");
        $tpl->replace("PAGE_TITLE", $isEdit ? "Update Course" : "Create Course");
        $tpl->replace("NAV_LECTURER", "");
        $tpl->replace("NAV_DEPARTMENT", "");
        $tpl->replace("NAV_COURSE", "active");
        $tpl->replace("FORM_ACTION", "course.php");
        $tpl->replace("CARD_COLOR", $isEdit ? "bg-warning" : "bg-primary");
        $tpl->replace("FORM_TITLE", $isEdit ? "Update Course" : "Create Course");
        $tpl->replace("FORM_FIELDS", $fields);
        $tpl->replace("SUBMIT_NAME", $isEdit ? "update" : "add");
        $tpl->replace("CANCEL_LINK", "course.php");
        $tpl->write();
    }
}