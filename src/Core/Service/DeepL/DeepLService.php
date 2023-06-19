<?php

namespace NiceModules\Core\Service\DeepL;

use DeepL\DeepLException;
use DeepL\Translator;
use NiceModules\Core\Config;
use NiceModules\Core\Logger;
use NiceModules\Core\I18n\InterfaceI18n;

class DeepLService
{
    protected string $apiKey;
    protected Translator $translator;

    /**
     * @throws DeepLException
     */
    public function __construct()
    {
        $this->apiKey = Config::instance('core')->get('deepl_api_key');
        $this->translator = new Translator($this->apiKey);
    }

    /**
     * @param $text
     * @param $locale
     * @return string
     * @throws DeepLException
     */
    public function get($text, $sourceLanguage, $targetLanguage): string
    {
        $textResult = $this->translator->translateText($text, $sourceLanguage, $targetLanguage);

        Logger::add('DeepL translated "' . $text . '"in '.$sourceLanguage.' to "' . $textResult->text . '" in ' . $targetLanguage, 'DeepL service');

        return $textResult->text;
    }
}