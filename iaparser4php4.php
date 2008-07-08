<?php

function ia_parse($xmlstr) {
  $parser = xml_parser_create('ISO-8859-1');
  xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
  xml_parse_into_struct($parser, $xmlstr, $values, $index);
  xml_parser_free($parser);
  $i = -1;
  return _ia_oai_getchildren($values, $i);
}

// internal function: build a node of the tree
function _ia_oai_buildtag($thisvals, $vals, &$i, $type) {
  $tag = array();  // php5 requires for arra_merge?
  if (isset($thisvals['attributes']))
    $tag['ATTRIBUTES'] = $thisvals['attributes'];
  // complete tag, just return it for storage in array
  if ($type === 'complete')
    $tag['VALUE'] = $thisvals['value'];
  // open tag, recurse
  else
    $tag = array_merge($tag, _ia_oai_getchildren($vals, $i));
  return $tag;
}

// internal function: build an nested array representing children
function _ia_oai_getchildren($vals, &$i) {
  $children = array();     // Contains node data
  // Node has CDATA before it's children
  if ($i > -1 && isset($vals[$i]['value']))
    $children['VALUE'] = $vals[$i]['value'];
  // Loop through children, until hit close tag or run out of tags
  while (++$i < count($vals)) {
    $type = $vals[$i]['type'];
    // 'cdata':    Node has CDATA after one of it's children
    //         (Add to cdata found before in this case)
    if ($type === 'cdata')
      $children['VALUE'] .= $vals[$i]['value'];
    // 'complete':    At end of current branch
    // 'open':    Node has children, recurse
    elseif ($type === 'complete' || $type === 'open') {
      $tag = _ia_oai_buildtag($vals[$i], $vals, $i, $type);
      if ($index_numeric) {
        $tag['TAG'] = $vals[$i]['tag'];
        $children[] = $tag;
      } else
        $children[$vals[$i]['tag']][] = $tag;
    }
    // 'close:    End of node, return collected data
    //        Do not increment $i or nodes disappear!
    elseif ($type === 'close')
        break;
  }
  if ($collapse_dups)
    if (is_array($children)) {
      foreach($children as $key => $value)
        if (is_array($value) && (count($value) == 1))
          $children[$key] = $value[0];
    }
  return $children;
}


?>