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

namespace Tygh\Ym;

class CronYml extends Yml
{

    public function get()
    {

        $filename = $this->getFileName();

        if (!file_exists($filename) || $this->debug) {
            $this->generate($filename);
        }

        return $filename;
    }

    public function getFileName()
    {
        $path = sprintf('%syandex_market/%s_yandex_market_%s.yml',
            fn_get_files_dir_path(),
            $this->company_id,
            date('dmY')
        );

        return $path;
    }

}
