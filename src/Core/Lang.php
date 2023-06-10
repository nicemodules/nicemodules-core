<?php

namespace NiceModules\Core;

use NiceModules\Core\Lang\Locales;
use NiceModules\Core\Service\DeepL\DeepLService;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Translation\Dumper\MoFileDumper;
use Symfony\Component\Translation\Dumper\PoFileDumper;
use Symfony\Component\Translation\Loader\MoFileLoader;
use Symfony\Component\Translation\Loader\PoFileLoader;
use Symfony\Component\Translation\Translator;

/**
 * Default system language is EN
 * Use this class to get or generate translation for interface phrases by "get" function
 */
class Lang
{
    const DEFAULT_LOCALE = 'en_GB';
    const DEFAULT_LANG = 'EN';

    protected string $locale;
    protected Translator $translator;
    protected DeepLService $service;
    protected string $dir;
    protected array $translations;
    protected string $domain;
    protected bool $needSave = false;

    public function __construct(string $locale)
    {
        $this->locale = $locale;

        if (!$this->locale) {
            $this->locale = self::DEFAULT_LOCALE;
        }

        $this->domain = Context::instance()->getActivePlugin()->getModule()->getCodeName();

        $this->service = new DeepLService();
    }

    /**
     * @param string $dir
     */
    public function setDir(string $dir): void
    {
        $this->dir = $dir;
    }

    protected function getTranslator(): Translator
    {
        if (!isset($this->translator)) {
            $this->initializeTranslator();
        }

        return $this->translator;
    }

    protected function initializeTranslator()
    {
        if (!isset($this->dir)) {
            $this->dir = Context::instance()->getActivePlugin()->getModule()->getLangDir();
        }

        $this->translator = new Translator($this->locale);

        $this->translator->addLoader('po', new PoFileLoader());
        $this->translator->addLoader('mo', new MoFileLoader());

        $poFile = $this->dir . DIRECTORY_SEPARATOR . $this->domain . '-' . $this->locale . '.po';
        $moFile = $this->dir . DIRECTORY_SEPARATOR . $this->domain . '-' . $this->locale . '.mo';

        $filesystem = new Filesystem();

        if ($filesystem->exists($poFile) && $filesystem->exists($moFile)) {
            $this->getTranslator()->addResource('po', $poFile, $this->locale, $this->domain);
            $this->getTranslator()->addResource('mo', $moFile, $this->locale, $this->domain);
        }
    }

    /**
     * Active plugin text translation function
     * @param $text
     * @return mixed|void
     * @throws \DeepL\DeepLException
     */
    public function get($text)
    {
        $locales = new Locales();
        $localeLang = $locales->getLocaleLang($this->locale);

        if ($this->needTranslation() && $this->getTranslator()->getCatalogue()->has($text, $this->domain)) {
            return $this->getTranslator()->getCatalogue()->get($text, $this->domain);
        } elseif ($localeLang) { // add translation using deepL service if not exist

            $result = $this->service->get($text, $localeLang);
            $this->addTranslation($text, $result);
            return $result;
        } else {
            return $text;
        }
    }

    /**
     * Add text translation to file
     * @param $text
     * @param $translation
     */
    protected function addTranslation($text, $translation)
    {
        $this->getTranslator()->getCatalogue($this->locale)->set($text, $translation, $this->domain);
        $this->needSave = true;
    }

    public function save()
    {
        if ($this->needSave) {
            $poFileDumper = new PoFileDumper();
            $poFileDumper->setRelativePathTemplate('%domain%-%locale%.%extension%');
            $moFileDumper = new MoFileDumper();
            $moFileDumper->setRelativePathTemplate('%domain%-%locale%.%extension%');

            $poFileDumper->dump($this->getTranslator()->getCatalogue(), ['path' => $this->dir]);
            $moFileDumper->dump($this->getTranslator()->getCatalogue(), ['path' => $this->dir]);
        }
    }

    public function __destruct()
    {
        if ($this->needTranslation()) {
            $this->save();
        }
    }

    protected function needTranslation(): bool
    {
        return $this->locale != self::DEFAULT_LOCALE;
    }

}