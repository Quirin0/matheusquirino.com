<?php
session_start();
setlocale (LC_ALL, 'pt_BR');
date_default_timezone_set('America/Sao_Paulo');

$conn = mysqli_connect("sql106.epizy.com", "epiz_29961272", "BudOD54dgxdP7", "epiz_29961272_projetos");
//$conn = mysqli_connect("localhost", "root", "teteu123", "portfolio");


// $google_site_key = "";
// $google_secret_key = "";

// $google_analytics = "UA-175441042-1";

// $vb_nome_site = "Empório Serra à Vista"; 
// $vb_descricao_site = "O melhor e mais cobiçado restaurante do país. Venha conferir!"; 
// $vb_meta_site = "Empório Serra a Vista, restaurante, gourmet, café, café gourmet, restaurante serra, Serra a vista, comida, restaurante vale do paraíba";
// $vb_autor_site = "Virtua Brasil"; 
// $vb_sub_site = "Restaurante";
// $vb_img_og = "/img/og.jpg";
// $vb_endereco_fisico_site = "Rod. Floriano Rodrigues Pinheiro - 5190";
// $vb_endereco_fisico_cidade_site = "Tremembé";
// $vb_endereco_fisico_estado_site = "SP";
// $vb_endereco_fisico_pais_site = "Brasil";
// $vb_endereco_fisico_cep_site = "12120-000";
// $vb_endereco_fisico_latitude_site = "";
// $vb_endereco_fisico_longitude_site = "";
// $vb_telefone_site = "";
// $vb_whatsapp_site = "(12) 99658-3862";
// $vb_whatsapp_url_site = "";
// $vb_url_site = "https://www.emporioserraavista.com.br/novo";
// $vb_email_site = "contato@emporioserraavista.com.br";
// $vb_url_amigavel = "emporio-serra-a-vista";
// $vb_facebook = "https://www.facebook.com/emporioserraavista/";
// $vb_instagram = "https://www.instagram.com/emporioserraavista/";
// $vb_twitter = "";
// $vb_linkedin = "";
// $vb_meu_negocio = "";

function clean($string)
{
    $table = array(
        'Š'=>'S', 'š'=>'s', 'Đ'=>'Dj', 'đ'=>'dj', 'Ž'=>'Z',
        'ž'=>'z', 'Č'=>'C', 'č'=>'c', 'Ć'=>'C', 'ć'=>'c',
        'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A',
        'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
        'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I',
        'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O',
        'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U',
        'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss',
        'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a',
        'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e',
        'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i',
        'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o',
        'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u',
        'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b',
        'ÿ'=>'y', 'Ŕ'=>'R', 'ŕ'=>'r', '-'=>'',
    );
    //Traduz os caracteres em $string, baseado no vetor $table
    $string = trim($string);
    $string = strtr($string, $table);
    //converte para minúsculo
    $string = strtolower($string);
    //remove caracteres indesejáveis (que não estão no padrão)
    $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
    //Remove múltiplas ocorrências de hífens ou espaços
    $string = preg_replace("/[\s-]+/", " ", $string);
    //Transforma espaços e underscores em hífens
    $string = preg_replace("/[\s_]/", "-", $string);
    if (substr($string, -1) == '-') $string = substr($string, 0, -1);

    //retorna a string
    return $string;
}
?>