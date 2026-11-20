<?php

class LecturerView
{
    public function render($data)
    {
        $header = "<tr>
            <th>ID</th>
            <th>NAME</th>
            <th>NIDN</th>
            <th>DEPARTMENT</th>
            <th>PHONE</th>
            <th>JOIN DATE</th>
            <th>ACTIONS</th>
        </tr>";

        $rows = "";
        foreach ($data as $row) {
            $rows .= "<tr>
                <th>{$row['id']}</th>
                <td>{$row['name']}</td>
                <td>{$row['nidn']}</td>
                <td>{$row['department_name']} ({$row['faculty']})</td>
                <td>{$row['phone']}</td>
                <td>{$row['join_date']}</td>
                <td>
                    <a class='btn btn-success btn-sm' href='index.php?id_edit={$row['id']}'>Edit</a>
                    <a class='btn btn-danger btn-sm' href='index.php?id_hapus={$row['id']}' onclick=\"return confirm('Hapus data dosen ini?')\">Delete</a>
                </td>
            </tr>";
        }

        $tpl = new Template("templates/index.html");
        $tpl->replace("PAGE_TITLE", "Home - Lecturers");
        $tpl->replace("NAV_LECTURER", "active");
        $tpl->replace("NAV_DEPARTMENT", "");
        $tpl->replace("NAV_COURSE", "");
        $tpl->replace("SECTION_HEADER", "Lecturers");
        $tpl->replace("ADD_LINK", "index.php?add_form=1");
        $tpl->replace("TABLE_HEADER", $header);
        $tpl->replace("TABLE_BODY", $rows);
        $tpl->write();
    }

    public function renderForm($departments, $lecturer = null)
    {
        $isEdit = ($lecturer !== null);
        $id = $isEdit ? $lecturer['id'] : '';
        $name = $isEdit ? $lecturer['name'] : '';
        $nidn = $isEdit ? $lecturer['nidn'] : '';
        $phone = $isEdit ? $lecturer['phone'] : '';
        $join_date = $isEdit ? $lecturer['join_date'] : '';
        $selectedDept = $isEdit ? $lecturer['department_id'] : '';

        $deptOptions = "";
        foreach ($departments as $d) {
            $sel = ($d['id'] == $selectedDept) ? "selected" : "";
            $deptOptions .= "<option value='{$d['id']}' $sel>{$d['department_name']} - {$d['faculty']}</option>";
        }

        $fields = ($isEdit ? "<input type='hidden' name='id' value='$id'>" : "") . "
            <div class='mb-3'>
                <label class='form-label'>NAME:</label>
                <input type='text' name='name' value='$name' class='form-control' required>
            </div>
            <div class='mb-3'>
                <label class='form-label'>NIDN:</label>
                <input type='text' name='nidn' value='$nidn' class='form-control' required>
            </div>
            <div class='mb-3'>
                <label class='form-label'>DEPARTMENT:</label>
                <select name='department_id' class='form-select' required>
                    <option value=''>-- Select Department --</option>
                    $deptOptions
                </select>
            </div>
            <div class='mb-3'>
                <label class='form-label'>PHONE:</label>
                <input type='text' name='phone' value='$phone' class='form-control' required>
            </div>
            <div class='mb-3'>
                <label class='form-label'>JOIN DATE:</label>
                <input type='date' name='join_date' value='$join_date' class='form-control' required>
            </div>
        ";

        $tpl = new Template("templates/form.html");
        $tpl->replace("PAGE_TITLE", $isEdit ? "Update Lecturer" : "Create Lecturer");
        $tpl->replace("NAV_LECTURER", "active");
        $tpl->replace("NAV_DEPARTMENT", "");
        $tpl->replace("NAV_COURSE", "");
        $tpl->replace("FORM_ACTION", "index.php");
        $tpl->replace("CARD_COLOR", $isEdit ? "bg-warning" : "bg-primary");
        $tpl->replace("FORM_TITLE", $isEdit ? "Update Lecturer" : "Create Lecturer");
        $tpl->replace("FORM_FIELDS", $fields);
        $tpl->replace("SUBMIT_NAME", $isEdit ? "update" : "add");
        $tpl->replace("CANCEL_LINK", "index.php");
        $tpl->write();
    }
}