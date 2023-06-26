<?php

namespace NiceModules\Core\I18n;

use DeepL\DeepLException;
use NiceModules\Core\I18n;
use NiceModules\Core\Logger;
use NiceModules\CoreModule\Model\Language;
use NiceModules\ORM\Exceptions\FailedToInsertException;
use NiceModules\ORM\Exceptions\FailedToUpdateException;
use NiceModules\ORM\Exceptions\PropertyDoesNotExistException;
use NiceModules\ORM\Exceptions\RepositoryClassNotDefinedException;
use NiceModules\ORM\Exceptions\RequiredAnnotationMissingException;
use NiceModules\ORM\Exceptions\UnknownColumnTypeException;
use NiceModules\ORM\Manager;
use ReflectionException;
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
    

    public function getActiveLanguages(): array
    {
        if (!isset($this->activeLanguages)) {
            $this->activeLanguages = Manager::instance()
                ->getRepository(Language::class)
                ->createQueryBuilder()
                ->where('active', 1)
                ->buildQuery()
                ->getResultArray();
        }

        return $this->activeLanguages;
    }

    public function getSelectedLanguage(): ?array
    {
        foreach ($this->getActiveLanguages() as $language){
            if($language['shortcut'] == $this->getLanguage()){
                return $language;
            }
        }
        
        return null;
    }
    
    public function getActiveLanguagesArray(): array
    {
        $languages = [];
        
        foreach ($this->getActiveLanguages() as $language) {
            $languages[] = $language['shortcut'];
        }

        return $languages;
    }

    /**
     * @param string $text
     * @param $sourceLanguage
     * @param $targetLanguage
     * @return string
     * @throws Throwable
     * @throws FailedToInsertException
     * @throws FailedToUpdateException
     * @throws PropertyDoesNotExistException
     * @throws RepositoryClassNotDefinedException
     * @throws RequiredAnnotationMissingException
     * @throws UnknownColumnTypeException
     * @throws ReflectionException
     */
    public function translate(string $text, $sourceLanguage, $targetLanguage): string
    {
        if ($targetLanguage == 'EN') {
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