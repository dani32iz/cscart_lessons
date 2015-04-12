<?php
/***************************************************************************
 *                                                                          *
 *   (c) 2004 Vladimir V. Kalynyak, Alexey V. Vinokurov, Ilya M. Shalnev    *
 *                                                                          *
 * This  is  commercial  software,  only  users  who have purchased a valid *
 * license  and  accept  to the terms of the  License Agreement can install *
 * and use this program.                                                    *
 *                                                                          *
 ****************************************************************************
 * PLEASE READ THE FULL TEXT  OF THE SOFTWARE  LICENSE   AGREEMENT  IN  THE *
 * "copyright.txt" FILE PROVIDED WITH THIS DISTRIBUTION PACKAGE.            *
 ****************************************************************************/

namespace Tygh\YImport;

use Tygh\Registry;

class Import
{

    // Тип цены.
    public $price_type;

    /**
     * Значение количества товара по умолчанию
     * Используется если в XML нет числовой информации о количестве товара,
     * а есть только available true или false
     */
    public $default_stock = 10;

    // Объект XML .
    public $xml;
    // Путь к файлу
    public $path;
    // Компания из XML, используется в названиях журналов.
    public $yml_company;

    // Указатель файла журнала импорта
    public $log;
    // Папка журнала импорта
    public $log_dir;
    // Имя файла журнала импорта
    public $log_file;
    // Заголовки журнала импорта
    public $log_header = array('offer_id','product_id','amount','price');

    // Разделитель CSV журнала
    public $log_delimeter = ';';

    // Указатель файла журнала ошибок
    public $errors;
    // Имя файла журнала ошибок
    public $errors_file;
    // Заголовки файла журнала ошибок
    public $errors_header = array('type','error');

    // Валюты из XML
    public $currencies = array();
    // Валюты магазина
    public $main_currencies = array();
    // Информация о товаре
    public $offer_data = array();

    // Счётчик .
    public $processed_data = array(
            'new' => 0,
            'exist' => 0,
            'skipped' => 0,
            'total' => 0
        );

    /**
     * Подготовка к импорту.
     * @param string $path Путь или URL к xml файлу.
     * @param string $price_type Тип цены (необязательно), если несколько цен на каждый товар.
     */
    public function __construct($path, $price_type = false)
    {

        $this->path = $path;
        $this->price_type = $price_type;
        $this->main_currencies = Registry::get('currencies');

        $this->xml = new \XMLReader();

        libxml_use_internal_errors(true);

        $this->xml->open($path);
    }

    /**
     * Завершение импорта
     */
    public function __destruct()
    {
        $this->xml->close();

        if(!empty($this->log)) {
            fclose($this->log);
        }

        $this->errorsXml();

        if(!empty($this->errors)) {
            fclose($this->errors);   
        }

        $this->saveSession();
    }

    /**
     * Запуск импорта
     */
    public function run()
    {

        $this->read();

    }

    /**
     * Чтение XML
     */
    public function read()
    {
fn_print_die(1);
        while ($this->xml->read()) {

            if ($this->xml->nodeType == \XMLReader::ELEMENT){

                if ($this->xml->localName == 'company') {
                    $this->processCompany();
                }

                if ($this->xml->localName == 'currency') {
                    $this->processCurrencies();
                }

                if ($this->xml->localName == 'offer') {
                    $this->processOffer();
                }      
            }
        }     

    }

    /**
     * Обработка валют.
     */
    public function processCurrencies()
    {

        if($this->xml->hasAttributes) {
            $id = $this->xml->getAttribute('id');
            if (!empty($id)) {
                while($this->xml->moveToNextAttribute()) {
                    $this->currencies[$id][$this->xml->name] = $this->xml->value; 
                }                                
            }
        }

    }

    /**
     * Получаем информацию о компании из XML
     */
    public function processCompany()
    {

        if (empty($this->yml_company)) {
            $this->xml->read();
            $this->yml_company = $this->xml->value; 
        }

    }

    /**
     * Обработка информации о товаре
     */
    public function processOffer()
    {

        if ($this->checkOffer()) {
            $this->processed_data['total']++;

            $this->getProductId();

            if ($this->offer_data['product_id']) {
                $this->processed_data['exist']++;

                $this->getOfferData();
                $this->updateProduct();                 
            }

            $this->offer_data = array();
        }

    }

    /**
     * Проверка товара. Проверяем есть ли в XML информация об id товара.
     */
    public function checkOffer()
    {

        $result = false;

        if ($this->xml->hasAttributes) {

            $offer_id = $this->xml->getAttribute('id');

            if (!empty($offer_id)) {
                $this->offer_data['offer_id'] = $offer_id;
                $result = true;
            }
        }

        return $result;
    }

    /**
     * Получаем product_id по offer_id
     */
    public function getProductId()
    {

        $this->offer_data['product_id'] = db_get_field("SELECT product_id FROM ?:yml_import_objects WHERE offer_id = ?s", $this->offer_data['offer_id']);

    }

    /**
     * Обрабатываем информацию о товаре
     */
    public function getOfferData()
    {

        $offer = @simplexml_load_string($this->xml->readOuterXML());

        $this->getOfferStock($offer);

        $this->getOfferPrice($offer);

        //$this->getOfferFeatures($offer);

    }

    /**
     * Обновляем товар
     */
    public function updateProduct()
    {

        $product_id = fn_update_product($this->offer_data, $this->offer_data['product_id']);      

        $this->offer_data['product_id'] = $product_id;

        $this->logWrite();

    }

    /**
     * Запись информации в журнал импорта
     */
    public function logWrite()
    {

        if (empty($this->log)) {
            $this->logCreate();
        } 

        $save_data = array();

        foreach($this->log_header as $column) {

            if (isset($this->offer_data[$column])){
                $string[] = $this->offer_data[$column];
            } else {
                $string[] = 'empty';
            }    

        }

        $string = implode($this->log_delimeter, $string);

        fputs($this->log, $string . "\r\n");

    }

    /**
     * Получаем остатки из XML 
     */
    public function getOfferStock($offer)
    {

        if (isset($offer->Attributes()->available)) {

            $available = (string) $offer->Attributes()->available;

            if ($available == 'true') {
                $this->offer_data['amount'] = $this->default_stock;
            } else {
                $this->offer_data['amount'] = 0;
            }
        }

        if (isset($offer->Stock)) {
            $this->offer_data['amount'] = preg_replace('/[^0-9]/', '', (string) $offer->Stock);
        }

    }

    /**
     * Получаем цену товара из XML 
     */
    public function getOfferPrice($offer)
    {

        if(isset($offer->prices->price) && !empty($offer->prices->price)) {
            $type = $this->price_type;

            foreach ($offer->prices->price as $key => $value) {
                $type = (string) $value['type'];

                if ($type == $this->price_type) {
                    $price = (string) $value;
                    $currency = (string) $value['currencyId'];  
                }
            }
        }

        if (isset($offer->price) && isset($offer->currencyId)) {
            $price = (string) $offer->price;
            $currency = (string) $offer->currencyId;
        }

        if (!empty($price) && !empty($currency)) {
            $this->convertPrice($price, $currency);
        } else {
            $this->errorsWrite('price', $this->offer_data['offer_id']);
        }
        
    }

    /**
     * Конвертация цены по курсам валюты.
     */
    public function convertPrice($price, $currency)
    {

        $rate = $this->currencies[$currency]['rate'];

        if ($currency == CART_PRIMARY_CURRENCY) {

            $this->offer_data['price'] = $price * $rate;

        } else {

            if (array_key_exists($currency, $this->main_currencies)) {
                $coefficient = $this->main_currencies[$currency]['coefficient'];
                $this->offer_data['price'] = fn_format_price($price * $coefficient * $rate);

            } else {
                $this->errorsWrite('currency', $this->offer_data['offer_id']);
            }

        }

    }

    /**
     * Получаем значения характеристик
     */
    public function getOfferFeatures($offer)
    {

        if (isset($offer->Param)) {
            foreach ($offer->Param as $key => $value) {
                if (isset($value['name'])) {
                    $name = (string) $value['name'];
                    $this->offer_data['features'][$name] = (string) $value;                    
                }
            } 
        }
    }



    /**
     * Обработка ошибок XML
     */
    public function errorsXml()
    {

        $errors = libxml_get_errors();

        foreach ($errors as $error) {
            $string_error = 'Line ' . $error->line . ' : ' . $error->message;
            $this->errorsWrite('xml', $string_error);
        }

    }

    /**
     * Запись ошибок в файл
     * @param string $type Тип ошибки.
     * @param string $string_error Сообщение.
     */
    public function errorsWrite($type, $string_error)
    {

        if (empty($this->errors)) {
            $this->logCreate('errors');
        } 

        $string = $type . $this->log_delimeter . $string_error . "\r\n";

        fputs($this->errors, $string);

    }

    /**
     * Создаём файл журнала импорта
     * @param string $type Тип файла import (процесс импорта) или errors (журнал ошибок)
     */
    public function logCreate($type = 'import')
    {

        $dir = fn_get_files_dir_path();
        $dir .= 'yml_import/';
        $this->log_dir = $dir;
        fn_mkdir($this->log_dir);

        $filename = str_replace(' ', '_', $this->yml_company);
        $filename .= '_' . date('Y-m-d_H:i:s', TIME);

        if ($type == 'import') {

            $filename .= '.csv';
            $this->log_file = $filename;

            $this->log = fopen($this->log_dir . $this->log_file, 'a');

            fputs($this->log, implode($this->log_delimeter, $this->log_header) . "\r\n");

        } elseif ($type == 'errors') {

            $filename .= '.errors.csv';
            $this->errors_file = $filename;

            $this->errors = fopen($this->log_dir . $this->errors_file, 'a');

            fputs($this->errors, implode($this->log_delimeter, $this->errors_header) . "\r\n");

        }

    }

    /**
     * Сохраняем ссылки на результаты импорта
     */
    public function saveSession()
    {

        if(!empty($this->log_file)) {
            fn_set_session_data('yml_import_log', $this->log_file);
        } else {
            fn_delete_session_data('yml_import_log');
        }

        if(!empty($this->errors_file)) {
            fn_set_session_data('yml_import_errors', $this->errors_file);
        } else {
            fn_delete_session_data('yml_import_errors');
        }

    }

}
