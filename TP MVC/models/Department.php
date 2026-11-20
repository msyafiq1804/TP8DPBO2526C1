<?php

class Department extends DB
{
    public function getDepartment()
    {
        $query = "SELECT * FROM departments ORDER BY id ASC";
        return $this->execute($query);
    }

    public function getDepartmentById($id)
    {
        $id = (int)$id;
        $query = "SELECT * FROM departments WHERE id = $id";
        $this->execute($query);
        return $this->getResult();
    }

    public function add($data)
    {
        $department_name = $this->escape($data['department_name']);
        $faculty = $this->escape($data['faculty']);
        $accreditation = $this->escape($data['accreditation']);

        $query = "INSERT INTO departments (department_name, faculty, accreditation) 
                  VALUES ('$department_name', '$faculty', '$accreditation')";
        return $this->execute($query);
    }

    public function update($data)
    {
        $id = (int)$data['id'];
        $department_name = $this->escape($data['department_name']);
        $faculty = $this->escape($data['faculty']);
        $accreditation = $this->escape($data['accreditation']);

        $query = "UPDATE departments SET 
                  department_name = '$department_name', 
                  faculty = '$faculty', 
                  accreditation = '$accreditation' 
                  WHERE id = $id";
        return $this->execute($query);
    }

    public function delete($id)
    {
        $id = (int)$id;
        $query = "DELETE FROM departments WHERE id = $id";
        return $this->execute($query);
    }
}