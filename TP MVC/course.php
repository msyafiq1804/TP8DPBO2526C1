<?php
include_once("controllers/CourseController.php");

$controller = new CourseController();

if (isset($_POST['add'])) {
    $controller->add($_POST);
} elseif (isset($_POST['update'])) {
    $controller->update($_POST);
} elseif (!empty($_GET['id_hapus'])) {
    $controller->delete($_GET['id_hapus']);
} elseif (!empty($_GET['id_edit'])) {
    $controller->formEdit($_GET['id_edit']);
} elseif (!empty($_GET['add_form'])) {
    $controller->formAdd();
} else {
    $controller->index();
}