<?php


class BannedWords
{
    public static function StringContainsBannedWords(string $str) : bool
    {
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);

        $query = "SELECT word FROM banned_words ORDER BY word ASC";
        $con->executeQuery($query);
        $words = $con->getResults();

        foreach ($words as $word) {
            if (strpos(strtoupper($str), strtoupper($word['word'])) !== false) {
                return true;
            }
        }
        return false;
    }
}