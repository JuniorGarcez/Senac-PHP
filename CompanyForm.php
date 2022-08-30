<?php

require_once __DIR__ . '/classes/Company.php';

class CompanyForm
{
    private $html;
    private $data;

    public function __construct()
    {
        $this->html = file_get_contents('html/company/companyForm.html');
        $this->data = [
            'id' => null,
            'company_cnpj' => null,
            'company_name' => null,
            'company_fantasy' => null,
            'company_phone' => null,
            'company_street' => null,
            'company_number' => null,
            'company_complement' => null,
            'company_district' => null,
            'company_zipcode' => null,
            'company_city' => null,
            'company_state' => null,
            'company_country' => null
        ];
    }
    public function edit($param)
    {
        try {
            $id = (int)$param['id'];
            $company = Company::find($id);
            $this->data = $company;
        } catch (Exception $e) {
            print $e->getMessage();
        }
    }

    public function save($param)
    {
        try {
            Company::save($param);
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
                '{company_cnpj}',
                '{company_name}',
                '{company_fantasy}',
                '{company_phone}',
                '{company_street}',
                '{company_number}',
                '{company_complement}',
                '{company_district}',
                '{company_zipcode}',
                '{company_city}',
                '{company_state}',
                '{company_country}'
            ],
            [
                $this->data['id'],
                $this->data['company_cnpj'],
                $this->data['company_name'],
                $this->data['company_fantasy'],
                $this->data['company_phone'],
                $this->data['company_street'],
                $this->data['company_number'],
                $this->data['company_complement'],
                $this->data['company_district'],
                $this->data['company_zipcode'],
                $this->data['company_city'],
                $this->data['company_state'],
                $this->data['company_country']
            ],
            $this->html
        );

        print  $this->html;
    }
}
