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
            }
            catch (Exception $e) {
                print $e->getMessage();
            }
        }
        
        public function load()
        {
            try {
                $rows = '';
                foreach (Person::all() as $person) {
                    $row = file_get_contents('html/row.html');
                    
                    $row = str_replace(['{id}', '{name}', '{address}', '{district}', '{phone}', '{mail}', '{id_city}'], [$person['id'], $person['name'], $person['address'], $person['district'], $person['phone'], $person['mail'], $person['id_city']], $row);
                    $rows .= $row;
                }
                $this->html = str_replace(
                    '{rows}',
                    $rows,
                    $this->html
                );
            }
            catch (Exception $e) {
                print $e->getMessage();
            }
        }
        
        public function show()
        {
            $this->load();
            print $this->html;
        }
        
    }
