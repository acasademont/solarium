<?php

require('init.php');
htmlHeader();

// create a client instance
$client = new Solarium_Client($config);

// get a select query instance
$query = $client->createSelect();

// search input string, this value fails without escaping because of the double-quote
$input = 'ATA "133';

// in this case phrase escaping is used (most common) but you can also do term escaping, see the manual
$query->setQuery('features:' . Solarium_Escape::phrase($input));

// this executes the query and returns the result
$resultset = $client->select($query);

// display the total number of documents found by solr
echo 'NumFound: '.$resultset->getNumFound();

// show documents using the resultset iterator
foreach ($resultset as $document) {

    echo '<hr/><table>';

    // the documents are also iterable, to get all fields
    foreach($document AS $field => $value)
    {
        // this converts multivalue fields to a comma-separated string
        if(is_array($value)) $value = implode(', ', $value);
        
        echo '<tr><th>' . $field . '</th><td>' . $value . '</td></tr>';
    }

    echo '</table>';
}

htmlFooter();