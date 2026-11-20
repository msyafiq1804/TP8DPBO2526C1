<?php

class Lecturer extends DB
{
    public function getLecturer()
    {
        $query = "SELECT lecturers.*, departments.department_name, departments.faculty 
                  FROM lecturers 
                  JOIN departments ON lecturers.department_id = departments.id 
                  ORDER BY lecturers.id ASC";
        return $this->execute($query);
    }

    public function getLecturerById($id)
    {
        $id = (int)$id;
        $query = "SELECT * FROM lecturers WHERE id = $id";
        $this->execute($query);
        return $this->getResult();
    }

    public function add($data)
    {
        $name = $this->escape($data['name']);
        $nidn = $this->escape($data['nidn']);
        $phone = $this->escape($data['phone']);
        $join_date = $this->escape($data['join_date']);
        $department_id = (int)$data['department_id'];

        $query = "INSERT INTO lecturers (name, nidn, phone, join_date, department_id) 
                  VALUES ('$name', '$nidn', '$phone', '$join_date', $department_id)";
        return $this->execute($query);
    }

    public function update($data)
    {
        $id = (int)$data['id'];
        $name = $this->escape($data['name']);
        $nidn = $this->escape($data['nidn']);
        $phone = $this->escape($data['phone']);
        $join_date = $this->escape($data['join_date']);
        $department_id = (int)$data['department_id'];

        $query = "UPDATE lecturers SET 
                  name = '$name', 
                  nidn = '$nidn', 
                  phone = '$phone', 
                  join_date = '$join_date', 
                  department_id = $department_id 
                  WHERE id = $id";
        return $this->execute($query);
    }

    public function delete($id)
    {
        $id = (int)$id;
        $query = "DELETE FROM lecturers WHERE id = $id";
        return $this->execute($query);
    }
}