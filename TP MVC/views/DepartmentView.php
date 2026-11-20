<?php

class DepartmentView
{
    public function render($data)
    {
        $header = "<tr>
            <th>ID</th>
            <th>DEPARTMENT NAME</th>
            <th>FACULTY</th>
            <th>ACCREDITATION</th>
            <th>ACTIONS</th>
        </tr>";

        $rows = "";
        foreach ($data as $row) {
            $rows .= "<tr>
                <th>{$row['id']}</th>
                <td>{$row['department_name']}</td>
                <td>{$row['faculty']}</td>
                <td><span class='badge bg-primary'>{$row['accreditation']}</span></td>
                <td>
                    <a class='btn btn-success btn-sm' href='department.php?id_edit={$row['id']}'>Edit</a>
                    <a class='btn btn-danger btn-sm' href='department.php?id_hapus={$row['id']}' onclick=\"return confirm('Hapus program studi ini?')\">Delete</a>
                </td>
            </tr>";
        }

        $tpl = new Template("templates/index.html");
        $tpl->replace("PAGE_TITLE", "Departments - Lecturers");
        $tpl->replace("NAV_LECTURER", "");
        $tpl->replace("NAV_DEPARTMENT", "active");
        $tpl->replace("NAV_COURSE", "");
        $tpl->replace("SECTION_HEADER", "Departments");
        $tpl->replace("ADD_LINK", "department.php?add_form=1");
        $tpl->replace("TABLE_HEADER", $header);
        $tpl->replace("TABLE_BODY", $rows);
        $tpl->write();
    }

    public function renderForm($department = null)
    {
        $isEdit = ($department !== null);
        $id = $isEdit ? $department['id'] : '';
        $department_name = $isEdit ? $department['department_name'] : '';
        $faculty = $isEdit ? $department['faculty'] : '';
        $accreditation = $isEdit ? $department['accreditation'] : '';

        $fields = ($isEdit ? "<input type='hidden' name='id' value='$id'>" : "") . "
            <div class='mb-3'>
                <label class='form-label'>DEPARTMENT NAME:</label>
                <input type='text' name='department_name' value='$department_name' class='form-control' required>
            </div>
            <div class='mb-3'>
                <label class='form-label'>FACULTY:</label>
                <input type='text' name='faculty' value='$faculty' class='form-control' required>
            </div>
            <div class='mb-3'>
                <label class='form-label'>ACCREDITATION:</label>
                <input type='text' name='accreditation' value='$accreditation' class='form-control' required>
            </div>
        ";

        $tpl = new Template("templates/form.html");
        $tpl->replace("PAGE_TITLE", $isEdit ? "Update Department" : "Create Department");
        $tpl->replace("NAV_LECTURER", "");
        $tpl->replace("NAV_DEPARTMENT", "active");
        $tpl->replace("NAV_COURSE", "");
        $tpl->replace("FORM_ACTION", "department.php");
        $tpl->replace("CARD_COLOR", $isEdit ? "bg-warning" : "bg-primary");
        $tpl->replace("FORM_TITLE", $isEdit ? "Update Department" : "Create Department");
        $tpl->replace("FORM_FIELDS", $fields);
        $tpl->replace("SUBMIT_NAME", $isEdit ? "update" : "add");
        $tpl->replace("CANCEL_LINK", "department.php");
        $tpl->write();
    }
}