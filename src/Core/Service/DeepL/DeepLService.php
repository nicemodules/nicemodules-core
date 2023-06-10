<?php

namespace NiceModules\Core\Service\DeepL;

use DeepL\DeepLException;
use DeepL\Translator;
use NiceModules\Core\Lang;

class DeepLService
{
    protected $apiKey = '24c73be6-01b8-d15e-45b4-e6c8d2046bf8:fx';
    protected Translator $translator;

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
        
        return $textResult->text;
    }
}