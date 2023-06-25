<?php

namespace NiceModules\Core\I18n;

use NiceModules\Core\I18n;
use NiceModules\Core\Logger;
use NiceModules\CoreModule\Model\Language;
use NiceModules\ORM\Manager;
use Throwable;

class OrmI18n extends I18n
{
    /**
     * Current language
     * @var string
     */
    protected string $language;
    protected array $activeLanguages;

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

    public function getActiveLanguages(): array
    {
        if (!isset($this->activeLanguages)) {
            $activeLanguages = Manager::instance()
                ->getRepository(Language::class)
                ->findBy(['active' => 1]);

            $this->activeLanguages = [];

            foreach ($activeLanguages as $language) {
                if (!in_array($language->get('shortcut'), $this->activeLanguages)) {
                    $this->activeLanguages[] = $language->get('shortcut');
                }
            }
        }
        
        return $this->activeLanguages;
    }

    /**
     * @param string $text
     * @return string
     * @throws Throwable
     */
    public function translate(string $text, $sourceLanguage, $targetLanguage): string
    {
        if($targetLanguage == 'EN'){
            $targetLanguage = 'EN-GB';
        }
        
        if ($this->service) {
            try {
                return $this->service->get($text, $sourceLanguage, $targetLanguage);
            } catch (Throwable $e) {
                Logger::add($e->getMessage(), __CLASS__, Logger::ERROR);
                return $text;
            }
        }

        return $text;
    }

}