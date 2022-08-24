<?php

require_once __DIR__ . '/classes/Person.php';

class PersonForm
{
    private $html;
    private $data;

    public function __construct()
    {
        $this->html = file_get_contents('html/form.html');
        $this->data = [
            'id' => null,
            'first_name' => null,
            'last_name' => null,
            'zipcode' => null,
            'address' => null,
            'number' => null,
            'complement' => null,
            'district' => null,
            'city' => null,
            'state' => null,
            'phone' => null,
            'mail' => null
        ];
    }
    public function edit($param)
    {
        try {
            $id = (int)$param['id'];
            $person = Person::find($id);
            $this->data = $person;
        } catch (Exception $e) {
            print $e->getMessage();
        }
    }

    public function save($param)
    {
        try {
            Person::save($param);
            $this->data = $param;
            print "<div class='trigger trigger-sucess center'><p>Pessoa salva com Sucesso!</p></div>";
        } catch (Exception $e) {
            print $e->getMessage();
        }
    }

    public function show()
    {

        $this->html = str_replace(
            [
                '{id}',
                '{first_name}',
                '{last_name}',
                '{zipcode}',
                '{address}',
                '{number}',
                '{complement}',
                '{district}',
                '{city}',
                '{state}',
                '{phone}',
                '{mail}'
            ],
            [
                $this->data['id'],
                $this->data['first_name'],
                $this->data['last_name'],
                $this->data['zipcode'],
                $this->data['address'],
                $this->data['number'],
                $this->data['complement'],
                $this->data['district'],
                $this->data['city'],
                $this->data['state'],
                $this->data['phone'],
                $this->data['mail']
            ],
            $this->html
        );

        print  $this->html;
    }
}
