<?php

namespace NiceModules\Core\I18n;

use NiceModules\Core\I18n;
use NiceModules\ORM\I18nService;

class OrmI18n extends I18n implements I18nService
{
    const DEFAULT_LANGUAGE = 'EN';

    /**
     * Current language
     * @var string
     */
    protected string $language;

    public function __construct(string $language)
    {
        parent::__construct($language);
    }


    /**
     * @param string $text
     * @return string
     * @throws \DeepL\DeepLException
     */
    public function translateDefaultToCurrent(string $text): string
    {
        if ($this->service && $this->needTranslation()) {
            try {
                return $this->service->get($text, self::DEFAULT_LANGUAGE, $this->language);
            } catch (Throwable $e) {
                Logger::add($e->getMessage(), __CLASS__, Logger::ERROR);
                return $text;
            }
        }

        return $text;
    }

    /**
     * @param string $text
     * @return string
     * @throws \DeepL\DeepLException
     */
    public function translateCurrentToDefault(string $text): string
    {
        if ($this->service && $this->needTranslation()) {
            try {
                return $this->service->get($text, self::DEFAULT_LANGUAGE, $this->language);
            } catch (Throwable $e) {
                Logger::add($e->getMessage(), __CLASS__, Logger::ERROR);
                return $text;
            }
        }

        return $text;
    }
}