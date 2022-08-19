<?php
    
    require_once __DIR__ . '/classes/Person.php';
    require_once __DIR__ . '/classes/City.php';
    
    class PersonForm
    {
        private $html;
        private $data;
        
        public function __construct()
        {
            $this->html = file_get_contents('html/form.html');
            $this->data = ['id' => null, 'name' => null, 'address' => null, 'district' => null, 'phone' => null, 'mail' => null, 'id_city' => null];
            
            $cities = "<option value='' selected disabled>SELECIONE A CIDADE:</option>";
            foreach (City::all() as $city) {
                $cities .= "<option value='{$city['id']}'>{$city['name']}</option>\n";
            }
            $this->html = str_replace('{cities}', $cities, $this->html);
        }
        
        public function edit($param)
        {
            try {
                $id = (int)$param['id'];
                $person = Person::find($id);
                $this->data = $person;
            }
            catch (Exception $e) {
                print $e->getMessage();
            }
        }
        
        public function save($param)
        {
            try {
                Person::save($param);
                $this->data = $param;
                print "<div class='trigger trigger-sucess center'><p>Pessoa salva com Sucesso!</p></div>";
            }
            catch (Exception $e) {
                print $e->getMessage();
            }
        }
        
        public function show()
        {
            
            $this->html = str_replace(
                ['{id}','{name}','{address}','{district}','{phone}','{mail}','{id_city}'],
                [
                    $this->data['id'],
                    $this->data['name'],
                    $this->data['address'],
                    $this->data['district'],
                    $this->data['phone'],
                    $this->data['mail'],
                    $this->data['id_city']
                ],
                $this->html
            );
            $this->html = str_replace(
                "option value='{$this->data['id_city']}'",
                "option selected=1 value='{$this->data['id_city']}'", $this->html
            );
           
            print  $this->html;
            
        }
        
    }
