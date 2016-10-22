<?php

/**
 * Classe reponsável pela geração de tabelas
 * Ela deve receber um array com os cabeçalhos e uma matriz com as linhas
 * @author Ivan
 * @version 0.1 alpha
 * @copyright (c) 2016, Ivan Alves da Silva
 */
class Table {

    private $header; //Título
    private $colunas; //array de colunas
    private $linhas; //array de linhas
    private $cssClass; //Classes de css para a tabela
    private $htmlForTable;
    private $prefixo;

    /**
     *
     * @var type -aceita [edit,list] - Edit lança os botões de editar e excluir
     */
    private $type;

    /**
     * Classe responsável pela geração de tabelas
     * @param array $colunas - Array onde os values são os nomes das colunas
     * @param array $linhas - Array ou Matriz com as linhas que comporão a tabela
     * @param string $prefixo - Prefixo utilizado nos índices do array de linhas
     */
    public function __construct(array $colunas, array $linhas, $prefixo = "") {
        $this->colunas = $colunas;
        $this->linhas = $linhas;
        $this->prefixo = $prefixo;
    }

    /**
     * 
     * @param type $linkToView nome da action de view que será completada com o id do item
     * @param type $linkToEdit nome da action de edit que será completada com o id do item
     * @param type $linkToDelete nome da action de Delete que será completada com o id do item
     */
    public function getTableEdit() {
        if ($this->verificaColunas()):
            if ($this->verificaLinhas()):
                $this->createTableEdit();
                $this->showTable();
            endif;
        endif;
    }

    /**
     * Verifica se foi enviado um array no padrão para o preenchimento das colunas
     * @return boolean
     * @throws Exception Erro
     */
    private function verificaColunas() {
        if (is_array($this->colunas)):
            if (!is_array($this->colunas[0])):
                return TRUE;
            else:
                throw new Exception("Não conseguimos gerar a tabela." .
                "Parece que nos foi enviado uma matriz de colunas em " . __CLASS__
                , E_USER_ERROR);
            endif;
        else:
            throw new Exception("Não conseguimos gerar a tabela.Não identificamos o array de colunas em " . __CLASS__, E_USER_ERROR);
        endif;
    }

    /**
     * Verifica se foi enviado um array no padrão para o preenchimento das colunas
     * @return boolean
     * @throws Exception Erro
     */
    private function verificaLinhas() {
        if (!is_array($this->linhas)):
            throw new Exception("Não conseguimos gerar a tabela.Não identificamos o array de linhas em " . __CLASS__, E_USER_ERROR);
        else:
            return TRUE;
        endif;
    }

    private function createTableList() {
        
    }

    private function createTableEdit() {
        $this->htmlForTable = NULL;
        $this->htmlForTable = "<table style='font-size:11px;' class=\"table table-responsive table-hover\"><thead><tr>";
        $qtdColunas = count($this->colunas);

        for ($i = 0; $i < $qtdColunas; $i++):
            $action = "?action=up-" . substr($this->prefixo, 0, -1);
            $keys = array_keys($this->linhas[0]);
            $action.="&orderby=" . $keys[$i];
            $htmlForCol = "<th> <a href=\"$action\">{$this->colunas[$i]}</a></th>";
            $this->htmlForTable.=$htmlForCol;
        endfor;



//        foreach ($this->colunas as $coluna):
//            $this->htmlForTable.= "<th>{$coluna}</th>";
//        endforeach;

        $this->htmlForTable.="<th></th><th></th></tr></thead>";
        $this->createLinhasEdit();
        $this->htmlForTable.="</table>";
    }

    private function createLinhasList() {
        
    }

    private function createLinhasEdit() {
        foreach ($this->linhas as $linha):
            $this->htmlForTable.= "<tr>";
            foreach ($linha as $valor):
                $this->htmlForTable.= "<td>{$valor}</td>";
            endforeach;
            $in = substr($this->prefixo, 0, -1);          
            $this->htmlForTable.="<td><a href=\"?in={$in}&action=View&id={$linha[$this->prefixo . "id"]}\"><span class=\"glyphicon glyphicon-edit\"></span></a></td>";
            $this->htmlForTable.= "<td><a href=\"?in={$in}&action=Del&id={$linha[$this->prefixo . "id"]}\"><span class=\"glyphicon glyphicon-trash\"></span></a></td>";
            $this->htmlForTable.= "</tr>";
        endforeach;
    }

    private function showTable() {
        echo $this->htmlForTable;
    }

    /*     * ********getter********* */

    public function getHeader() {
        return $this->header;
    }

    public function getColunas() {
        return $this->colunas;
    }

    public function getLinhas() {
        return $this->linhas;
    }

    /*     * ********setter********* */

    public function setHeader($header) {
        $this->header = $header;
        return $this;
    }

    public function setColunas($colunas) {
        $this->colunas = $colunas;
        return $this;
    }

    public function setLinhas($linhas) {
        $this->linhas = $linhas;
        return $this;
    }

    public function setCssClass($cssClass) {
        $this->cssClass = $cssClass;
        return $this;
    }

}
