<?php

class Medicamento{

    public $nome;
    private $ean1;
    private $bula;
    private $apresentacao;

    /**
     * @return mixed
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param mixed $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    /**
     * @return mixed
     */
    public function getEan1()
    {
        return $this->ean1;
    }

    /**
     * @param mixed $ean1
     */
    public function setEan1($ean1)
    {
        $this->ean1 = $ean1;
    }

    /**
     * @return mixed
     */
    public function getBula()
    {
        return $this->bula;
    }

    /**
     * @param mixed $bula
     */
    public function setBula($bula)
    {
        $this->bula = $bula;
    }

    /**
     * @return mixed
     */
    public function getApresentacao()
    {
        return $this->apresentacao;
    }

    /**
     * @param mixed $apresentacao
     */
    public function setApresentacao($apresentacao)
    {
        $this->apresentacao = $apresentacao;
    }
}