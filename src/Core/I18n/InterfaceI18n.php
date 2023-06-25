<?php

namespace NiceModules\Core\I18n;

use NiceModules\Core\Context;
use NiceModules\Core\I18n;
use NiceModules\Core\Logger;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Translation\Dumper\MoFileDumper;
use Symfony\Component\Translation\Dumper\PoFileDumper;
use Symfony\Component\Translation\Loader\MoFileLoader;
use Symfony\Component\Translation\Loader\PoFileLoader;
use Symfony\Component\Translation\Translator;
use Throwable;

/**
 * Default interface language is EN
 * Use this class to get or generate translation for interface phrases by "get" function, using translation service
 */
class InterfaceI18n extends I18n
{
    protected string $domain;
    protected bool $needSave = false;
    
    public function __construct(string $language = null){
        parent::__construct($language);
        $this->domain = Context::instance()->getActivePlugin()->getModule()->getCodeName();
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

        $this->translator = new Translator($this->language);

        $this->translator->addLoader('po', new PoFileLoader());
        $this->translator->addLoader('mo', new MoFileLoader());

        $poFile = $this->dir . DIRECTORY_SEPARATOR . $this->domain . '-' . $this->language . '.po';
        $moFile = $this->dir . DIRECTORY_SEPARATOR . $this->domain . '-' . $this->language . '.mo';

        $filesystem = new Filesystem();

        if ($filesystem->exists($poFile) && $filesystem->exists($moFile)) {
            $this->getTranslator()->addResource('po', $poFile, $this->language, $this->domain);
            $this->getTranslator()->addResource('mo', $moFile, $this->language, $this->domain);
        }
    }

    /**
     * Interface texts translation function
     * Creates translations in om files if not exists
     * @param $text
     * @return string
     * @throws Throwable
     */
    public function get($text)
    {
        if ($this->needTranslation() && $this->getTranslator()->getCatalogue()->has($text, $this->domain)) {
            return $this->getTranslator()->getCatalogue()->get($text, $this->domain);
        } elseif ($this->needTranslation() && $this->service) {
            $result = $this->translate($text);
            $this->addTranslation($text, $result);
            return $result;
        } else {
            return $text;
        }
    }

    /**
     * @param string $text
     * @return string
     * @throws Throwable
     */
    public function translate(string $text): string
    {
        if($text === ''){
            return $text;
        }
        
        if($this->service){
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
     * Add text translation to file
     * @param $text
     * @param $translation
     */
    protected function addTranslation($text, $translation)
    {
        $this->getTranslator()->getCatalogue($this->language)->set($text, $translation, $this->domain);
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

   

}