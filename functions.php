<?php
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
function my_theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );

}

function listaQconcorda($atts){
	$atts = shortcode_atts( array(
		'id' => ''
	), $atts, 'listaQconcorda' );
	$retorno = '';
	$linkVotos = 'http://www.camara.leg.br/SitCamaraWS/Proposicoes.asmx/ObterVotacaoProposicaoPorID?idProposicao='.$atts["id"];
	echo $linkVotos;
	$votos_vetor = wp_remote_get($linkVotos);
	echo "<pre>";
	print_r($votos_vetor);
		// $retorno = '<form action = "" method="GET">
	// 							<input type="radio" name="s_n" value="s" checked>sim<br>
	// 							<input type="radio"name="s_n" value="n">não
	// 							<input type="submit">
	// 						</form>';
	// if(isset($_GET["s_n"])){
	// 	echo "ei!";
	// }
	return $retorno;
}
add_shortcode('concordaPorID' , 'listaQconcorda');
?>
