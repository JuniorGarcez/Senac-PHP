<?php

require_once __DIR__ . '/classes/Person.php';

class PersonList
{
    private $html;

    public function __construct()
    {
        $this->html = file_get_contents('html/list.html');
    }

    public function delete($param)
    {
        try {
            $id = (int)$param['id'];
            Person::delete($id);
        } catch (Exception $e) {
            print $e->getMessage();
        }
    }

    public function load()
    {
        try {
            $rows = '';
            foreach (Person::all() as $person) {
                $row = file_get_contents('html/row.html');

                $row = str_replace(
                    [
                        '{id}',
                        '{first_name}',
                        '{last_name}',
                        '{city}',
                        '{state}',
                        '{phone}',
                    ],
                    [
                        $person['id'],
                        $person['first_name'],
                        $person['last_name'],
                        $person['city'],
                        $person['state'],
                        $person['phone'],
                    ],
                    $row
                );
                $rows .= $row;
            }
            $this->html = str_replace(
                '{rows}',
                $rows,
                $this->html
            );
        } catch (Exception $e) {
            print $e->getMessage();
        }
    }

    public function show()
    {
        $this->load();
        print $this->html;
    }
}
