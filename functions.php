<?php


add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
function my_theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );

}

function listaQconcorda($atts){
	$atts = shortcode_atts( array(
		'id' => '',
    'opiniao'=>''
	), $atts, 'listaQconcorda' );
	$retorno = '';
  $objetoVotos = array('politico' => 'voto');
	$linkVotos = 'https://www.camara.leg.br/SitCamaraWS/Proposicoes.asmx/ObterVotacaoProposicaoPorID?idProposicao='.$atts["id"];
	echo $linkVotos;
	$votos_vetor = wp_remote_get($linkVotos);
  $xml = simplexml_load_string($votos_vetor['body']);
  $json = json_encode($xml);
  $array = json_decode($json,TRUE);

  echo "<br>opiniao: ";  //trata da opinião
  switch ($atts['opiniao']) {
    case 's':
      $opiniaoMultiplier = 1;
      echo "Sim";
      break;

    case 'n':
      $opiniaoMultiplier = -1;
      echo "Não";
      break;

    default:
      $opiniaoMultiplier = 0;
      echo "Dê uma opinião!";
      break;
  }

  echo"<br>";
  echo "<pre>";

  foreach ($array['Votacoes'] as $key => $value) {

    foreach ($value['votos']['Deputado'] as $deputado => $values) {

      $politico = $values ['@attributes']['Nome'];
      $voto = $values ['@attributes']['Voto'];
      if(isset($objetoVotos[$politico])){

      }
      else{
        $objetoVotos[$politico] = 0;
      }
      $voto = preg_replace('/\s+/', '', $voto);   //retira whitespaces
      switch ($voto) {
        case 'Sim':
          $num = 1;
          break;
        case "Não":
          $num = -1;
          break;

        default:
          $num = 0;
          break;
      }

      $objetoVotos[$politico] = $objetoVotos[$politico] + ($num * $opiniaoMultiplier) ;

    }

  }
  print_r($objetoVotos);
  echo "</pre>";

	return $retorno;
}
add_shortcode('concordaPorID' , 'listaQconcorda');

function functionTito($atts){

}
?>
