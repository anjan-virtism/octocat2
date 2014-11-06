<?php
/**
 * Created by PhpStorm.
 * User: Anjan
 * Date: 11/6/2014
 * Time: 6:27 PM
 */


    $sql = "select TABLE_NAME,VIEW_DEFINITION from information_schema.VIEWS where TABLE_SCHEMA = 'virtism_gsh' order by TABLE_NAME";

    $link = mysql_connect('localhost','root','overlord2004') or die('No db connection');

    mysql_select_db('virtism_gsh',$link) or die('No db!');

    $sql = "select TABLE_NAME as 'name',VIEW_DEFINITION as 'body' from information_schema.VIEWS where TABLE_SCHEMA = 'virtism_gsh' order by TABLE_NAME";

    $query = mysql_query($sql,$link);

    if($query) {

        $num_rows = mysql_affected_rows($link);

        $str = '';

        if($num_rows > 0) {

            $str .= '-- Number of views found: '.$num_rows.PHP_EOL.PHP_EOL;

            while($row = mysql_fetch_assoc($query)) {

                $name = $row['name'];
                $body = $row['body'];

                $str .= "DROP VIEW IF EXISTS `$name`;".PHP_EOL;
                $str .= "CREATE VIEW `$name` as $body;".PHP_EOL.PHP_EOL;

            }

        } else {

            $str .= '-- No views found!';

        }

        header('Content-Type: text/plain');

        echo $str;

    }