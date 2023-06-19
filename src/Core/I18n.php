<?php

namespace NiceModules\Core;

use NiceModules\Core\Service\DeepL\DeepLService;
use Symfony\Component\Translation\Translator;

abstract class I18n
{
    const DEFAULT_LANGUAGE = 'EN';

    protected string $language;
    protected Translator $translator;
    protected ?DeepLService $service = null;
    protected string $dir;
    protected array $translations;
    
    protected Config $config;

    public function __construct(string $language = null)
    {
        $this->config = Config::instance('core');

        $this->language = $language;

        if (!$this->language) {
            $this->language = self::DEFAULT_LANGUAGE;
        }

        if ($this->config->get('use_deepl_service')) {
            try {
                $this->service = new DeepLService();
            } catch (Throwable $e) {
                Logger::add($e->getMessage(), __CLASS__, Logger::ERROR);
            }
        }
    }

    /**
     * @return string
     */
    public function getLanguage(): string
    {
        return $this->language;
    }

    public function needTranslation(): bool
    {
        return $this->language != self::DEFAULT_LANGUAGE;
    }

}