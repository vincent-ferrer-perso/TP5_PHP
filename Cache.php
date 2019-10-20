<?php

class Cache
{
    private $page;
    private $expiration;
    private $buffer;

    public function __construct($page){
        $this->page = $page;
    }

    public function getBuffer()
    {
        return $this->buffer;
    }
    public function setBuffer($buffer)
    {
        $this->buffer = $buffer;
    }

    public function getExpiration()
    {
        return filemtime('cache/' . $this->getPage() . '.html');
    }
    public function setExpiration($expiration)  //$expiration lie filemtime($file) qui renvoie date derniere modif $file
    {
        $this->expiration = $expiration;
    }

    public function getPage()
    {
        return $this->page;
    }
    public function setPage($page)
    {
        $this->page = $page;
    }

    public function cacheView(){
        if (file_exists(('cache/') . $this->getPage() . '.html')){
            if ($this->getExpiration() < time() + 3600){
                $this->setBuffer(readfile('cache/' . $this->getPage() . '.html'));
            }else{
                echo 'fichier cache trop ancien';
            }
        }else{
            echo 'fichier cache non trouvé';
        }
    }

    public function startBuffer(){
        ob_start();
    }


    public function endBuffer(){
        $this->setBuffer(ob_get_contents());
        ob_end_clean();
        $this->setPage(file_get_contents('cache/' . $this->getPage() .'.html', $this->getBuffer()));
        echo $this->getBuffer();
    }


}