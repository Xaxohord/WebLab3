<?php
$word = 'ahb acb aeb aeeb adcb axeb';
$matches = [];
preg_match_all('/a..b/',$word,$matches);
$matches = $matches[0];
foreach ($matches as $match)
{
    echo $match . "\n";
}


