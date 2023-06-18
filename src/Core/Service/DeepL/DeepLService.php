<?php

namespace NiceModules\Core\Service\DeepL;

use DeepL\DeepLException;
use DeepL\Translator;
use NiceModules\Core\Lang;
use NiceModules\Core\Logger;

class DeepLService
{
    protected $apiKey = '####';
    protected Translator $translator;

    /**
     * @throws DeepLException
     */
    public function __construct()
    {
        $this->translator = new Translator($this->apiKey);
    }

    /**
     * @param $text
     * @param $locale
     * @return string
     * @throws DeepLException
     */
    public function get($text, $locale): string
    {
        $textResult = $this->translator->translateText($text, Lang::DEFAULT_LANG, $locale);

        Logger::add('DeepL Translated "' . $text . '" to "' . $textResult->text . '" in ' . $locale, 'DeepL service');

        return $textResult->text;
    }
}