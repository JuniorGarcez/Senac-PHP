<?php

require_once __DIR__ . '/classes/Company.php';

class CompanyList
{
    private $html;

    public function __construct()
    {
        $this->html = file_get_contents('html/company/companyList.html');
    }

    public function delete($param)
    {
        try {
            $id = (int)$param['id'];
            Company::delete($id);
        } catch (Exception $e) {
            print $e->getMessage();
        }
    }

    public function load()
    {
        try {
            $rows = '';
            foreach (Company::all() as $company) {
                $row = file_get_contents('html/company/companyRow.html');

                $row = str_replace(
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
                        $company['id'],
                        $company['company_cnpj'],
                        $company['company_name'],
                        $company['company_fantasy'],
                        $company['company_phone'],
                        $company['company_street'],
                        $company['company_number'],
                        $company['company_complement'],
                        $company['company_district'],
                        $company['company_zipcode'],
                        $company['company_city'],
                        $company['company_state'],
                        $company['company_country']
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
