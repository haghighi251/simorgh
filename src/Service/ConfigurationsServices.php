<?php

namespace App\Service;
/**
 * 
 * In this trait, We will load some settings of application.
 * We will use these settings in each routs. 
 */
trait ConfigurationsServices {
    
    /**
     * 
     * @var type
     */
    public $lang;
    
    /**
     * 
     * This variable will keep a copy of SessionInterface instance.
     * @var type
     */
    public $session;

    public function __construct($session) {
        $this->setSession($session);
        $this->setLang();
    }

    /**
     * 
     * @param SessionInterface $session
     */
    public function setSession($session) {
        $this->session = $session;
    }

    /**
     * 
     * @return type
     */
    public function getSession() {
        return $this->session;
    }


    /**
     *
     * Set language to choose witch file must load from 
     * language directory. English is default if there 
     * is no any other option. 
     * @param type $lang
     */
    public function setLang($lang = null) {
        if (strlen($lang) == 5) {
            $this->lang = $lang;
        } elseif (strlen($this->session->get('local_lang')) == 5) {
            $this->lang = $this->session->get('local_lang');
        } else {
            $this->lang = 'en_EN';
        }
    }

    /**
     * 
     * @return type
     */
    public function getLang() {
        return $this->lang;
    }

}
