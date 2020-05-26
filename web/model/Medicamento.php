<?php

class Medicamento{


    public $nome;
    private $ean1;
    private $bula;
    private $apresentacao;
    private $laboratorio;
    private $substancias;
    private $generico;
    private $similar;
    private $original;
    private $status;
    private $grupoSubstancia;

    /**
     * @param mixed $grupoSubstancia
     */
    public function setGrupoSubstancia($grupoSubstancia)
    {
        $this->grupoSubstancia = $grupoSubstancia;
    }
    /**
     * @return mixed
     */
    public function getGrupoSubstancia()
    {
        return $this->grupoSubstancia;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getLaboratorio()
    {
        return $this->laboratorio;
    }

    /**
     * @return mixed
     */
    public function getGenerico()
    {
        return $this->generico;
    }

    /**
     * @param mixed $generico
     */
    public function setGenerico($generico)
    {
        $this->generico = $generico;
    }

    /**
     * @return mixed
     */
    public function getSimilar()
    {
        return $this->similar;
    }

    /**
     * @param mixed $similar
     */
    public function setSimilar($similar)
    {
        $this->similar = $similar;
    }

    /**
     * @return mixed
     */
    public function getOriginal()
    {
        return $this->original;
    }

    /**
     * @param mixed $original
     */
    public function setOriginal($original)
    {
        $this->original = $original;
    }

    /**
     * @return mixed
     */
    public function getSubstancias()
    {
        return $this->substancias;
    }

    /**
     * @param mixed $substancias
     */
    public function setSubstancias($substancias)
    {
        $this->substancias = $substancias;
    }

    /**
     * @param mixed $laboratorio
     */
    public function setLaboratorio($laboratorio)
    {
        $this->laboratorio = $laboratorio;
    }

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