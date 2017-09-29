<?php
function motHasard($n)
{
    $voyelles = array('a', 'e', 'i', 'o', 'u', 'ou', 'io','oi','ai');
    $consonnes = array('b', 'c', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'm','n', 'p', 'r', 's', 't', 'v', 'w',
			'br','bl', 'cr','ch', 'dr', 'fr', 'rd', 'rf', 'fl', 'gr','gl','pr','pl','ps','st','tr','vr');
                            
    $mot = '';
    $nv = count($voyelles)-1;
    $nc = count($consonnes)-1;
	for($i = 0; $i < round($n/2); ++$i)
	{
		$mot .= $voyelles[mt_rand(0,$nv)];
		$mot .= $consonnes[mt_rand(0,$nc)];
	}
	return substr($mot,0,$n);
}

function captcha()
{
	$mot = motHasard(6);
	$_SESSION['captcha'] = $mot;
	return $mot;
}
?>
