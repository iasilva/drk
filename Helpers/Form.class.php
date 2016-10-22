<?php

/**
 * Description of Form <br>
 * Cria partes úteis de formulários
 *
 * @author Ivan
 */
class Form {

    /**
     * Opções armazenadas do select
     */
    private static $options;

    /**
     * @var bool selected
     * caso já existe uma opção como selected, não verifica as outras 
     */
    private static $selected = FALSE;
    
    /**
     *
     * @var array, armazenas as classes que serõ utilizadas 
     */
    private static $class=array();

    /**
     * Armazena o html de retorno
     */
    private static $html = "";

    /**
     * Retorna uma string com todas as options do select
     * @param array $options - Array no formato $array("campo"=>array("valor"=>"valor"[,"selected"=>TRUE,"disabled"=> TRUE]));
     */
    public static function geraOpcoesSelect(array $options) {
        self::$selected=FALSE;
        
        self::$options = $options;
        try {
            self::geraOptions();
        } catch (Exception $e) {
            drkMsg($e->getMessage(), $e->getCode());
        }
        $opt= self::$html;
        self::$html=NULL;//Esvazia atributo html para a próxima chamada
        return $opt;
        
    }

    /**
     * Retorna o html das opções 
     */
    private static function geraOptions() {
        foreach (self::$options as $key => $value):
            $selected = (!self::$selected) ? self::verificaOpcaoSelecionada(self::$options[$key]) : "";
            $disabled = self::verificaDisabled(self::$options[$key]);
            $complementos = $selected . $disabled;
            $option = "<option value=\"{$key}\"{$complementos}>{$value['value']}</option>";
            self::$html.=$option;
        endforeach;
    }

    /**
     * Verifica se foi passado um índice [selected] para ser a opção selecionada
     * Havendo uma, marca o atributo selected como TRUE
     *  vem com a indicação de desabilitado.
     */
    private static function verificaOpcaoSelecionada($campodoArray) {
        $selected = NULL;
        if (isset($campodoArray["selected"]) && ($campodoArray["selected"] !== "" && $campodoArray["selected"] == TRUE)):
            $selected.=" selected = \"selected\" ";
            self::$selected = TRUE;
        endif;
        return $selected;
    }

    /**
     * Verifica se foi passado um índice [selected] para ser a opção selecionada
     * e procura por um indice [disabled] , caso exista o principal
     *  vem com a indicação de desabilitado.
     */
    private static function verificaDisabled($campodoArray) {
        $disabled = NULL;
        if (isset($campodoArray["disabled"]) && ($campodoArray["disabled"] !== "") && $campodoArray["disabled"] == TRUE):
            $disabled.=" disabled ";
        endif;
        return $disabled;
    }
    
    /**************Métodos para geração de botões****************/
    
    /**
     * 
     * @param string $type Tipo de botão(link,classic,submit)
     * @param string $label Label do botão
     * @param string $link Link, caso se trate de btn link
     */
    public static function createButton(string $type,string $label,string $link=""){
        self::$html="";        
        if($type==="link"):
            self::createButtonLink($link,$label);
        elseif($type==="submit") :
            self::createButtonSubmit($label);
        elseif($type==="classic") :
            self::createButtonClassic($label);
            else:
            throw new Exception(" Não conseguimos identificar o tipo de botão desejado",E_USER_WARNING);
        endif;
        return self::$html;
    }
    private static function createButtonLink($link,$label){
        $btn="<a href=\"$link\" class=\"btn ";
        foreach (self::$class as $classe):
            $btn.="{$classe} ";
        endforeach;
        $btn.="\">{$label}</a>";
        self::$html=$btn;
    }
    private static function createButtonClassic($label){
        $btn="<div class=\"btn ";
        foreach (self::$class as $classe):
            $btn.="{$classe} ";
        endforeach;
        $btn.="\">{$label}</div>";
         self::$html=$btn;
    }
    
    private static function createButtonSubmit($label){
        $btn="<input type='submit' class=\"btn ";
        foreach (self::$class as $classe):
            $btn.="{$classe} ";
        endforeach;
        $btn.="\" value='{$label}'>";
        self::$html=$btn;
    }
    public static function setClass(array $class) {
        self::$class = $class;
    }


    
    
}
