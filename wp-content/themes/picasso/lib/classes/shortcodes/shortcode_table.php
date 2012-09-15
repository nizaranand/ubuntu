<?php
/*-----------------------------------------------------------------------------------*/
/* Table Shortcode
/*-----------------------------------------------------------------------------------*/

function ms_table( $atts ) {
    extract( shortcode_atts( array(
        'cols' => 'none',
        'data' => 'none',
    ), $atts ) );
    $cols = explode(',',$cols);
    $data = explode(',',$data);
    $total = count($cols);
    $output = '<table><tr class="th">';
    foreach($cols as $col):
        $output .= '<td>{$col}</td>';
    endforeach;
    $output .= '</tr><tr>';
    $counter = 1;
    foreach($data as $datum):
        $output .= '<td>{$datum}</td>';
        if($counter%$total==0):
            $output .= '</tr>';
        endif;
        $counter++;
    endforeach;
	$output .= '</table>';
    return $output;
}
add_shortcode( 'table', 'ms_table' );

?>